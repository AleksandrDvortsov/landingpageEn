<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/cp/class/include.php';
require_once( __DIR__ . "/../settings.php");

if($User->check_cp_authorization())
{
    if($User->access_control($Form->page_access($page_data['id'])))
    {
        $ar_get_clean = filter_input_array(INPUT_GET, FILTER_SANITIZE_SPECIAL_CHARS);
        $status_info = array();
        if (isset($ar_get_clean['id']))
        {
            $edit_element_id =  $db->escape((int)$ar_get_clean['id']);
            $catalog_id = $db->escape((int)$ar_get_clean['section_id']);
        }
        else
        {
            include_once $_SERVER['DOCUMENT_ROOT'].'/cp/php/templates/errors_in_url_address.php';
            exit();
        }




        if(isset($_POST['submit']))
        {
            $ar_post_clean = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            //show($ar_post_clean);
            $active = 0; if( isset($ar_post_clean["active"]) && !empty($ar_post_clean["active"]) ) { $active = 1; }
            $sort = $db->escape($ar_post_clean['sort']);

            //show($section_id);

            $data_list = Array (
                "active" => $active,
                "sort"  => $sort,
            );

            if(in_array($catalog_id, $elements_catID_with_price))
            {
                $data_list['price'] = (float)$ar_post_clean['price'];
            }

            // Prelucrarea imaginilor simple
            if(isset($_FILES))
            {
                foreach ($_FILES as $files_info_key => $files_info)
                {
                    if(isset($cuted_files_info)) { unset($cuted_files_info); }
                    $cuted_files_info = array();
                    $cuted_files_info[$files_info_key] = $files_info;

                    $data_list[$files_info_key] = $Form->post_edit_simple_image($db_catalog_elements_table, $files_info_key, $ar_post_clean['old_'.$files_info_key], $cuted_files_info );

                }

            }
            // END -> Prelucrarea imaginilor simple

            foreach ($list_of_site_langs as $site_langs)
            {
                $data_list['title_'.$site_langs] = $db->escape($ar_post_clean['title_'.$site_langs]);
                $data_list['undertitle_'.$site_langs] = $db->escape($ar_post_clean['undertitle_'.$site_langs]);
                $data_list['page_title_'.$site_langs] = $db->escape($ar_post_clean['page_title_'.$site_langs]);
                $data_list['meta_k_'.$site_langs] = $db->escape($ar_post_clean['meta_k_'.$site_langs]);
                $data_list['meta_d_'.$site_langs] = $db->escape($ar_post_clean['meta_d_'.$site_langs]);
                $data_list['titleunderphoto_'.$site_langs] = $db->escape($ar_post_clean['titleunderphoto_'.$site_langs]);

                if(in_array($catalog_id, $elements_catID_with_price))
                {
                    $data_list['titleunderphoto2_'.$site_langs] = $db->escape($ar_post_clean['titleunderphoto2_'.$site_langs]);
                }

                $data_list['text_'.$site_langs] = $db->escape($ar_post_clean['text_'.$site_langs]);
            }

            $db->where ('id', $edit_element_id);
            if ($db->update ($db_catalog_elements_table, $data_list, 1))
            {
                $arrURL = array();
                foreach( $list_of_site_langs as $lang_index )
                {
                    $arrURL[$lang_index] = $ar_post_clean['cpu_' . $lang_index];
                    if (trim($arrURL[$lang_index]) == '')
                    {
                        $arrURL[$lang_index] = $ar_post_clean['title_' . $lang_index];
                    }
                }

                $arrURL = $Cpu->checkCpu($arrURL);
                if( !($Cpu->updateElementCpu($arrURL, $CPU_ELEM_ID, $edit_element_id)) )
                {
                    $status_info['error'][] = $db->getLastError();
                }

                $status_info['success'][] = dictionary('SUCCESSFULLY_UPDATED');
            }
            else
            {
                $status_info['error'][] = $db->getLastError();
            }

        }
        ?>

        <?php
        if( $validator->check_int($edit_element_id) && $edit_element_id>0 )
        {
            $db->where ("id", $edit_element_id);
            $element = $db->getOne ($db_catalog_elements_table);
            if(!$element)
            {
                include_once $_SERVER['DOCUMENT_ROOT'].'/cp/php/templates/errors_in_url_address.php';
                exit();
            }

            $CPUs = array();
            $getCPUs = $db
                ->where ("page_id", $CPU_ELEM_ID)
                ->where ("elem_id", $edit_element_id)
                ->get($db_front_cpu_table);
            foreach($getCPUs as $elem_cpu)
            {
                $CPUs[$elem_cpu['lang']] = $elem_cpu['cpu'];
            }

        }
        else
        {
            include_once $_SERVER['DOCUMENT_ROOT'].'/cp/php/templates/errors_in_url_address.php';
            exit();
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
                                                <?php
                                                $Form->edit_image($element['image'], $db_catalog_elements_table, 'image', 1);
                                                ?>

                                                <?php
                                                if(in_array($catalog_id, $elements_catID_with_price))
                                                {
                                                    ?>
                                                    <div class="form-group">
                                                        <label class="col-md-12"><?php echo dictionary('PRICE');?></label>
                                                        <div class="col-md-12">
                                                            <input type="number" name="price" value="<?php echo $element['price'];?>" min="0" class="form-control">
                                                        </div>
                                                    </div>
                                                    <?php
                                               }
                                               ?>

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
                                                    $Form->edit_title($element['undertitle_'.$lang_index], 'undertitle_'.$lang_index, 0, dictionary('CP_UNDERLINE'));
                                                    $Form->edit_title($element['page_title_'.$lang_index], 'page_title_'.$lang_index, 0, dictionary('PAGE_TITLE'));
                                                    $Form->edit_cpu(@$CPUs[$lang_index], 'cpu_'.$lang_index);
                                                    $Form->edit_meta_keywords($element['meta_k_'.$lang_index], 'meta_k_'.$lang_index);
                                                    $Form->edit_meta_description($element['meta_d_'.$lang_index], 'meta_d_'.$lang_index);
                                                    $Form->edit_title($element['titleunderphoto_'.$lang_index], 'titleunderphoto_'.$lang_index, 0, dictionary('CP_TITLE_UNDER_IMAGE'));

                                                    if(in_array($catalog_id, $elements_catID_with_price))
                                                    {
                                                        $Form->edit_title($element['titleunderphoto2_'.$lang_index], 'titleunderphoto2_'.$lang_index, 0, dictionary('CP_TITLE_UNDER_IMAGE2'));
                                                    }

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
        <?php
            require_once $_SERVER['DOCUMENT_ROOT'].'/cp/js/dropzone_additionally_js.php';
        ?>
        </body>


        <script type="text/javascript">
            function change_subcatalog_section(selectObject)
            {
                var value = parseInt(selectObject.value);
                var data = {};
                data['task'] = 'change_subcatalog_section';
                data['subcatalog_section_id'] = value;
                data['db_filter_options_table'] = "<?php echo $Form->hide_dates('encrypt', $db_filter_options_table);?>";
                data['db_filter_options_values_table'] = "<?php echo $Form->hide_dates('encrypt', $db_filter_options_values_table);?>";

                $.ajax({
                    type: "POST",
                    url: "/cp_ajax_<?php echo $Main->lang;?>/",
                    data: data,
                    dataType: "html",
                    success: function (ajax_data)
                    {
                        $("#filter_options").html(ajax_data)
                    }
                });
            }

        </script>

        <script type="text/javascript">
            $('.slimscroll_select_option').slimScroll({
                height: '150px',
                width: '100%',
                alwaysVisible: true
            });
        </script>

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