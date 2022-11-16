<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/cp/class/include.php';
require_once( __DIR__ . "/../settings.php");

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


                            <?php
                            if ( $catalog_id == 0 )
                            {
                                ?>
                                <div class="label label-info label-rounded" style="float: right;">
                                    <a style="color:white;font-size: 14px;" href="<?php echo $Cpu->getURL(721);?>?section_id=<?=$catalog_id?>">
                                        <?php echo dictionary('ADD_SECTION');?>
                                    </a>
                                </div>
                                <div style="clear:both; height: 10px;"></div>
                                <?php
                            }
                            ?>

                            <?php
                            if ( $catalog_id > 0 )
                            {
                                ?>
                                <div class="label label-info label-rounded" style="float: right;">
                                    <a style="color:white;font-size: 14px;" href="<?php echo $Cpu->getURL(724);?>?section_id=<?=$catalog_id?>">
                                        <?php echo dictionary('ADD_ELEMENT');?>
                                    </a>
                                </div>
                                <?php
                            }
                            ?>



                            <div style="clear:both; height: 25px;">
                            </div>
                            <p class="text-muted"><?php echo dictionary('CATALOG_SECTIONS');?> <?php if(isset($Cat_info['title_'.$Main->lang]) && $Cat_info['title_'.$Main->lang]!="") { echo '<span style="color:#fb9678">"'.$Cat_info['title_'.$Main->lang].'"</span>'; }?></p>

                                <?php
                                if ( $catalog_id == 0  )
                                {
                                    ?>
                                    <div class="wrapper">
                                        <div class="table_wrap">
                                            <table class="table">
                                                <thead> 
                                                <tr>
                                                    <th><?php echo dictionary('TITLE');?></th>
                                                    <th><?php echo dictionary('IMAGE');?></th>
                                                    <td><?php echo dictionary('STATUS');?></td>
                                                    <th style="width: 100px;"></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $get_subcatalog_list = $db
                                                    ->where("section_id", $catalog_id )
                                                    ->orderBy("sort", "ASC")
                                                    ->get($db_catalog_table);
                                                foreach ($get_subcatalog_list as $subcatalog_list)
                                                {
                                                    ?>
                                                    <tr  <?php if($subcatalog_list['active'] == 0 ) { ?> class="inactive_element" <?php } ?>>
                                                        <td data-label="<?php echo dictionary('TITLE');?>"><?php echo $subcatalog_list['title_'.$Main->lang];?></td>
                                                        <td data-label="<?php echo dictionary('IMAGE');?>">
                                                            <?php
                                                            $imagethumg = '';
                                                            $image_path =  $_SERVER['DOCUMENT_ROOT'].'/uploads/'.$db_catalog_table.'/'.$subcatalog_list['image'];
                                                            if(isset($subcatalog_list['image']) && $subcatalog_list['image']!="" && is_file($image_path))
                                                            {
                                                                $imagethumg = newthumbs( $subcatalog_list['image'] , $db_catalog_table, 100, 100, 6, 0);
                                                                ?>
                                                                <img style="max-width: 100px; max-height: 100px;" src="<?php echo $imagethumg;?>">
                                                                <?php
                                                            }
                                                            ?>
                                                        </td>

                                                        <td data-label="<?php echo dictionary('STATUS');?>">
                                                            <div style="clear:both; margin-top: 10px;"></div>
                                                            <button
                                                                    data-element_table="<?php echo $db_catalog_table;?>"
                                                                    data-element_id="<?php echo $subcatalog_list['id'];?>"
                                                                    data-element_status="<?php echo $subcatalog_list['active'];?>"
                                                                    type="button"
                                                                    class="element_status btn <?php if($subcatalog_list['active'] == 0) { ?> btn-danger <?php } else { ?> btn-success <?php } ?> round_btn">
                                                                <?php if($subcatalog_list['active'] == 0) { echo dictionary('INACTIVE'); } else { echo dictionary('ACTIVE'); } ?>
                                                            </button>
                                                        </td>

                                                        <td class="table_td_a_button no_background">
                                                            <a href="<?php echo $Cpu->getURL(720); ?>?section_id=<?php echo $subcatalog_list['id'] ?>">
                                                                <button class="view_button" type="button" title="View"></button>
                                                            </a>
                                                            <a href="<?php echo $Cpu->getURL(722);?>?section_id=<?php echo $subcatalog_list['id'] ?>">
                                                                <button class="edit_button" type="button" title="Edit"></button>
                                                            </a>
                                                            <?php
                                                            if(!in_array($subcatalog_list['id'], $elements_catID_NO_DELETING))
                                                            {
                                                                ?>
                                                                <a href="<?php echo $Cpu->getURL(723);?>?section_id=<?php echo $subcatalog_list['id'] ?>"
                                                                   onclick="return confirm('<?php echo dictionary('CONFIRM_DELETE_CATALOG');?>');">
                                                                    <button class="delete_button" type="button"
                                                                            title="Delete"></button>
                                                                </a>
                                                                <?php
                                                            }
                                                            ?>
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

                                if ( $catalog_id > 0  )
                                {
                                    ?>
                                    <div class="wrapper">
                                        <div class="table_wrap">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th><?php echo dictionary('IMAGE');?></th>
                                                    <th><?php echo dictionary('TITLE');?></th>
                                                    <td><?php echo dictionary('STATUS');?></td>
                                                    <th style="width: 100px;"></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $get_subcatalog_list = $db
                                                    ->where("section_id", $catalog_id )
                                                    ->orderBy("sort", "ASC")
                                                    ->get($db_catalog_elements_table);
                                                foreach ($get_subcatalog_list as $subcatalog_list)
                                                {
                                                    ?>
                                                    <tr  <?php if($subcatalog_list['active'] == 0 ) { ?> class="inactive_element" <?php } ?>>
                                                        <td data-label="<?php echo dictionary('IMAGE');?>">
                                                            <?php
                                                            $imagethumg = '';
                                                            $image_path =  $_SERVER['DOCUMENT_ROOT'].'/uploads/'.$db_catalog_elements_table.'/'.$subcatalog_list['image'];
                                                            if(isset($subcatalog_list['image']) && $subcatalog_list['image']!="" && is_file($image_path))
                                                            {
                                                                $imagethumg = newthumbs( $subcatalog_list['image'] , $db_catalog_elements_table, 100, 100, 7, 0);
                                                                ?>
                                                                <img style="max-width: 100px; max-height: 100px;" src="<?php echo $imagethumg;?>">
                                                                <?php
                                                            }
                                                            ?>
                                                        </td>
                                                        <td data-label="<?php echo dictionary('TITLE');?>"><?php echo $subcatalog_list['title_'.$Main->lang];?></td>
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
                                                            <a href="<?php echo $Cpu->getURL(725);?>?section_id=<?php echo $catalog_id;?>&id=<?php echo $subcatalog_list['id']?>">
                                                                <button class="edit_button" type="button" title="Edit"></button>
                                                            </a>
                                                            <a href="<?php echo $Cpu->getURL(726);?>?id=<?php echo $subcatalog_list['id'] ?>"
                                                               onclick="return confirm('<?php echo dictionary('CONFIRM_DELETE_ELEMENT');?>');">
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
                                ?>

                        </div>
                    </div>
                </div>
                <!-- /.row -->
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


