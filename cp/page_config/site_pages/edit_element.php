<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/cp/class/include.php';
if($User->check_cp_authorization())
{
    if($User->access_control($client_access))
    {
        $ar_get_clean = filter_input_array(INPUT_GET, FILTER_SANITIZE_SPECIAL_CHARS);
        $status_info = array();
        if (isset($ar_get_clean['id']))
        {
            $id =  $ar_get_clean['id'];
        }
        else
        {
            include_once $_SERVER['DOCUMENT_ROOT'].'/cp/php/templates/errors_in_url_address.php';
            exit();
        }

        if(isset($_POST['submit']))
        {
            $ar_post_clean = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $data = array();

            if($User->access_control($developer_access))
            {
                $edit_by_user = 0; if(isset($ar_post_clean['edit_by_user']) && $ar_post_clean['edit_by_user'] == 'on') { $edit_by_user = 1; }
                $data['edit_by_user'] = $edit_by_user;
            }

            if( isset($ar_post_clean['access']) && count($ar_post_clean['access']) > 0 )
            {
                $access = '1,'.implode(",", $ar_post_clean['access']);
            }
            else
            {
                $access = 1;
            }

            $show_on_left_menu = 0; if(isset($ar_post_clean['show_on_left_menu'])) { $show_on_left_menu = 1; }
            $sort = $db->escape($ar_post_clean['sort']);

            $data['access'] = $access;
            $data['show_on_left_menu'] = $show_on_left_menu;
            $data['sort'] = $sort;


            if(isset($ar_post_clean['cp_page_parent_section']) && is_numeric($ar_post_clean['cp_page_parent_section']))
            {
                $cpu_parrent = $db->escape($ar_post_clean['cp_page_parent_section']);
                $data['cpu_parrent'] = (int)$cpu_parrent;
            }


            // Проверка раздела
            $check_element_info = $db
                ->where("id", $id)
                ->getOne ("pages");
            if($check_element_info)
            {
                if($id!=100) // Исключением возможности изменение урл/чпу для главных страниц
                {
                    $arrURL = array();
                    foreach( $list_of_site_langs as $lang_index )
                    {

                        $arrURL[$lang_index] = $ar_post_clean['cpu_' . $lang_index];
                        if ($arrURL[$lang_index] == '')
                        {
                            $arrURL[$lang_index] = $ar_post_clean['title_' . $lang_index];
                        }
                    }

                    $arrURL = $Cpu->checkCpu($arrURL);

                    if( !($Cpu->updateCpu($arrURL, $id)) )
                    {
                        $status_info['error'][] = dictionary('CPU_ADDING_ERROR');
                    }
                }

                foreach ($list_of_site_langs as $site_langs)
                {
                    $data['title_'.$site_langs] = $db->escape($ar_post_clean['title_'.$site_langs]);
                    $data['page_title_'.$site_langs] = $db->escape($ar_post_clean['page_title_'.$site_langs]);
                    $data['meta_k_'.$site_langs] = $db->escape($ar_post_clean['meta_k_'.$site_langs]);
                    $data['meta_d_'.$site_langs] = $db->escape($ar_post_clean['meta_d_'.$site_langs]);
                    $data['text_'.$site_langs] = $db->escape($ar_post_clean['text_'.$site_langs]);
                }

                $db->where ('id', $id);
                if ($db->update ('pages', $data, 1))
                {
                    $status_info['success'][] = dictionary('SUCCESSFULLY_ADDED');
                }
                else
                {
                    $status_info['error'][] = $db->getLastError();
                }
            }

        }

        if( $validator->check_int($id) && $id>0 )
        {

            if(!$User->access_control($developer_access))
            {
                $page_info = $db
                    ->where ("id", $id)
                    ->where("edit_by_user", 1)
                    ->getOne ("pages");
            }
            else
            {
                $page_info = $db
                    ->where ("id", $id)
                    ->getOne ("pages");
            }

            if(!$page_info)
            {
                include_once $_SERVER['DOCUMENT_ROOT'].'/cp/php/templates/errors_in_url_address.php';
                exit();
            }

            $CPUs = array();
            $getCPUs = $db
                ->where ("page_id", $id)
                ->where ("elem_id", 0)
                ->get("cpu");
            foreach($getCPUs as $elem_cpu)
            {
                $CPUs[$elem_cpu['lang']] = $elem_cpu['cpu'];
            }
            ?>


            <?php
            include $_SERVER['DOCUMENT_ROOT'] . '/cp/php/templates/header.php';
            include $_SERVER['DOCUMENT_ROOT'] . '/cp/php/templates/left-sidebar.php';
            ?>
            <!-- Page Content -->
            <div id="page-wrapper">
                <div class="container-fluid">
                    <?php $Cpu->top_block_info($cutpageinfo);?>
                    <!-- .row -->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="white-box p-l-20 p-r-20">
                                <h3 class="page-title"><?php echo $page_info['title_'.$Main->lang];?></h3>
                                <?php
                                show_status_info($status_info);
                                ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <form id="check_required_fields" class="form-material form-horizontal" method="post" action="">
                                            <div id="item_description">
                                                <ul class="tabs tabs1">
                                                    <li class="t1 tab-current"><a>Общие данные</a></li>
                                                    <?php
                                                    $cur_tab = 2;
                                                    foreach( $list_of_site_langs as $tab_name )
                                                    {
                                                        ?>
                                                        <li class="t<?php echo $cur_tab?>"><a><?php echo mb_ucfirst($tab_name)?></a></li>
                                                        <?php
                                                        $cur_tab++;
                                                    }
                                                    ?>
                                                </ul>
                                                <!-- Первая вкладка -->
                                                <div class="t1 tab_content" style="display: block;">
                                                    <div class="sp_tab_indent"></div>

                                                    <div class="form-group">
                                                        <label class="col-md-12">
                                                            <?php echo dictionary('PAGE');?>
                                                        </label>
                                                        <div class="col-md-12">
                                                            <?php echo  $page_info['page']; ?>
                                                        </div>
                                                    </div>


                                                    <?php
                                                    if( isset($page_info['assoc_table']) && !empty($page_info['assoc_table']))
                                                    {
                                                        ?>
                                                        <div class="form-group" style="display:none;">
                                                            <label class="col-md-12"><?php echo dictionary('ASSOCIATED_TABLE');?>
                                                                <span class="red_star">*</span></label>
                                                            <div class="col-md-12">
                                                                <?php echo $page_info['assoc_table']; ?>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>


                                                    <?php
                                                    if( isset($page_info['type']) && $page_info['type'] == 10 )
                                                    {
                                                    ?>
                                                    <div class="form-group" style=" margin-top: 5px;">
                                                        <label class="col-md-12"><?php echo dictionary('SPECIFY_TARENT_SECTION');?>
                                                            <div class="col-md-12">
                                                                <select class="form-control" name="cp_page_parent_section" id="cp_page_parent_section">
                                                                    <option <?php if($page_info['cpu_parrent'] == 1) { ?> selected <?php } ?> value="1">---</option>
                                                                    <?php
                                                                    $get_page_parents = $db
                                                                        ->where('type', 0)
                                                                        ->orWhere('type', 10)
                                                                        ->orderBy('title_'.$lang, 'asc')
                                                                        ->get('pages');
                                                                    if(count($get_page_parents) > 0 )
                                                                    {
                                                                        foreach ($get_page_parents as $page_parents)
                                                                        {
                                                                            ?>
                                                                            <option
                                                                                <?php if($page_info['cpu_parrent'] == $page_parents['id']) { ?> selected <?php } ?>
                                                                                    value="<?php echo $page_parents['id'];?>">
                                                                                <?php echo $page_parents['title_'.$lang];?>
                                                                            </option>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                    </div>
                                                        <?php
                                                    }
                                                    ?>

                                                    <div class="form-group">
                                                        <label class="col-md-12"><?php echo dictionary('EDIT_BY_USER');?></label>
                                                        <div class="col-md-12">
                                                            <input type="checkbox" name="edit_by_user"
                                                                <?php if($page_info['edit_by_user'] == 1)  { ?> checked="checked" <?php } ?>
                                                                   class="form-control" placeholder="" style="float: left; width: 50px;">
                                                        </div>
                                                    </div>

                                                    <hr />


                                                    <div class="form-group">
                                                        <label class="col-md-12"><?php echo dictionary('ACCESSIBILITY');?></label>
                                                        <div class="col-md-12">
                                                            <?php
                                                            $page_access = explode(',',$page_info['access']);
                                                            //show($page_access);
                                                            $get_access_type_info = $db
                                                                ->get("user_group");
                                                            if($get_access_type_info && count($get_access_type_info) > 0 )
                                                            {
                                                                foreach($get_access_type_info as $access_type_info)
                                                                {
                                                                    if($access_type_info['id'] != 1)
                                                                    {
                                                                        ?>
                                                                        <div style="float: left;margin-right: 100px;">
                                                                            <label><?php echo $access_type_info['title_'.$Main->lang];?></label>
                                                                            <div class="clear"></div>
                                                                            <input type="checkbox" name="access[]" value="<?php echo $access_type_info['id'];?>"
                                                                                <?php if(in_array($access_type_info['id'], $page_access)) { ?> checked="checked" <?php } ?>
                                                                                   class="form-control" placeholder="" style="float: left; width: 50px;">
                                                                        </div>
                                                                        <?php
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <hr />



                                                    <div class="form-group">
                                                        <label class="col-md-12"><?php echo dictionary('SHOW_ON_LEFT_MENU');?></label>
                                                        <div class="col-md-12">
                                                            <input type="checkbox" name="show_on_left_menu"
                                                                <?php if($page_info['show_on_left_menu'] == 1)  { ?> checked="checked" <?php } ?>
                                                                   class="form-control" placeholder="" style="float: left; width: 50px;">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-md-12"><?php echo dictionary('SORT');?></label>
                                                        <div class="col-md-12">
                                                            <input type="number" name="sort" value="<?php echo $page_info['sort'];?>"
                                                                   class="form-control" placeholder="">
                                                        </div>
                                                    </div>

                                                </div>

                                                <?php
                                                $c_tab = 2;
                                                foreach( $list_of_site_langs as $lang_index )
                                                {
                                                    ?>
                                                    <div class="t<?php echo $c_tab++?> tab_content">
                                                        <div class="sp_tab_indent"></div>

                                                        <div class="form-group">
                                                            <label class="col-md-12"><?php echo dictionary('TITLE');?> <span style="color: red;">*</span></label>
                                                            <div class="col-md-12">
                                                                <input type="text" name="title_<?php echo $lang_index?>" value="<?php echo $page_info['title_'.$lang_index];?>"
                                                                       class="form-control required" placeholder="">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-md-12"><?php echo dictionary('PAGE_TITLE');?></label>
                                                            <div class="col-md-12">
                                                                <input type="text" name="page_title_<?php echo $lang_index?>" value="<?php echo $page_info['page_title_'.$lang_index];?>"
                                                                       class="form-control" placeholder="">
                                                            </div>
                                                        </div>

                                                        <?php
                                                        if($id!=100) // Исключением возможности изменение урл/чпу для главных страниц
                                                        {
                                                            ?>
                                                            <div class="form-group">
                                                                <label class="col-md-12"><?php echo dictionary('CPU');?></label>
                                                                <div class="col-md-12">
                                                                    <input type="text" name="cpu_<?php echo $lang_index?>" value="<?php echo @$CPUs[$lang_index];?>"
                                                                           class="form-control" placeholder="">
                                                                </div>
                                                            </div>
                                                            <?php
                                                        }
                                                        ?>

                                                        <div class="form-group">
                                                            <label class="col-md-12"><?php echo dictionary('SEO_META_KEY');?></label>
                                                            <div class="col-md-12">
                                                                <input type="text" name="meta_k_<?php echo $lang_index?>" value="<?php echo $page_info['meta_k_'.$lang_index];?>"
                                                                       class="form-control" placeholder="">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-12"><?php echo dictionary('SEO_META_DESCRIPTION');?></label>
                                                            <div class="col-md-12">
                                                                <input type="text" name="meta_d_<?php echo $lang_index?>" value="<?php echo $page_info['meta_d_'.$lang_index];?>"
                                                                       class="form-control" placeholder="">
                                                            </div>
                                                        </div>

                                                        <?php
                                                            $Form->edit_description($page_info['text_'.$lang_index], 'text_'.$lang_index);
                                                        ?>

                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                            <button style="float:right;" type="submit" name="submit"
                                                    class="btn btn-success m-r-10"><?php echo dictionary('SUBMIT');?>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
                    <?php include $_SERVER['DOCUMENT_ROOT'] . '/cp/php/templates/right-sidebar.php'; ?>
                </div>
                <!-- /.container-fluid -->
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/cp/php/templates/footer.php'; ?>
            </div>
            <!-- /#page-wrapper -->
            </div>
            <!-- /#wrapper -->

            </body>

            </html>
            <?php
        }
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