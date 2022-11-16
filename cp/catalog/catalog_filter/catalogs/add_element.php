<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/cp/class/include.php';
require_once( __DIR__ . "/../../settings.php");

if($User->check_cp_authorization())
{
    if($User->access_control($Form->page_access($page_data['id'])))
    {
        $status_info = array();

        if(isset($_POST['submit']))
        {

            $ar_post_clean = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            //show($ar_post_clean);

            //--------------------- controlam ce subcatalog a fost selectat -------------
            $for_cat = array();
            if(isset($ar_post_clean['for_catalog']) && count($ar_post_clean['for_catalog']) > 0 )
            {
                $for_catalog_array= $ar_post_clean['for_catalog'];
                if ($for_catalog_array)
                {
                    foreach ($for_catalog_array as $t)
                    {
                        $for_cat[]=$t;
                    }
                }
            }
            //----------------------------------------------------------------------------
            $by_selection = 0; if( isset($ar_post_clean["by_selection"]) && $ar_post_clean["by_selection"] == "on" ){$by_selection = 1;}
            $type = 0; if( isset($ar_post_clean["type"]) && $ar_post_clean["type"] == "on" ){$type = 1;}
            $dont_show_in_filter = 0; if( isset($ar_post_clean["dont_show_in_filter"]) && $ar_post_clean["dont_show_in_filter"] == "on" ){$dont_show_in_filter = 1;}
            $sort = $db->escape($ar_post_clean['sort']);

            $data_list = Array (
                "by_selection" => $by_selection,
                "type" => $type,
                "dont_show_in_filter" => $dont_show_in_filter,
                "for_catalog" => serialize($for_cat),
                "sort" => $sort
            );

            foreach ($list_of_site_langs as $site_langs)
            {
                $data_list['title_'.$site_langs] = $db->escape($ar_post_clean['title_'.$site_langs]);
            }

            $inserted_id_result = $db->insert ($db_filter_options_table, $data_list);
            if ($inserted_id_result)
            {
                $status_info['success'][] = dictionary('SUCCESSFULLY_ADDED');
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
                                    <form id="check_required_fields" class="form-material form-horizontal" method="post" action="">
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
                                                    <label class="col-md-12"><?php echo dictionary('PRE_EXISTING_FILTER_BLOCKS');?></label>
                                                    <div class="col-md-12">
                                                        <div id="scroll_block">
                                                            <?php
                                                            $get_filter_catalogs = $db
                                                                ->get($db_filter_options_table);
                                                            if( count($get_filter_catalogs) > 0 )
                                                            {
                                                                foreach ($get_filter_catalogs AS $filter_catalog)
                                                                {
                                                                    echo $filter_catalog['title_'.$Main->lang].'<br>';
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-12"><?php echo dictionary('FILTER_WHICH_CHARACTERISTIC_WILL_BE_DISPLAYED');?></label>
                                                    <div class="col-md-12">
                                                        <select name="for_catalog[]" multiple="multiple" size="4" style="width:700px;height:300px;">
                                                            <?php
                                                            $get_last_level_catalogs_main = $db
                                                                ->where('active', 1)
                                                                ->where('section_id', 0)
                                                                ->get('catalog');
                                                            if (count($get_last_level_catalogs_main) > 0)
                                                            {
                                                                foreach ( $get_last_level_catalogs_main  as $last_level_catalog)
                                                                {
                                                                    $c_id = $last_level_catalog['id'];
                                                                    $get_last_level_catalogs = $db
                                                                        ->where('active', 1)
                                                                        ->where('section_id', $c_id)
                                                                        ->get('catalog');
                                                                    if (count($get_last_level_catalogs) > 0)
                                                                    {
                                                                        ?>
                                                                        <option value="<?php echo $last_level_catalog['id']?>"> ► <?php echo $last_level_catalog['title_'.$Main->lang]?></option>
                                                                        <?php
                                                                        foreach ($get_last_level_catalogs as $scats)
                                                                        {
                                                                            $sc_id = $scats['id'];
                                                                            ?>
                                                                            <option value="<?php echo $scats['id']?>"> &nbsp; ►► <?php echo $scats['title_'.$Main->lang]?></option>
                                                                            <?php
                                                                            $get_scsats = $db
                                                                                ->where('active', 1)
                                                                                ->where('section_id', $sc_id)
                                                                                ->get('catalog');
                                                                            if (count($get_scsats) > 0)
                                                                            {
                                                                                foreach ($get_scsats as $scasts)
                                                                                {
                                                                                    ?>
                                                                                    <option value="<?php echo $scasts['id']?>">  &nbsp; &nbsp; &nbsp; ►►►  <?php echo $scasts['title_'.$Main->lang]?></option>
                                                                                    <?php
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                    else
                                                                    {
                                                                        ?>
                                                                        <option value="<?php echo $last_level_catalog['id']?>"> ► <?php echo $last_level_catalog['title_'.$Main->lang]?></option>
                                                                        <?php
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <hr style="background: #e0cece;">

                                                <div class="form-group">
                                                    <label class="col-md-12">
                                                        <?php echo dictionary('FILTER_VIEW_SELECTION_TYPE');?>
                                                        <span class="check_box_label_position">
                                                            <input type="checkbox" name="by_selection" >
                                                        </span>
                                                    </label>
                                                </div>

                                                <hr style="background: #e0cece;display: none;">

                                                <div class="form-group" style="display: none;">
                                                    <label class="col-md-12">
                                                        <?php echo dictionary('FILTER_USE_RANGE_SLIDER');?>
                                                        <span class="check_box_label_position">
                                                            <input type="checkbox" name="type" >
                                                        </span>
                                                    </label>
                                                </div>

                                                <hr style="background: #e0cece;display: none;">

                                                <div class="form-group">
                                                    <label class="col-md-12">
                                                        <?php echo dictionary('FILTER_NOT_USE_SHOW_IN_FILTER');?>
                                                        <span class="check_box_label_position">
                                                            <input type="checkbox" name="dont_show_in_filter" >
                                                        </span>
                                                    </label>
                                                </div>

                                                <hr style="background: #e0cece;display: none;">



                                                <div class="form-group">
                                                    <label class="col-md-12"><?php echo dictionary('SORT');?></label>
                                                    <div class="col-md-12">
                                                        <input type="number" name="sort" value="0"
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
                                                            <input type="text" name="title_<?php echo $lang_index?>" value=""
                                                                   class="form-control required" placeholder="">
                                                        </div>
                                                    </div>
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
    else
    {
        include_once $_SERVER['DOCUMENT_ROOT'].'/cp/php/templates/not_authorized_to_view_page.php';
    }
}
else
{
    header("location: ".$Cpu->getURL(5));
}