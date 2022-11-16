<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/cp/class/include.php';
if($User->check_cp_authorization())
{
    $status_info = array();

    if(isset($_POST['submit']))
    {
        $curent_user = $User->getUser($User->getId());
        $ar_post_clean = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        //show($ar_post_clean);
        $first_name = $db->escape($ar_post_clean['first_name']);
        $last_name = $db->escape($ar_post_clean['last_name']);
        $email = $db->escape($ar_post_clean['email']);
        $phone = $db->escape($ar_post_clean['phone']);
        $lang = $db->escape($ar_post_clean['lang']);
        $uploaded_images_info = array();

        if( isset($_FILES['image']['tmp_name']) && $_FILES['image']['tmp_name']!='' )
        {
            $uploaded_images_info = $Form->post_add_image('cp_user_photo',$_FILES, 'image');
            if(count($uploaded_images_info) == 0)
            {
                $status_info['error'][] = dictionary('ERROR_LOADING_IMAGE');
            }
            //remove all old images
            if(!remove_image('cp_user_photo', $db->escape($ar_post_clean['old_image'])))
            {
                $status_info['error'][] = dictionary('COULD_NOT_DELETE_OLD_IMAGES');
            }
        }
        else
        {
            $uploaded_images_info['image'] = $db->escape($ar_post_clean['old_image']);
        }

        $password = $db->escape($ar_post_clean['password']);
        $confirm_password = $db->escape($ar_post_clean['confirm_password']);
        $change_password_status = false;
        // Aici avem o dublare de contral a parolei ( prima merge prin ajax )
        if(strlen($password) > 0)
        {
            $change_password_status = true;

            if ( strlen($password) < 8 || !preg_match("#[0-9]+#",$password) || !preg_match("#[a-zA-Z]+#", $password) )
            {
                $status_info['error'][] = dictionary('ENTERED_PASSWORD_REQUIREMENTS');
                $change_password_status = false;
            }

            if ($password!=$confirm_password)
            {
                $status_info['error'][] = dictionary('ENTERED_PASSWORDS_NOT_MATCH');
                $change_password_status = false;
            }
        }

        $new_ecrypt_password = '';
        if($change_password_status === true)
        {
            $new_ecrypt_password = $User->encrypt($password);
            $data_user_info = Array (
                "first_name" => $first_name,
                "last_name" => $last_name,
                "email" => $email,
                "phone" => $phone,
                "image" => $uploaded_images_info['image'],
                "lang" => $lang,
                "password" => $new_ecrypt_password
            );
        }
        else
        {
            $data_user_info = Array (
                "first_name" => $first_name,
                "last_name" => $last_name,
                "email" => $email,
                "phone" => $phone,
                "image" => $uploaded_images_info['image'],
                "lang" => $lang
            );
        }


        if( !isset($status_info['error']) )
        {
            $db->where('id', $curent_user['id']);
            if ($db->update('cp_users', $data_user_info, 1)) {
                $status_info['success'][] = dictionary('SUCCESSFULLY_UPDATED');
                if ($change_password_status === true) {
                    $_SESSION['cp_password'] = $new_ecrypt_password;
                }

                if ($curent_user['lang'] != $lang) {
                    $exploded_url = explode("?", $_SERVER['REQUEST_URI']);
                    $explode_cpu = array_filter(explode("/", $exploded_url[0]), 'strlen');
                    $last_part_of_cpu = end($explode_cpu);
                    $get_last_part_of_cpu_info = $db
                        ->where("cpu", $last_part_of_cpu)
                        ->getOne("cpu", "page_id, elem_id");
                    if ($get_last_part_of_cpu_info) {
                        $get_required_cpu_info = $Cpu->getURLbyLang($get_last_part_of_cpu_info['page_id'], $get_last_part_of_cpu_info['elem_id'], $lang);
                        $sec = "5";
                        $status_info['success'][] = dictionary('CPU_PAGE_CHANGED_PAGE_REFRESH');
                        if (isset($exploded_url[1]) && $exploded_url[1] != "") {
                            $refresh_page = $get_required_cpu_info . "?" . $exploded_url[1];
                            header("Refresh: $sec; url=$refresh_page");
                        } else {
                            $refresh_page = $get_required_cpu_info;
                            header("Refresh: $sec; url=$refresh_page");
                        }
                    } else {
                        echo "CPU lang error!";
                        exit();
                    }
                }

            } else {
                $status_info['error'][] = $db->getLastError();
            }
        }

    }


        include $_SERVER['DOCUMENT_ROOT'].'/cp/php/templates/header.php';
        include $_SERVER['DOCUMENT_ROOT'].'/cp/php/templates/left-sidebar.php';
        ?>
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <?php $Cpu->top_block_info($cutpageinfo);?>
                <!-- /row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="white-box">
                            <div style="clear:both; height: 25px;"></div>
                            <?php
                            show_status_info($status_info);
                            ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <form id="check_required_fields" class="form-material form-horizontal" method="post" action="" enctype="multipart/form-data">
                                        <?php
                                        $curent_user = $User->getUser($User->getId());
                                        ?>
                                        <div class="form-group">
                                            <div class="col-md-12"><?php
                                                $user_status = $User->getCpUserStatus($curent_user['id']);
                                                echo dictionary('USER_STATUS_ON_SITE').' <span style="font-size: 14px;color: #fb9678;">'.mb_strtoupper($user_status['title_'.$Main->lang]).'</span>';?></div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-12"><?php echo dictionary('LANG');?></label>
                                            <div class="col-sm-12">
                                                <select class="form-control" name="lang">
                                                    <?php
                                                    foreach ($list_of_site_langs as $site_langs)
                                                    {
                                                        if( $curent_user['lang'] == $site_langs )
                                                        {
                                                            ?>
                                                                <option selected value="<?php echo $site_langs; ?>"><?php echo strtoupper($site_langs);?></option>
                                                            <?php
                                                        }
                                                        else
                                                        {
                                                            ?>
                                                                <option value="<?php echo $site_langs; ?>"><?php echo  strtoupper($site_langs);?></option>
                                                            <?php
                                                        }

                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-12"><?php echo dictionary('FIRST_NAME');?> <span style="color: red;">*</span></label>
                                            <div class="col-md-12">
                                                <input type="text" name="first_name" value="<?php echo $curent_user['first_name'];?>"
                                                       class="form-control required" placeholder="">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-12"><?php echo dictionary('LAST_NAME');?> <span style="color: red;">*</span></label>
                                            <div class="col-md-12">
                                                <input type="text" name="last_name" value="<?php echo $curent_user['last_name'];?>"
                                                       class="form-control required" placeholder="">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-12"><?php echo dictionary('EMAIL');?> <span style="color: red;">*</span></label>
                                            <div class="col-md-12">
                                                <input id="check_email" type="text" name="email" value="<?php echo $curent_user['email'];?>"
                                                       class="form-control required" placeholder="">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-12"><?php echo dictionary('PHONE_NUMBER');?> <span style="color: red;">*</span></label>
                                            <div class="col-md-12">
                                                <input type="text" name="phone" value="<?php echo $curent_user['phone'];?>"
                                                       class="form-control required" placeholder="">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12"><?php echo dictionary('IMAGE');?> <span style="color: red;">*</span></label>
                                            <?php
                                            $image_path =  $_SERVER['DOCUMENT_ROOT'].'/uploads/cp_user_photo/'.$curent_user['image'];
                                            if(isset($curent_user['image']) && $curent_user['image']!="" && is_file($image_path))
                                            {
                                                $imagethumg = newthumbs( $curent_user['image'] , 'cp_user_photo', 200, 200, 2, 0);
                                                ?>
                                                <div class="col-md-12" style="text-align: center;">
                                                    <img style="max-width: 200px; max-height: 200px;" src="<?php echo $imagethumg;?>">
                                                </div>
                                                <?php
                                            }
                                            ?>

                                            <div class="col-sm-12">
                                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                                    <div class="form-control" data-trigger="fileinput">
                                                        <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                                        <span class="fileinput-filename"></span>
                                                    </div>
                                                    <span class="input-group-addon btn btn-default btn-file">
                                                        <span class="fileinput-new">Select file</span>
                                                        <span class="fileinput-exists">Change</span>
                                                        <input type="hidden" name="old_image" value="<?php echo $curent_user['image'];?>">
                                                        <?php
                                                        if( isset($curent_user['image']) && $curent_user['image']!="" && is_file($image_path) )
                                                        {
                                                            ?>
                                                            <input type="file" name="image">
                                                            <?php
                                                        }
                                                        else
                                                        {
                                                            ?>
                                                            <input type="file" class="required" name="image">
                                                            <?php
                                                        }
                                                        ?>
                                                    </span>
                                                    <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                                </div>
                                            </div>
                                        </div>

                                        <div style="clear:both; height: 50px;"></div>
                                        <div class="form-group">
                                            <label class="col-md-12"><?php echo dictionary('CHANGE_PASSWORD');?></label>
                                            <div class="col-md-12">
                                                <input id="password" type="password" name="password" value="" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-12"><?php echo dictionary('CONFIRM_PASSWORD');?></label>
                                            <div class="col-md-12">
                                                <input id="confirm_password" type="password" name="confirm_password" value="" class="form-control">
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
                <?php include $_SERVER['DOCUMENT_ROOT'].'/cp/php/templates/right-sidebar.php'; ?>
            </div>
            <!-- /.container-fluid -->
            <?php include $_SERVER['DOCUMENT_ROOT'].'/cp/php/templates/footer.php'; ?>
        </div>
        <!-- /#page-wrapper -->
        </div>
        <!-- /#wrapper -->
        </body>
        <script>
            function validateEmail($email) {
                var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                if( !emailReg.test( $email ) ) {
                    return false;
                } else {
                    return true;
                }
            }



            $('#check_required_fields').submit(function() {

                var emailaddress = $('input#check_email').val().trim();
                var password =  $('input#password').val().trim();
                var confirm_password =  $('input#confirm_password').val().trim();

                if( !validateEmail(emailaddress)) {
                    alert("<?php echo dictionary('WRONG_EMAIL_FORMAT');?>");
                    return false;
                }

                var return_status = true;
                var data = {};
                data['task'] = 'check_user_profile_dates';
                data['password'] = password;
                data['confirm_password'] = confirm_password;

                $.ajax({
                    type: "POST",
                    'async': false,
                    url: "/cp_ajax_<?php echo $Main->lang;?>/",
                    data: data,
                    dataType: "json",
                    success: function (msg) {
                                                //console.log(msg);
                                                if (msg['error'].length>0) {
                                                    for(i=0; i<msg['error'].length;i++)
                                                    {
                                                        alert(msg['error'][i]);
                                                    }
                                                    return_status = false;
                                                    $('input#password').closest('.form-group').find('label').css('color', '#ff460e');
                                                    $('input#confirm_password').closest('.form-group').find('label').css('color', '#ff460e');
                                                }
                                            }
                });


                return return_status;

            });
        </script>
        </html>
        <?php
}
else
{
    header("location: ".$Cpu->getURL(5));
}

?>


