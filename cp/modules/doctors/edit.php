<?php 
// dropzone files
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
            $show_on_main_page = 0; if( isset($ar_post_clean["show_on_main_page"]) && !empty($ar_post_clean["show_on_main_page"]) ) { $show_on_main_page = 1; }
            $section_id = '';
            if( isset($ar_post_clean['section_id']) && count($ar_post_clean['section_id']) > 0 )
            {
                $section_id = implode(",", $ar_post_clean['section_id']);
            }

            $data_list = Array (
                "active" => $active,
                'show_on_main_page' => $show_on_main_page,
                "d_id" => serialize($ar_post_clean['d_id']),
                "sort"  => $sort
            );

            foreach ($list_of_site_langs as $site_langs)
            {
                $data_list['title_'.$site_langs] = $db->escape($ar_post_clean['title_'.$site_langs]);
                $data_list['page_title_'.$site_langs] = $db->escape($ar_post_clean['page_title_'.$site_langs]);
                $data_list['meta_k_'.$site_langs] = $db->escape($ar_post_clean['meta_k_'.$site_langs]);
                $data_list['meta_d_'.$site_langs] = $db->escape($ar_post_clean['meta_d_'.$site_langs]);
                $data_list['text_'.$site_langs] = $db->escape($ar_post_clean['text_'.$site_langs]);
                $data_list['text_2_'.$site_langs] = $db->escape($ar_post_clean['text_2_'.$site_langs]);
                $data_list['text_3_'.$site_langs] = $db->escape($ar_post_clean['text_3_'.$site_langs]);
                $data_list['text_4_'.$site_langs] = $db->escape($ar_post_clean['text_4_'.$site_langs]);
                $data_list['text_5_'.$site_langs] = $db->escape($ar_post_clean['text_5_'.$site_langs]);
            }

            $db->where ('id', $edit_elem_id);
            if ($db->update ($db_table, $data_list, 1))
            {
                // ------------------------------ prelucrarea dropzone_files -----------------------
                $get_dropzone_status_info = $Form->post_dropzone_editing( $edit_elem_id, @$ar_post_clean['dropzone_files']);
                if ( count($get_dropzone_status_info) > 0 )
                {
                    foreach ( $get_dropzone_status_info as $dropzone_status_info)
                    {
                        $status_info['error'][] = $dropzone_status_info;
                    }
                }
                //END: ------------------------------ prelucrarea dropzone_files---------------------

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
                if( $Cpu->updateElementCpu($arrURL, $detail_page_id, $edit_elem_id ) )
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
                ->where ("page_id", $detail_page_id)
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
                                                    $Form->edit_checkbox($element['show_on_main_page'],'show_on_main_page', dictionary('CP_SHOW_ON_MAIN_PAGE'));

                                                    if(!empty($db_table_images))
                                                    {
                                                        $Form->edit_dropzone_files($db_table_images, $edit_elem_id,'Poza doctor');
                                                    }

                                                    ?>
                                                    <div class="form-group">
                                                        <label class="col-sm-12">Selectati departamentul</label>
                                                        <div class="col-sm-12">
                                                            <select multiple class="form-control" name="d_id[]" required size="10">
                                                                <?php
                                                                $unserialized_departaments = unserialize($element['d_id']);
                                                                $get_departaments = $db
                                                                    ->where('active', 1)
                                                                    ->orderBy('sort','asc')
                                                                    ->get('departaments');
                                                                if (count($get_departaments) > 0)
                                                                {
                                                                    foreach ($get_departaments as $departament) {
                                                                        ?>
                                                                        <option value="<?php echo $departament['id']; ?>" <?php if ( is_array($unserialized_departaments) && in_array($departament['id'], $unserialized_departaments) ) { echo ' selected'; } ?>><?php echo $departament['title_'.$lang]; ?></option>

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
                                                        $Form->edit_title($element['title_'.$lang_index], 'title_'.$lang_index, 1,'Numele/Prenumele');
                                                        $Form->edit_title($element['page_title_'.$lang_index], 'page_title_'.$lang_index, 1,'Numele/Prenumele Head');
                                                        $Form->edit_cpu(@$CPUs[$lang_index], 'cpu_'.$lang_index);
                                                        $Form->edit_meta_keywords($element['meta_k_'.$lang_index], 'meta_k_'.$lang_index);
                                                        $Form->edit_meta_description($element['meta_d_'.$lang_index], 'meta_d_'.$lang_index);
                                                        $Form->edit_description($element['text_'.$lang_index], 'text_'.$lang_index,'1','Servicii');
                                                        $Form->edit_description($element['text_2_'.$lang_index], 'text_2_'.$lang_index,'1','Info 1');
                                                        $Form->edit_description($element['text_3_'.$lang_index], 'text_3_'.$lang_index,'1','Info 2');
                                                        $Form->edit_description($element['text_4_'.$lang_index], 'text_4_'.$lang_index,'1','Info 3');
                                                        $Form->edit_description($element['text_5_'.$lang_index], 'text_5_'.$lang_index,'1','Info 4');
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


            <?php
            require_once $_SERVER['DOCUMENT_ROOT'].'/cp/js/dropzone_additionally_js.php';
            ?>
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
