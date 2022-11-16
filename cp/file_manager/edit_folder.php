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
            $edit_catalog_id =  $db->escape((int)$ar_get_clean['section_id']);
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
            $section_id = $db->escape((int)$ar_post_clean['section_id']);

            if($section_id != 0)
            {
                $data_list['section_id'] = $section_id;
            }

            foreach ($list_of_site_langs as $site_langs)
            {
                $data_list['title_'.$site_langs] = $db->escape($ar_post_clean['title_en']);
            }


            $db->where ('id', $edit_catalog_id);
            if ($db->update ($db_catalog_table, $data_list, 1))
            {
                $status_info['success'][] = dictionary('SUCCESSFULLY_UPDATED');
            }
            else
            {
                $status_info['error'][] = $db->getLastError();
            }
        }
        ?>




        <?php
        if( $validator->check_int($edit_catalog_id) && $edit_catalog_id>0 )
        {
            $db->where ("id", $edit_catalog_id);
            $catalog = $db->getOne ($db_catalog_table);
            if(!$catalog)
            {
                include_once $_SERVER['DOCUMENT_ROOT'].'/cp/php/templates/errors_in_url_address.php';
                exit();
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
                                            <div class="form-group">
                                                <label class="col-md-12">
                                                    <?php
                                                    if($edit_catalog_id == 0)
                                                    {
                                                        ?>
                                                        <span style="color:#fb9678;"><?php echo dictionary('MAIN_SECTION');?></span>
                                                        <?php
                                                    }
                                                    else
                                                    {
                                                        $select_catalog_title = $db
                                                            ->where('id', $edit_catalog_id)
                                                            ->getOne($db_catalog_table);

                                                        if($select_catalog_title)
                                                        {
                                                            ?>
                                                            <span style="color:#fb9678;"><?php echo $select_catalog_title['title_en'];?></span>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </label>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-12"><?php echo dictionary('TITLE');?> <span style="color: red;">*</span></label>
                                                <div class="col-md-12">
                                                    <input type="text" name="title_en" value="<?php echo $catalog['title_en'];?>"
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