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
        if (isset($ar_get_clean['section_id']))
        {
            $catalog_id =  $ar_get_clean['section_id'];
        }
        else
        {
            $catalog_id = 0;
        }

        if(isset($_POST['add_files_to_manager']))
        {
            $ar_post_clean = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

            // ------------------------------ prelucrarea dropzone_files -----------------------
            $Form->post_dropzone_adding( $catalog_id, @$ar_post_clean['dropzone_files']);
            //END: ------------------------------ prelucrarea dropzone_files-----------------------

            $status_info['success'][] = dictionary('SUCCESSFULLY_ADDED');

        }
        ?>



        <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/cp/php/templates/header.php';
        include $_SERVER['DOCUMENT_ROOT'] . '/cp/php/templates/left-sidebar.php';
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
                            <style>
                                .folder_block{
                                    float: left;
                                    margin: 0 25px 25px 25px;
                                    position: relative;
                                    width: 128px;
                                    height: 144px;
                                }

                                #add_files_to_manager
                                {
                                    cursor: pointer;
                                    font-size: 12px;
                                    background: #03a9f3;
                                    float: right;
                                    padding: 9px 7px 7px 7px;
                                    border-radius: 0;
                                }
                                #add_folder_to_manager
                                {
                                    cursor: pointer;
                                    font-size: 12px;
                                    background: #ff6849;
                                    float: right;
                                    padding: 9px 7px 7px 7px;
                                    border-radius: 0;
                                }
                                .control_file_folder
                                {
                                    position: relative;
                                    height: 25px;
                                }

                                .control_file_folder {
                                    opacity: 0;
                                }

                                .folder_block:hover .control_file_folder
                                {
                                    opacity: 1;
                                }

                            </style>
                            <!-- Page Content -->
                            <div id="page-wrapper">
                                <div class="container-fluid">
                                    <?php
                                    $Cpu->top_block_info($cutpageinfo);
                                    ?>
                                    <div style="float: right;">
                                        <div id="add_folder_to_manager" class="label label-info">
                                            <a style="color:white;font-size: 12px;" href="<?php echo $Cpu->getURL(345);?>?section_id=<?=$catalog_id?>">
                                                <?php echo dictionary('ADD_FOLDER');?>
                                            </a>
                                        </div>
                                        <div style="clear:both;width: 100%; height: 10px;"></div>
                                        <div id="add_files_to_manager" class="label label-info">Add files to monager</div>
                                    </div>
                                    <div style="clear: both; width: 100%; height: 25px;"></div>



                                    <?php
                                    $get_manager_folders = $db
                                        ->where("section_id", $catalog_id )
                                        ->orderBy("title_".$Main->lang, "asc")
                                        ->get($db_catalog_table);
                                    foreach ($get_manager_folders as $manager_folder)
                                    {
                                        ?>
                                        <div class="folder_block">
                                            <div class="control_file_folder">
                                                <span onclick="edit_folder('<?php echo $manager_folder['id'];?>')">
                                                    <button class="edit_button" type="button" title="Edit" style="position:absolute; left: 83px;"></button>
                                                </span>
                                                <span onclick="remove_folder('<?php echo $manager_folder['id'];?>')">
                                                    <button class="delete_button" type="button" title="Delete" style="position:absolute; left: 108px;"></button>
                                                </span>
                                            </div>
                                            <a href="<?php echo $Cpu->getURL(344);?>?section_id=<?=$manager_folder['id']?>">
                                                <img src = "/cp/css/img/folder_icon.png" title="<?php echo $manager_folder['title_'.$Main->lang];?>">
                                                <div id="filemanager_original_folder_name_<?php echo $manager_folder['id'];?>" class="sp_file_block"><?php echo $manager_folder['title_'.$Main->lang];?></div>
                                            </a>
                                        </div>
                                        <?php
                                    }
                                    ?>

                                    <?php
                                    $select_manager_files = $db
                                        ->where("parent_id", $catalog_id)
                                        ->orderBy("sort","asc")
                                        ->get($db_table_dropzone1_images);

                                    //show($select_portfolio_images);
                                    foreach ($select_manager_files as $manager_file)
                                    {
                                        list($width, $height) = getimagesize($_SERVER['DOCUMENT_ROOT'].'/uploads/'.$db_table_dropzone1_images.'/'.$manager_file['image']);

                                        if( $width > 128 || $height > 128 )
                                        {
                                            $thumb_image = @newthumbs($manager_file['image'], $db_table_dropzone1_images, 128,128,3,1);
                                        }
                                        else
                                        {
                                            $thumb_image = @newthumbs($manager_file['image'], $db_table_dropzone1_images);
                                        }


                                        if(isset($thumb_image) && !empty($thumb_image))
                                        {
                                            ?>
                                            <div class="folder_block">
                                                <div class="control_file_folder">
                                                    <?php
                                                    $url_copy_link_image = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/uploads/' . $db_table_dropzone1_images . '/' . $manager_file['image'];
                                                    ?>
                                                    <span class="copy_link_image" onclick="copy_link_image('<?php echo $url_copy_link_image;?>')" title="copy link"></span>
                                                    <span onclick="edit_file('<?php echo $manager_file['id'];?>')">
                                                        <button class="edit_button" type="button" title="Edit" style="position:absolute; left: 83px;"></button>
                                                    </span>
                                                    <span onclick="remove_file('<?php echo $manager_file['id'];?>')">
                                                        <button class="delete_button" type="button" title="Delete" style="position:absolute; left: 108px;"></button>
                                                    </span>
                                                </div>
                                                <a href="/uploads/<?php echo $db_table_dropzone1_images;?>/<?php echo $manager_file['image'];?>" download="<?php echo $manager_file['original_file_name'];?>">
                                                    <div style="display: table; float: left; position: relative;width: 128px;height: 128px; background: #fff; ">
                                                        <div style="display: table-cell;vertical-align: middle;">
                                                            <img style="max-width: 128px; max-height: 128px; margin-left: auto; margin-right: auto; display: block;" src = "<?php echo $thumb_image; ?>" alt="<?php echo $manager_file['original_file_name'];?>" title="<?php echo $manager_file['original_file_name'];?>">
                                                        </div>
                                                    </div>
                                                    <div id="filemanager_original_name_element_<?php echo $manager_file['id'];?>" class="sp_file_block" style="background: none; bottom: -5px;"><?php echo $manager_file['original_file_name'];?></div>
                                                </a>
                                            </div>
                                            <?php
                                        }
                                        else
                                        {
                                            $file_extension = pathinfo($manager_file['image'], PATHINFO_EXTENSION);
                                            if($file_extension ==  'pdf')
                                            {
                                                ?>
                                                <div class="folder_block">
                                                    <div class="control_file_folder">
                                                        <?php
                                                        $url_copy_link_image = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/uploads/' . $db_table_dropzone1_images . '/' . $manager_file['image'];
                                                        ?>
                                                        <span class="copy_link_image" onclick="copy_link_image('<?php echo $url_copy_link_image;?>')"  title="copy link"></span>
                                                        <span onclick="edit_file('<?php echo $manager_file['id'];?>')">
                                                            <button class="edit_button" type="button" title="Edit" style="position:absolute; left: 83px;"></button>
                                                        </span>
                                                        <span onclick="remove_file('<?php echo $manager_file['id'];?>')">
                                                            <button class="delete_button" type="button" title="Delete" style="position:absolute; left: 108px;"></button>
                                                        </span>
                                                    </div>
                                                    <a href="/uploads/<?php echo $db_table_dropzone1_images;?>/<?php echo $manager_file['image'];?>" download="<?php echo $manager_file['original_file_name'];?>">
                                                        <img src = "/cp/css/img/pdf_file_icon.png" alt="<?php echo $manager_file['original_file_name'];?>" title="<?php echo $manager_file['original_file_name'];?>">
                                                        <div id="filemanager_original_name_element_<?php echo $manager_file['id'];?>" class="sp_file_block"><?php echo $manager_file['original_file_name'];?></div>
                                                    </a>
                                                </div>
                                                <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <div class="folder_block">
                                                    <div class="control_file_folder">
                                                                <span onclick="edit_file('<?php echo $manager_file['id'];?>')">
                                                                    <button class="edit_button" type="button" title="Edit" style="position:absolute; left: 83px;"></button>
                                                                </span>
                                                        <span onclick="remove_file('<?php echo $manager_file['id'];?>')">
                                                                    <button class="delete_button" type="button" title="Delete" style="position:absolute; left: 108px;"></button>
                                                                </span>
                                                    </div>
                                                    <a href="/uploads/<?php echo $db_table_dropzone1_images;?>/<?php echo $manager_file['image'];?>" download="<?php echo $manager_file['original_file_name'];?>">
                                                        <img src = "/cp/css/img/default.png" alt="<?php echo $manager_file['original_file_name'];?>" title="<?php echo $manager_file['original_file_name'];?>">
                                                        <div id="filemanager_original_name_element_<?php echo $manager_file['id'];?>" class="sp_file_block"><?php echo $manager_file['original_file_name'];?></div>
                                                    </a>
                                                </div>
                                                <?php
                                            }
                                        }
                                    }
                                    ?>

                                    <div style="clear:both; width:100%; height:50px;"></div>

                                    <form id="dropznoe_block" class="form-material form-horizontal" method="post" action="" enctype="multipart/form-data" style="display: none;">
                                        <div id="item_description">
                                            <?php
                                            if(!empty($db_table_dropzone1_images))
                                            {
                                                $Form->add_dropzone_files($db_table_dropzone1_images);
                                            }
                                            ?>
                                        </div>
                                        <button style="float:right;" type="submit" name="add_files_to_manager"
                                                class="btn btn-success waves-effect waves-light m-r-10"><?php echo dictionary('SUBMIT');?>
                                        </button>
                                    </form>

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

        <script>
            $( document ).on( "click", "#add_files_to_manager", function(){
                $("form#dropznoe_block").css("display","block");
            });

            function edit_file(id)
            {
                var data = {};
                data['task'] = 'edit_filemanager_element';
                data['id'] = parseInt(id);
                data['section_id'] = parseInt("<?php echo $catalog_id;?>");

                $.ajax({
                    type: "POST",
                    url: "/cp_ajax_<?php echo $Main->lang;?>/",
                    data: data,
                    dataType: "html",
                    success: function (ajax_data)
                    {
                        $(".popUpBackground").addClass("popUpBackground_active");
                        $('body').append(ajax_data);
                    }
                });
            }

            function remove_file(id)
            {
                var data = {};
                data['task'] = 'remove_filemanager_element';
                data['id'] = parseInt(id);

                $.ajax({
                    type: "POST",
                    url: "/cp_ajax_<?php echo $Main->lang;?>/",
                    data: data,
                    dataType: "html",
                    success: function (ajax_data)
                    {
                        $(".popUpBackground").addClass("popUpBackground_active");
                        $('body').append(ajax_data);
                    }
                });
            }
        </script>


        <script>
            function edit_folder(id)
            {
                var data = {};
                data['task'] = 'edit_filemanager_folder';
                data['id'] = parseInt(id);
                data['section_id'] = parseInt("<?php echo $catalog_id;?>");
                data['db_table'] = "<?php echo $Form->hide_dates('encrypt', $db_catalog_table);?>";

                $.ajax({
                    type: "POST",
                    url: "/cp_ajax_<?php echo $Main->lang;?>/",
                    data: data,
                    dataType: "html",
                    success: function (ajax_data)
                    {
                        $(".popUpBackground").addClass("popUpBackground_active");
                        $('body').append(ajax_data);
                    }
                });
            }

            function remove_folder(id)
            {
                var data = {};
                data['task'] = 'remove_filemanager_folder';
                data['id'] = parseInt(id);

                $.ajax({
                    type: "POST",
                    url: "/cp_ajax_<?php echo $Main->lang;?>/",
                    data: data,
                    dataType: "html",
                    success: function (ajax_data)
                    {
                        $(".popUpBackground").addClass("popUpBackground_active");
                        $('body').append(ajax_data);
                    }
                });
            }

            function copy_link_image(link)
            {
                var temp = $("<input>");
                $("body").append(temp);
                temp.val(link).select();
                document.execCommand("copy");
                temp.remove();
            }
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