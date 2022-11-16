<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/cp/class/include.php';
require_once 'settings.php';

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


        if(isset($_POST['submit']))
        {

            $ar_post_clean = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            //show($ar_post_clean);

            $section_id = $db->escape((int)$ar_post_clean['section_id']);

            $data_list = Array (
                "section_id" => $section_id,
                "createdAt" => $db->now()
            );

            foreach ($list_of_site_langs as $site_langs)
            {
                $data_list['title_'.$site_langs] = $db->escape($ar_post_clean['title_en']);
            }

            $inserted_id_result = $db->insert($db_catalog_table, $data_list);
            if ($inserted_id_result)
            {
                $arrURL = array();
                foreach( $list_of_site_langs as $lang_index )
                {
                    $arrURL[$lang_index] = $ar_post_clean['title_en'];
                }

                $arrURL = $Cpu->checkCpu($arrURL);

                if( $Cpu->insertCpu($arrURL, $FOLDER_CATEGORY_ID, $inserted_id_result ) )
                {

                    $status_info['success'][] = dictionary('SUCCESSFULLY_ADDED');

                }
                else
                {
                    $status_info['error'][] = dictionary('CPU_ADDING_ERROR');
                }
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
                                    <form id="check_required_fields" class="form-material form-horizontal" method="post" action="" enctype="multipart/form-data">
                                        <div id="item_description">
                                            <div class="form-group">
                                                <label class="col-md-12"><?php echo dictionary('SPECIFY_TARENT_SECTION');?> <span style="color: red;">*</span></label>
                                                <div class="col-md-12">
                                                    <select class="form-control" name="section_id">
                                                        <?php
                                                        if($catalog_id == 0)
                                                        {
                                                            ?>
                                                            <option selected value="0"><?php echo dictionary('MAIN_SECTION');?></option>
                                                            <?php
                                                        }
                                                        else
                                                        {
                                                            ?>
                                                            <option value="0"><?php echo dictionary('MAIN_SECTION');?></option>
                                                            <?php
                                                        }

                                                            $get_catalog_info = $db
                                                                ->where("section_id", 0)
                                                                ->get($db_catalog_table, null, 'id');

                                                            foreach($get_catalog_info as $catalog_info)
                                                            {
                                                                $tree = $Functions->getDirectoryChildren_for_options($catalog_info['id'], $db_catalog_table);
                                                                if(empty($tree))
                                                                {
                                                                    $tree[0]['id'] = $catalog_info['id'];
                                                                }
                                                                $Functions->display_catalog_children( $catalog_id, $tree, $Main->lang, $db_catalog_table);
                                                            }

                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-12"><?php echo dictionary('TITLE');?> <span style="color: red;">*</span></label>
                                                <div class="col-md-12">
                                                    <input type="text" name="title_en" value=""
                                                           class="form-control required" placeholder="">
                                                </div>
                                            </div>
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