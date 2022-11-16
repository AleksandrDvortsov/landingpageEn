<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/cp/class/include.php';
if($User->check_cp_authorization())
{
    if ($User->access_control($client_access))
    {
        $status_info = array();
        if (isset($_POST['submit']))
        {
            $ar_post_clean = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $login = $db->escape($ar_post_clean['login']);
            $usergroup = $db->escape($ar_post_clean['usergroup']);
            $lang = $db->escape($ar_post_clean['lang']);
            $active = 0; if(isset($ar_post_clean['active']) && $ar_post_clean['active'] == 'on') { $active = 1; }
            $first_name = $db->escape($ar_post_clean['first_name']);
            $last_name = $db->escape($ar_post_clean['last_name']);
            $email = $db->escape($ar_post_clean['email']);
            $phone = $db->escape($ar_post_clean['phone']);
            $password = $db->escape($ar_post_clean['password']);
            $confirm_password = $db->escape($ar_post_clean['confirm_password']);

            $password = $db->escape($ar_post_clean['password']);
            $confirm_password = $db->escape($ar_post_clean['confirm_password']);
            $change_password_status = false;
            // Aici avem o dublare de contral a parolei ( prima merge prin ajax )
            if(strlen($password) > 0)
            {
                if ( strlen($password) < 8 || !preg_match("#[0-9]+#",$password) || !preg_match("#[a-zA-Z]+#", $password) )
                {
                    $status_info['error'][] = dictionary('ENTERED_PASSWORD_REQUIREMENTS');
                }
                if ($password!=$confirm_password)
                {
                    $status_info['error'][] = dictionary('ENTERED_PASSWORDS_NOT_MATCH');
                }
            }

            $uploaded_images_info = array();
            if (isset($_FILES['image']) && count($_FILES['image'])>0)
            {
                $uploaded_images_info = $Form->post_add_image('cp_user_photo',$_FILES, 'image');
            }

            if(count($uploaded_images_info) == 0)
            {
                $status_info['error'][] = dictionary('ERROR_LOADING_IMAGE');
            }

            if( !isset($status_info['error']) )
            {
                $new_ecrypt_password = $User->encrypt($password);
                $data_user_info = Array(
                                        "login" => $login,
                                        "usergroup" => $usergroup,
                                        "lang" => $lang,
                                        "active" => $active,
                                        "first_name" => $first_name,
                                        "last_name" => $last_name,
                                        "email" => $email,
                                        "phone" => $phone,
                                        "image" => $uploaded_images_info['image'],
                                        "password" => $new_ecrypt_password,
                                        "createdAt" => $db->now()
                                        );

                $id = $db->insert ('cp_users', $data_user_info);

                if ($id)
                {
                    $status_info['success'][] = dictionary('SUCCESSFULLY_ADDED');
                }
                else
                {
                    $status_info['error'][] =  $db->getLastError();
                }
            }
        }

            include $_SERVER['DOCUMENT_ROOT'] . '/cp/php/templates/header.php';
            include $_SERVER['DOCUMENT_ROOT'] . '/cp/php/templates/left-sidebar.php';
            ?>
            <!-- Page Content -->
            <div id="page-wrapper">
                <div class="container-fluid">
                    <?php $Cpu->top_block_info($cutpageinfo); ?>
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
                                        <form id="check_required_fields" class="form-material form-horizontal"
                                              method="post"
                                              action="" enctype="multipart/form-data">

                                            <div class="form-group">
                                                <label class="col-md-12"><?php echo dictionary('USER_LOGIN'); ?> <span
                                                            style="color: red;">*</span></label>
                                                <div class="col-md-12">
                                                    <input id="user_login_value" onkeyup="check_cp_user_login($(this).val().trim())" onchange ="check_cp_user_login($(this).val().trim())"  type="text" name="login" value=""
                                                           onpaste="this.onchange();" class="form-control first_letter_not_numeric required" placeholder="">
                                                </div>
                                                <div style="color:red;" class="col-md-12" id="user_login_info"></div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-12"><?php echo dictionary('USER_STATUS_ON_SITE'); ?></label>
                                                <div class="col-sm-12">
                                                    <select class="form-control" name="usergroup">
                                                        <?php
                                                        $curent_user = $User->getUser($User->getId());

                                                        if($curent_user['usergroup'] != 1)
                                                        {
                                                            $get_status_list = $db
                                                                ->where('id', 1, '<>')
                                                                ->get("user_group");
                                                        }
                                                        else
                                                        {
                                                            $get_status_list = $db
                                                                ->get("user_group");
                                                        }


                                                        foreach ($get_status_list as $status_list)
                                                        {
                                                            ?>
                                                            <option
                                                                    value="<?php echo $status_list['id']; ?>"><?php echo $status_list['title_'.$Main->lang]; ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="col-md-12"><?php echo dictionary('LANG'); ?></label>
                                                <div class="col-sm-12">
                                                    <select class="form-control" name="lang">
                                                        <?php
                                                        foreach ($list_of_site_langs as $site_langs)
                                                        {
                                                            ?>
                                                            <option
                                                                value="<?php echo $site_langs; ?>"><?php echo strtoupper($site_langs); ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-12"><?php echo dictionary('ACTIVE');?></label>
                                                <div class="col-md-12">
                                                    <input type="checkbox" name="active" checked
                                                           class="form-control" placeholder="" style="float: left; width: 50px;">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-12"><?php echo dictionary('FIRST_NAME'); ?> <span
                                                        style="color: red;">*</span></label>
                                                <div class="col-md-12">
                                                    <input type="text" name="first_name" value=""
                                                           class="form-control required" placeholder="">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-12"><?php echo dictionary('LAST_NAME'); ?> <span
                                                        style="color: red;">*</span></label>
                                                <div class="col-md-12">
                                                    <input type="text" name="last_name" value=""
                                                           class="form-control required" placeholder="">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-12"><?php echo dictionary('EMAIL'); ?> <span
                                                        style="color: red;">*</span></label>
                                                <div class="col-md-12">
                                                    <input id="check_email" type="text" name="email" value=""
                                                           class="form-control required" placeholder="">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-12"><?php echo dictionary('PHONE_NUMBER'); ?> <span
                                                        style="color: red;">*</span></label>
                                                <div class="col-md-12">
                                                    <input type="text" name="phone" value=""
                                                           class="form-control required" placeholder="">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-12"><?php echo dictionary('IMAGE'); ?> <span
                                                        style="color: red;">*</span></label>
                                                <div class="col-sm-12">
                                                    <div class="fileinput fileinput-new input-group"
                                                         data-provides="fileinput">
                                                        <div class="form-control" data-trigger="fileinput">
                                                            <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                                            <span class="fileinput-filename"></span>
                                                        </div>
                                                        <span class="input-group-addon btn btn-default btn-file">
                                                        <span class="fileinput-new">Select file</span>
                                                        <span class="fileinput-exists">Change</span>
                                                        <input type="file" class="required" name="image">
                                                    </span>
                                                        <a href="#"
                                                           class="input-group-addon btn btn-default fileinput-exists"
                                                           data-dismiss="fileinput">Remove</a>
                                                    </div>
                                                </div>
                                            </div>

                                            <div style="clear:both; height: 50px;"></div>
                                            <div class="form-group">
                                                <label
                                                    class="col-md-12"><?php echo dictionary('ADD_PASSWORD'); ?> <span
                                                            style="color: red;">*</span></label>
                                                <div class="col-md-12">
                                                    <input id="password" type="password" name="password" value=""
                                                           class="form-control required" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label
                                                    class="col-md-12"><?php echo dictionary('CONFIRM_PASSWORD'); ?> <span
                                                            style="color: red;">*</span></label>
                                                <div class="col-md-12">
                                                    <input id="confirm_password" type="password" name="confirm_password"
                                                           value="" class="form-control required" autocomplete="off">
                                                </div>
                                            </div>

                                            <button style="float:right;" type="submit" name="submit"
                                                    class="btn btn-success waves-effect waves-light m-r-10"><?php echo dictionary('SUBMIT'); ?>
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
            <script>
                function validateEmail($email) {
                    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                    if (!emailReg.test($email)) {
                        return false;
                    } else {
                        return true;
                    }
                }

                function check_cp_user_login( login )
                {
                    var data = {};
                    data['task'] = 'check_cp_user_login';
                    data['login'] = login;

                    $.ajax({
                        type: "POST",
                        url: "/cp_ajax_<?php echo $Main->lang;?>/",
                        data: data,
                        dataType: "html",
                        success: function (msg) {
                            //console.log(msg);
                            $("#user_login_info").html(msg);
                        }
                    });

                }

                $('#check_required_fields').submit(function () {

                    var emailaddress = $('input#check_email').val().trim();
                    var password = $('input#password').val().trim();
                    var confirm_password = $('input#confirm_password').val().trim();
                    var login =  $('input#user_login_value').val().trim();

                    if (!validateEmail(emailaddress)) {
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
                            if (msg['error'].length > 0) {
                                for (i = 0; i < msg['error'].length; i++) {
                                    alert(msg['error'][i]);
                                }
                                return_status = false;
                                $('input#password').closest('.form-group').find('label').css('color', '#ff460e');
                                $('input#confirm_password').closest('.form-group').find('label').css('color', '#ff460e');
                            }
                        }
                    });


                    var data2 = {};
                    data2['task'] = 'check_cp_user_login';
                    data2['login'] = login;

                    $.ajax({
                        type: "POST",
                        'async': false,
                        url: "/cp_ajax_<?php echo $Main->lang;?>/",
                        data: data2,
                        dataType: "html",
                        success: function (msg)
                        {
                            if(msg.trim()!="")
                            {
                                return_status = false;
                                alert(msg);
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
        include_once $_SERVER['DOCUMENT_ROOT'] . '/cp/php/templates/not_authorized_to_view_page.php';
    }
}
else
{
    header("location: ".$Cpu->getURL(5));
}

?>


