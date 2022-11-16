<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/cp/class/include.php';
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

/*
        if( $catalog_id == 0)
        {
            include_once $_SERVER['DOCUMENT_ROOT'].'/cp/php/templates/errors_in_url_address.php';
            exit();
        }
*/
        $CATALOG_LEVEL = $Main->catalog_level($catalog_id);

        if(isset($_POST['submit']))
        {
            $ar_post_clean = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $section_id = $db->escape((int)$ar_post_clean['section_id']);
            //$price = floatval($ar_post_clean['price']);
            $sort = $db->escape($ar_post_clean['sort']);

            $data_list = Array (
                "section_id" => $section_id,
                "sort" => $sort
            );

            // Prelucrarea imaginilor simple
            if(isset($_FILES))
            {
                foreach ($_FILES as $files_info_key => $files_info)
                {
                    if(isset($cuted_files_info)) { unset($cuted_files_info); }
                    $cuted_files_info = array();
                    $cuted_files_info[$files_info_key] = $files_info;
                    $data_list[$files_info_key] = $Form->post_insert_simple_image($db_catalog_elements_table, $files_info_key, $cuted_files_info );
                }
            }
            // END -> Prelucrarea imaginilor simple

            foreach ($list_of_site_langs as $site_langs)
            {
                $data_list['title_'.$site_langs] = $db->escape($ar_post_clean['title_'.$site_langs]);
                $data_list['page_title_'.$site_langs] = $db->escape($ar_post_clean['page_title_'.$site_langs]);
                $data_list['meta_k_'.$site_langs] = $db->escape($ar_post_clean['meta_k_'.$site_langs]);
                $data_list['meta_d_'.$site_langs] = $db->escape($ar_post_clean['meta_d_'.$site_langs]);
                $data_list['preview_'.$site_langs] = $db->escape($ar_post_clean['preview_'.$site_langs]);
                $data_list['text_'.$site_langs] = $db->escape($ar_post_clean['text_'.$site_langs]);
            }

            $inserted_id_result = $db->insert($db_catalog_elements_table, $data_list);
            if ($inserted_id_result)
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

                if( $Cpu->insertCpu($arrURL, $CPU_ELEM_ID, $inserted_id_result ) )
                {
                    $status_info['success'][] = dictionary('SUCCESSFULLY_ADDED');
                }
                else
                {
                    $status_info['error'][] = dictionary('CPU_ADDING_ERROR');
                }

                // ------------------------------ prelucrarea dropzone_files -----------------------
                $Form->post_dropzone_adding( $inserted_id_result, @$ar_post_clean['dropzone_files']);
                //END: ------------------------------ prelucrarea dropzone_files---------------------

                ///////////////////////////////////////////// add parameters /////////////////////////////////////////////////////////////////////////
                /*
                $element_filter_parameters = array();
                foreach ($_POST as $key => $value)
                {
                    $vl = explode("_", $key);
                    if( $vl[0]=="op" && is_numeric($vl[1]) )
                    {
                        $OParray=$vl[0].'_'.$vl[1];
                        foreach($ar_post_clean[$OParray] as $OPvalue)
                        {
                            if ($OPvalue!=0)
                            {
                                $element_filter_parameters[]  = array (
                                         "element_id" => $inserted_id_result,
                                            "filter_option" => $vl[1],
                                            "selected_value" => $OPvalue
                                        );
                            }
                        }
                    }
                }

                if( count($element_filter_parameters) > 0 )
                {
                    $element_filter_parameters_inserted_ids = $db->insertMulti($db_catalog_elements_parameters_table, $element_filter_parameters);
                    if(!$element_filter_parameters_inserted_ids)
                    {
                        $status_info['error'][] = $db->getLastError();
                    }
                }
                */
                ///////////////////////////////////////////// END -> add parameters///////////////////////////////////////////////////////////////////

            }
            else
            {
                $status_info['error'][] = $db->getLastError();
            }
        }
        ?>

        <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/cp/php/templates/header.php';
        include $_SERVER['DOCUMENT_ROOT'] . '/cp/php/templates/left-sidebar.php';
        ?>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <?php
                if($catalog_id > 0)
                {
                    $Cpu->top_block_info($cutpageinfo);
                }
                else
                {
                    $regenerate_cutpaginfo_for_page_id = 588;
                    ?>
                    <div style="clear: both; height: 15px;"></div>
                    <a href="<?php echo $Cpu->getURL($regenerate_cutpaginfo_for_page_id);?>">
                        <span class="label label-info label-danger">
                            <?php echo $GLOBALS['ar_define_langterms']['RETURN_BACK']?>
                        </span>
                    </a>
                    <div style="clear: both; height: 25px;"></div>
                    <h4 class="page-title"><?php echo $cutpageinfo['title'];?></h4>
                    <?php
                }
                ?>
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

                                                <div class="form-group">
                                                    <label class="col-md-12"><?php echo dictionary('SPECIFY_TARENT_SECTION');?> <span style="color: red;">*</span></label>
                                                    <div class="col-md-12">
                                                        <select class="form-control required" name="section_id" onchange="change_subcatalog_section(this)">
                                                            <option></option>
                                                            <option disabled value="0"><?php echo dictionary('MAIN_SECTION');?></option>
                                                            <?php
                                                            $tree = $Main->getChildren(0);
                                                            $Main->display_option_catalog_children( $catalog_id, $tree, 0);
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <?php
                                                    $Form->add_image('image',1);
                                                    $Form->add_dropzone_files($db_catalog_elements_images);
                                                ?>

                                                <?php // FILTRU
                                                 /*
                                                 ?>
                                                    <hr style="background: #e0cece;">
                                                    <div class="form-group">
                                                        <label class="col-md-12" id="filter_options_label"><?php echo dictionary('FILTER_PARAMETERS');?></label>
                                                        <div class="col-md-12" id="filter_options">
                                                            <?php
                                                            $count_filter_parameters = 0;
                                                            $get_Filter_Options = $db
                                                                ->where('active', 1)
                                                                ->orderBy('sort', 'desc')
                                                                ->get($db_filter_options_table);
                                                            if( count($get_Filter_Options) > 0)
                                                            {
                                                                foreach ( $get_Filter_Options AS $filter_option)
                                                                {
                                                                    $for_catalog = unserialize($filter_option["for_catalog"]);

                                                                    if (in_array($catalog_id, $for_catalog))
                                                                    {
                                                                        ?>
                                                                        <h5>
                                                                            <?php echo $filter_option['title_'.$Main->lang];?>
                                                                        </h5>
                                                                        <?php
                                                                            //show($parameters);
                                                                        $getFilterOptionsValues = $db
                                                                            ->where('option_id', $filter_option['id'])
                                                                            ->orderBy('sort', 'desc')
                                                                            ->get($db_filter_options_values_table);
                                                                        if(count($getFilterOptionsValues) > 0 )
                                                                        {
                                                                            $count_filter_parameters++;
                                                                            if($filter_option['by_selection'] == 1 )
                                                                            {
                                                                                ?>
                                                                                <select style="min-width: 150px;" name="op_<?=$filter_option['id']?>[]" >
                                                                                    <?php
                                                                                    foreach ( $getFilterOptionsValues AS $filterOptionValue)
                                                                                    {
                                                                                        ?>
                                                                                        <option style="min-width: 150px; text-align: center;" value="<?=$filterOptionValue['id']?>"> <?=$filterOptionValue['val_'.$Main->lang]?> </option>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                                <?php
                                                                            }
                                                                            else
                                                                            {
                                                                                ?>
                                                                                <select style="width: 100%; overflow: auto;" name="op_<?=$filter_option['id']?>[]" multiple size="5" <?php if(count($getFilterOptionsValues) > 5 ) { ?> class="slimscroll_select_option" <?php } ?> >
                                                                                    <?php
                                                                                    foreach ( $getFilterOptionsValues AS $filterOptionValue)
                                                                                    {
                                                                                        ?>
                                                                                        <option style="min-width: 150px; text-align: center;" value="<?=$filterOptionValue['id']?>"> <?=$filterOptionValue['val_'.$Main->lang]?> </option>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                                <?php
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }

                                                            if($count_filter_parameters == 0)
                                                            {
                                                                ?>
                                                                <style>
                                                                    #filter_options_label
                                                                    {
                                                                        display: none;
                                                                    }
                                                                </style>
                                                                <h4 style="color:#fb9678;">
                                                                    <?php echo dictionary('THIS_PRODUCT_HAS_NOT_FILTER_LINKS');?>
                                                                </h4>

                                                                <a target="_blank" href="<?php echo $Cpu->getURL(83);?>">
                                                                    <?php echo dictionary('FILTER_PARAMETERS');?>
                                                                </a>
                                                                <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <hr style="background: #e0cece;">
                                                <?php
                                                 */
                                                // END FILTRU ?>

                                                <?php
                                                /*
                                                ?>
                                                <div class="form-group">
                                                    <label class="col-md-12"><?php echo dictionary('PRICE');?></label>
                                                    <div class="col-md-12">
                                                        <input type="text" name="price" id='price' class="input_75 checkFloat align-center" value="0">
                                                    </div>
                                                </div>
                                                <?php
                                                */
                                                ?>

                                                <?php
                                                $Form->add_sort('sort');
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
                                                    $Form->add_title('title_'.$lang_index, 1);
                                                    $Form->add_title('page_title_'.$lang_index, 0, dictionary('PAGE_TITLE'));
                                                    $Form->add_cpu('cpu_'.$lang_index);
                                                    $Form->add_meta_keywords('meta_k_'.$lang_index);
                                                    $Form->add_meta_description('meta_d_'.$lang_index);
                                                    $Form->add_preview('preview_'.$lang_index);
                                                    $Form->add_description('text_'.$lang_index);
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
        <?php
            require_once $_SERVER['DOCUMENT_ROOT'].'/cp/js/dropzone_additionally_js.php';
        ?>
        <!-- /#wrapper -->
        </body>



        <script type="text/javascript">
            function isFloat(n) {
                return parseFloat(n.match(/^-?\d*(\.\d+)?$/))>=0;
            }

            $( "#price" ).focus(function() {
               $(this).css("color","#4f5467");
            });


            $("form").submit(function(){
                var a = 0;
                $( "input.checkFloat" ).each(function() {

                    var check = isFloat(String($(this).val()));
                    if( check == false ) {
                        a = 1;
                        var curval = $(this).attr("value");
                        //$(this).val(curval);
                        var fildName = $(this).attr("name");
                        if (fildName == 'price')
                        {
                            $("#"+fildName).css("color","red");
                        }
                    }

                });
                if (a==1)
                {
                    alert("<?php echo dictionary('INCORRECT_PRICE_FORMAT');?>");
                    return false;
                }
            });


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