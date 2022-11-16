<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/cp/class/include.php';
require_once 'settings.php';

if($User->check_cp_authorization())
{
    if($User->access_control($Form->page_access($page_data['id'])))
    {
        $ar_get_clean = filter_input_array(INPUT_GET, FILTER_SANITIZE_SPECIAL_CHARS);
        $status_info = array();
        if (isset($ar_get_clean['id']))
        {
            $edit_elem_id =  $ar_get_clean['id'];
        }
        else
        {
            include_once $_SERVER['DOCUMENT_ROOT'].'/cp/php/templates/errors_in_url_address.php';
            exit();
        }



        if(isset($_POST['submit']))
        {
            $ar_post_clean = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

            $active = 0; if(isset($ar_post_clean['active'])) { $active = 1; }
            $sort = $db->escape($ar_post_clean['sort']);

            $data_list = Array (
                "active" => $active,
                'dep_id' => (int)$ar_post_clean['dep_id'],
                "sort"  => $sort
            );


            foreach ($list_of_site_langs as $site_langs)
            {
                $data_list['title_'.$site_langs] = $db->escape($ar_post_clean['title_'.$site_langs]);
                $data_list['page_title_'.$site_langs] = $db->escape($ar_post_clean['page_title_'.$site_langs]);
                $data_list['meta_k_'.$site_langs] = $db->escape($ar_post_clean['meta_k_'.$site_langs]);
                $data_list['meta_d_'.$site_langs] = $db->escape($ar_post_clean['meta_d_'.$site_langs]);
                $data_list['text_'.$site_langs] = $db->escape($ar_post_clean['text_'.$site_langs]);
            }

            $db->where ('id', $edit_elem_id);
            if ($db->update ($db_table, $data_list, 1))
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
                if( $Cpu->updateElementCpu($arrURL, $PAGE_ID, $edit_elem_id ) )
                {
                    $status_info['success'][] = dictionary('SUCCESSFULLY_UPDATED');
                }
            }
            else
            {
                $status_info['error'][] = $db->getLastError();
            }


        }

        if( $validator->check_int($edit_elem_id) && $edit_elem_id>0 )
        {
            $db->where ("id", $edit_elem_id);
            $element = $db->getOne ($db_table);
            if(!$element)
            {
                include_once $_SERVER['DOCUMENT_ROOT'].'/cp/php/templates/errors_in_url_address.php';
                exit();
            }

            $CPUs = array();
            $getCPUs = $db
                ->where ("page_id", $PAGE_ID)
                ->where ("elem_id", $edit_elem_id)
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
                    <?php
                    $current_user_id = $User->getId();
                    ?>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="white-box p-l-20 p-r-20">
                                <?php
                                show_status_info($status_info);
                                ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <form id="check_required_fields" class="form-material form-horizontal" method="post" action="" enctype="multipart/form-data">
                                            <div id="item_description">
                                                <ul class="tabs tabs1">
                                                    <li class="t1 tab-current"><a><?php echo dictionary('COMMON_DATA');?></a></li>
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
                                                    <?php
                                                    $Form->edit_active($element['active'],'active');
                                                    ?>
                                                    <div class="form-group">
                                                        <label class="col-md-12"><?php echo dictionary('DEPARTAMENT');?> <span style="color: red;">*</span></label>
                                                        <div class="col-md-12">
                                                            <select class="form-control" name="dep_id">
                                                                <?php
                                                                $get_department_data_info = $db
                                                                    ->where('active', 1)
                                                                    ->get('departaments');
                                                                if($get_department_data_info && count($get_department_data_info) >0)
                                                                {
                                                                    foreach ($get_department_data_info as $department_data_info)
                                                                    {
                                                                        ?>
                                                                        <option
                                                                            <?php if( isset($element['dep_id']) && $department_data_info['id'] == $element['dep_id']) { ?> selected <?php } ?>
                                                                                value="<?php echo $department_data_info['id'];?>">
                                                                            <?php echo $department_data_info['title_'.$lang];?>
                                                                        </option>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    $Form->edit_sort($element['sort'], 'sort');
                                                    ?>
                                                </div>

                                                <?php
                                                $c_tab = 2;
                                                foreach( $list_of_site_langs as $lang_index )
                                                {
                                                    ?>
                                                    <div class="t<?php echo $c_tab++?> tab_content">
                                                        <div class="sp_tab_indent"></div>
                                                        <?php
                                                        $Form->edit_title($element['title_'.$lang_index], 'title_'.$lang_index, 1);
                                                        $Form->edit_title($element['page_title_'.$lang_index], 'page_title_'.$lang_index, 0, dictionary('PAGE_TITLE'));
                                                        $Form->edit_cpu(@$CPUs[$lang_index], 'cpu_'.$lang_index);
                                                        $Form->edit_meta_keywords($element['meta_k_'.$lang_index], 'meta_k_'.$lang_index);
                                                        $Form->edit_meta_description($element['meta_d_'.$lang_index], 'meta_d_'.$lang_index);
                                                        $Form->edit_description($element['text_'.$lang_index], 'text_'.$lang_index);
                                                        ?>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>

                                            <button style="float:right;" type="submit" name="submit"
                                                    class="btn btn-success waves-effect waves-light m-r-10"><?php echo dictionary('SUBMIT');?>
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