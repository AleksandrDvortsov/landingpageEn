<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/cp/class/include.php';
require_once 'settings.php';

if($User->check_cp_authorization())
{
    if($User->access_control($developer_access))
    {
        $status_info = array();
        if(isset($_POST['submit']))
        {
            $ar_post_clean = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

            $date =  new DateTime();
            $show_on_main_page = 0; if( isset($ar_post_clean["show_on_main_page"]) && !empty($ar_post_clean["show_on_main_page"]) ) { $show_on_main_page = 1; }
            $sort = $db->escape($ar_post_clean['sort']);
            $isOnline = 0; if( isset($ar_post_clean["isOnline"]) && !empty($ar_post_clean["isOnline"]) ) { $isOnline = 1; }

            $data_list = Array (
                "d_id" => serialize($ar_post_clean['d_id']),
                'show_on_main_page' => $show_on_main_page,
                "createdAt" => $db->now(),
                "sort"  => $sort,
                "isOnline" => $isOnline,
                "id_1c" => $db->escape($ar_post_clean['id_1c'])
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

            $inserted_id_result = $db->insert ($db_table, $data_list);
            if ($inserted_id_result)
            {
                $Form->post_dropzone_adding( $inserted_id_result, @$ar_post_clean['dropzone_files']);
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

                if( $Cpu->insertCpu( $arrURL, $detail_page_id, $inserted_id_result ) )
                {
                    $status_info['success'][] = dictionary('SUCCESSFULLY_ADDED');
                }
                else
                {
                    $status_info['error'][] = dictionary('CPU_ADDING_ERROR');
                }
             }
        }

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
                            <?php
                            show_status_info($status_info);
                            ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <form id="check_required_fields" class="form-material form-horizontal" method="post" action="" enctype="multipart/form-data">
                                        <div id="item_description">
                                            <?php
                                            $Form->add_checkbox('show_on_main_page', dictionary('CP_SHOW_ON_MAIN_PAGE'));
                                            ?>
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

                                                $Form->edit_checkbox($element['isOnline'],'isOnline', dictionary('ISONLINE'));
                                                $Form->edit_title($element['id_1c'], 'id_1c', 1,'1c_ID');

                                                if(!empty($db_table_images))
                                                {
                                                    $Form->add_dropzone_files($db_table_images,'Poza Doctor');
                                                }
                                                    ?>
                                                <div class="form-group">
                                                    <label class="col-sm-12">Selectati departamentul</label>
                                                    <div class="col-sm-12">
                                                        <select multiple class="form-control" name="d_id[]" required size="10">
                                                            <?php
                                                            $get_departaments = $db
                                                                ->where('active', 1)
                                                                ->orderBy('sort','asc')
                                                                ->get('departaments');
                                                            if (count($get_departaments) > 0)
                                                            {
                                                                foreach ($get_departaments as $departament) {
                                                                    ?>
                                                                    <option value="<?php echo $departament['id']; ?>"><?php echo $departament['title_'.$lang]; ?></option>

                                                                    <?php
                                                                }
                                                            }

                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <?php
                                                $sort_count = '';
                                                $get_tarifs_list = $db
                                                    ->orderBy('id','desc')
                                                    ->getOne($db_table);
                                                if (count($get_tarifs_list) >= 0)
                                                {
                                                    $sort_count = $get_tarifs_list['sort'] + 1;
                                                }
                                                ?>
                                                <div class="form-group">
                                                    <label class="col-md-12">Sortare <span style="color: red;">*</span></label>
                                                    <div class="col-md-12">
                                                        <input type="number" name="sort" class="form-control required" value="<?php echo $sort_count; ?>">
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
                                                    <?php
                                                    $Form->add_title('title_'.$lang_index, 1, 'Numele/Prenumele');
                                                    $Form->add_title('page_title_'.$lang_index, 1, 'Numele/Prenumele Head');
                                                    $Form->add_cpu('cpu_'.$lang_index);
                                                    $Form->add_meta_keywords('meta_k_'.$lang_index);
                                                    $Form->add_meta_description('meta_d_'.$lang_index);
                                                    $Form->add_description('text_'.$lang_index,'','Servicii');
                                                    $Form->add_description('text_2_'.$lang_index,'','Info 1');
                                                    $Form->add_description('text_3_'.$lang_index,'','Info 2');
                                                    $Form->add_description('text_4_'.$lang_index,'','Info 3');
                                                    $Form->add_description('text_5_'.$lang_index,'','Info 4');
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
    else
    {
        include_once $_SERVER['DOCUMENT_ROOT'].'/cp/php/templates/not_authorized_to_view_page.php';
    }
}
else
{
    header("location: ".$Cpu->getURL(5));
}
