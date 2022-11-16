<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/cp/class/include.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/cp/catalog/settings.php';

if($User->check_cp_authorization())
{
    if($User->access_control($Form->page_access($page_data['id'])))
    {

        $ar_get_clean = filter_input_array(INPUT_GET, FILTER_SANITIZE_SPECIAL_CHARS);
        $status_info = array();
        if (isset($ar_get_clean['section_id']))
        {
            $catalog_id =  $ar_get_clean['section_id'];
        }
        else
        {
            $catalog_id = 0;
        }

        $CATALOG_LEVEL = $Main->catalog_level($catalog_id);

        $Cat_info = array();
        if($catalog_id == 0)
        {
            $Cat_info['title_'.$Main->lang] = '';
        }
        else
        {
            $Cat_info = $db
                ->where("id", $catalog_id)
                ->getOne($db_catalog_table);
        }


        include $_SERVER['DOCUMENT_ROOT'].'/cp/php/templates/header.php';
        include $_SERVER['DOCUMENT_ROOT'].'/cp/php/templates/left-sidebar.php';
        ?>
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <?php $Cpu->top_block_info($cutpageinfo);?>

                <!-- /row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="white-box">
                            <div class="label label-info label-rounded" style="float: right;">
                                <a style="color:white;font-size: 14px;" href="<?php echo $Cpu->getURL(74);?>">
                                    <?php echo dictionary('ADD_ELEMENT');?>
                                </a>
                            </div>

                            <div style="clear:both; height: 25px;"></div>
                                <div class="col-md-12">
                                    <?php
                                    if( isset($ar_get_clean['search_by_catalog']) &&  is_numeric($ar_get_clean['search_by_catalog']) && $ar_get_clean['search_by_catalog'] > 0)
                                    {
                                        $search_by_catalog = (int)$ar_get_clean['search_by_catalog'];
                                    }

                                    if( isset($ar_get_clean['search_by_status']) &&  is_numeric($ar_get_clean['search_by_status']) && ( $ar_get_clean['search_by_status'] == 0 || $ar_get_clean['search_by_status'] == 1) )
                                    {
                                        $search_by_status = (int)$ar_get_clean['search_by_status'];
                                    }

                                    if( isset($ar_get_clean['search_by_title']) && trim($ar_get_clean['search_by_title']) != '' )
                                    {
                                        $search_by_title = $db->escape($ar_get_clean['search_by_title']);
                                    }
                                    ?>
                                    <form class="form-material form-horizontal" method="get" action="">
                                        <div class="col-sm-12 col-md-4 text-center">
                                            <div class="form-group">
                                                <label><?php echo dictionary('CATALOGS');?></label>
                                                <div>
                                                    <select name="search_by_catalog">
                                                        <option></option>
                                                        <?php
                                                        $tree = $Main->getChildren(0);
                                                        if(isset($search_by_catalog))
                                                        {
                                                            $Main->display_option_catalog_children( $search_by_catalog, $tree, 0);
                                                        }
                                                        else
                                                        {
                                                            $Main->display_option_catalog_children( 0, $tree, 0);
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-4 text-center">
                                            <div class="form-group">
                                                <label><?php echo dictionary('STATUS');?></label>
                                                <div>
                                                    <select name="search_by_status">
                                                        <option></option>
                                                        <option <?php if(isset($search_by_status) && $search_by_status == 0) { ?> selected <?php } ;?> value="0"><?php echo dictionary('INACTIVE');?></option>
                                                        <option <?php if(isset($search_by_status) && $search_by_status == 1) { ?> selected <?php } ;?> value="1"><?php echo dictionary('ACTIVE');?></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-4 text-center">
                                            <div class="form-group">
                                                <label><?php echo dictionary('TITLE');?></label>
                                                <div>
                                                    <input style="margin-top: 1px;" type="text" name="search_by_title" value="<?php if(isset($search_by_title)) { echo $search_by_title; } ?>" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="clear"></div>
                                        <div class="text-center" style="margin: 10px 0 25px 0;">
                                            <button type="submit"
                                                    class="btn btn-success waves-effect waves-light m-r-10"><?php echo dictionary('SEARCH');?>
                                            </button>
                                        </div>

                                    </form>
                                </div>
                            <div style="clear:both; height: 25px;"></div>
                            <p class="text-muted"></p>
                            <?php
                            $query_catalog = "";
                            $query_status = "";
                            $query_title = "";
                            if(isset($search_by_catalog))
                            {
                                $curent_catalog_children = $Functions->getDirectoryChildren( $search_by_catalog, 'catalog');
                                array_unshift($curent_catalog_children, $search_by_catalog);
                                $curent_catalog_children_separated = implode(",", $curent_catalog_children);
                                $query_catalog = " AND section_id IN (".$curent_catalog_children_separated.") ";
                            }
                            if(isset($search_by_status))
                            {
                                $query_status = " AND active = ".$search_by_status;
                            }
                            if(isset($search_by_title))
                            {
                                foreach( $list_of_site_langs as $lang_info )
                                {
                                    if ($lang_info == $list_of_site_langs[0])
                                    {
                                        $query_title = " AND ( title_".$lang_info." LIKE '%".$search_by_title."%' ";
                                    }
                                    else
                                    {
                                        $query_title .= " OR title_".$lang_info." LIKE '%".$search_by_title."%' ";
                                    }
                                    if ($lang_info == last_element_of_array($list_of_site_langs) )
                                    {
                                        $query_title .= " )";
                                    }
                                }
                            }
                            ?>


                            <?php
                            $totalObjects=0;
                            $start=0;
                            $perPage = $num_page;
                            if(!isset($_GET['page']) || !is_numeric($_GET['page'])){$page = 1;}else{$page = (int)$_GET['page'];}

                            $get_totalObjects = $db
                                ->rawQuery('
                                                                              SELECT * 
                                                                              
                                                                              FROM '.$db::$prefix.$db_catalog_elements_table.' 
                                                                              
                                                                              WHERE
                                                                                            1
                                                                                    '.$query_catalog.'
                                                                                    '.$query_status.'
                                                                                    '.$query_title.'
                                                                        
                                                                              
                                                                              ');

                            if(count($get_totalObjects)>0)
                            {
                                $totalObjects = count($get_totalObjects);
                            }

                            $Count = $totalObjects;
                            $Pages = ceil($Count/$perPage); if($page>$Pages){$page = $Pages;}
                            $start = $page * $perPage - $perPage;
                            if($start<0) {$start = 0;}
                            //echo "start: ".$start;
                            ?>
                                <?php
                                $get_subcatalog_list = $db
                                                            ->rawQuery('
                                                                              SELECT * 
                                                                              
                                                                              FROM '.$db::$prefix.$db_catalog_elements_table.' 
                                                                              
                                                                              WHERE
                                                                                            1
                                                                                    '.$query_catalog.'
                                                                                    '.$query_status.'
                                                                                    '.$query_title.'
                                                                                    
                                                                                    LIMIT '.$start.', '.$perPage.'
                                                                              
                                                                              ');

                                if($get_subcatalog_list && count($get_subcatalog_list) > 0)
                                {
                                    ?>
                                    <div class="wrapper">
                                        <div class="table_wrap">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th style="width: 30%;"><?php echo dictionary('IMAGE');?></th>
                                                    <th><?php echo dictionary('TITLE');?></th>
                                                    <td><?php echo dictionary('STATUS');?></td>
                                                    <th style="width: 100px;"></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                foreach ($get_subcatalog_list as $subcatalog_list)
                                                {
                                                    ?>
                                                    <tr class="element_style <?php if ($subcatalog_list['active'] == 0) { ?> inactive_element <?php } ?>">
                                                        <td data-label="<?php echo dictionary('IMAGE');?>">
                                                            <?php
                                                            $imagethumg = '';
                                                            $image_path = $_SERVER['DOCUMENT_ROOT'] . '/uploads/' . $db_catalog_elements_table . '/' . $subcatalog_list['image'];
                                                            if (isset($subcatalog_list['image']) && $subcatalog_list['image'] != "" && is_file($image_path)) {
                                                                $imagethumg = newthumbs($subcatalog_list['image'], $db_catalog_elements_table, 100, 100, 2, 0);
                                                                ?>
                                                                <div class="col-md-12" style="text-align: center;">
                                                                    <img style="max-width: 100px; max-height: 100px;"
                                                                         src="<?php echo $imagethumg; ?>">
                                                                </div>
                                                                <?php
                                                            }
                                                            ?>
                                                        </td>
                                                        <td data-label="<?php echo dictionary('TITLE');?>"><?php echo $subcatalog_list['title_' . $Main->lang]; ?></td>
                                                        <td data-label="<?php echo dictionary('STATUS');?>">
                                                            <div style="clear:both; margin-top: 10px;"></div>
                                                            <button
                                                                    data-element_table="<?php echo $db_catalog_elements_table;?>"
                                                                    data-element_id="<?php echo $subcatalog_list['id'];?>"
                                                                    data-element_status="<?php echo $subcatalog_list['active'];?>"
                                                                    type="button"
                                                                    class="element_status btn <?php if($subcatalog_list['active'] == 0) { ?> btn-danger <?php } else { ?> btn-success <?php } ?> round_btn">
                                                                <?php if($subcatalog_list['active'] == 0) { echo dictionary('INACTIVE'); } else { echo dictionary('ACTIVE'); } ?>
                                                            </button>
                                                        </td>
                                                        <td class="table_td_a_button no_background">
                                                            <a href="<?php echo $Cpu->getURL(75); ?>?section_id=<?php echo $catalog_id; ?>&id=<?php echo $subcatalog_list['id'] ?>">
                                                                <button class="edit_button" type="button" title="Edit"></button>
                                                            </a>
                                                            <a href="<?php echo $Cpu->getURL(76); ?>?id=<?php echo $subcatalog_list['id'] ?>"
                                                               onclick="return confirm('<?php echo dictionary('CONFIRM_DELETE_ELEMENT'); ?>');">
                                                                <button class="delete_button" type="button"
                                                                        title="Delete"></button>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                                </tbody>
                                                <tfoot>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <div class="nothing_found">
                                        <?php echo dictionary('CP_NOTHING_FOUNDED');?>
                                    </div>
                                    <?php
                                }
                                ?>

                        </div>
                    </div>
                </div>
                <!-- /.row -->
                <?php include $_SERVER['DOCUMENT_ROOT'].'/cp/include/pagination.php'; ?>

                <?php include $_SERVER['DOCUMENT_ROOT'].'/cp/php/templates/right-sidebar.php'; ?>
            </div>
            <!-- /.container-fluid -->
            <?php include $_SERVER['DOCUMENT_ROOT'].'/cp/php/templates/footer.php'; ?>
        </div>
        <!-- /#page-wrapper -->
        </div>
        <!-- /#wrapper -->
        </body>

        </html>
        <?php
    }
    else
    {
        include_once $_SERVER['DOCUMENT_ROOT'].'/cp/php/templates/not_authorized_to_view_page.php';
    }
}
else
{
    header("location: ".$Cpu->getURL(5));
}

?>


