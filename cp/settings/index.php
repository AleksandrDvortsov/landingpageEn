<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/cp/class/include.php';

if($User->check_cp_authorization())
{
    if($User->access_control($client_access)) {

        include $_SERVER['DOCUMENT_ROOT'] . '/cp/php/templates/header.php';
        include $_SERVER['DOCUMENT_ROOT'] . '/cp/php/templates/left-sidebar.php';

        $status_info = array();
        if(isset($_POST['submit']))
        {
            $ar_post_clean = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            //--------------------------------------------------------------------------------------------------------//
            if (isset($_FILES['image']['tmp_name']) && $_FILES['image']['tmp_name'] != '')
            {
                $uploaded_images_info = $Form->post_add_image('settings',$_FILES, 'image');
                if(count($uploaded_images_info) == 0)
                {
                    $status_info['error'][] = dictionary('ERROR_LOADING_IMAGE');
                }
                //remove all old images
                if( !($Form->remove_image('settings', $db->escape($ar_post_clean['old_image']))) )
                {
                    $status_info['error'][] = dictionary('COULD_NOT_DELETE_OLD_IMAGES');
                }
            }
            else
            {
                $uploaded_images_info['image'] = $db->escape($ar_post_clean['old_image']);
            }

            $data_list = Array (
                "value" => $uploaded_images_info['image']
            );

            $db->where ('code', 'BACKGROUND_IMAGE');
            if(!$db->update ('settings', $data_list, 1))
            {
                $status_info['error'][] = 'Erori la inoirea datelor paginii principale a panoului administrativ';
            }

            //--------------------------------------------------------------------------------------------------------//
            $data_list_logo_info_value = $Form->post_edit_simple_image('settings', 'logo_image', $ar_post_clean['old_logo_image'], $_FILES );

            $data_list_logo_info = Array (
                "value" => $data_list_logo_info_value
            );

            $db->where ('code', 'SITE_FRONT_LOGO');
            if(!$db->update ('settings', $data_list_logo_info, 1))
            {
                $status_info['error'][] = 'Erori la inoirea LOGO imaginii';
            }

            //--------------------------------------------------------------------------------------------------------//

            if(isset($ar_post_clean['main_lang']) && !empty($ar_post_clean['main_lang']))
            {
                $main_lang_data = Array (
                    "value" => $ar_post_clean['main_lang']
                );
                $db->where ('code', 'LANG_MAIN');
                if($db->update ('settings', $main_lang_data, 1))
                {
                    // Innoim datele CPU a limbii selectate
                    // Initial inseram date gunoi in cimpurile care raspunde pentru cpu a limbii saiturilor ( pentru evitarea erorilor la inoirea datelor din cauza cimpului unical `cpu` )
                    foreach ($list_of_site_langs as $site_langs)
                    {
                        $uniq_cpu = uniqid("lang_");
                        $uniq_cpu_lang_update_data = Array ('cpu' => $uniq_cpu);
                        $uniq_cpu_lang_update = $db
                            ->where ('page_id', 100)
                            ->where('elem_id', 0)
                            ->where('lang', $site_langs)
                            ->update ('cpu', $uniq_cpu_lang_update_data, 1);
                    }

                    // Acum doar modificam datele de care avem nevoie
                    foreach ($list_of_site_langs as $site_langs)
                    {
                        if($site_langs == $ar_post_clean['main_lang'])
                        {
                            $cpu_lang_update_data = Array ('cpu' => '');
                        }
                        else
                        {
                            $cpu_lang_update_data = Array ('cpu' => $site_langs);
                        }

                        $cpu_lang_update_data = $db
                            ->where ('page_id', 100)
                            ->where('elem_id', 0)
                            ->where('lang', $site_langs)
                            ->update ('cpu', $cpu_lang_update_data, 1);
                        if(!$cpu_lang_update_data)
                        {
                            $status_info['error'][] = 'Erori la inoirea datelor despre limba principala a saitului, pentru: '.$site_langs;
                        }

                    }
                }
                else
                {
                    $status_info['error'][] = 'Erori la inoirea datelor despre limba principala a saitului';
                }
            }

            //--------------------------------------------------------------------------------------------------------//
            $status_info['success'][] = dictionary('SUCCESSFULLY_UPDATED');
        }
        ?>
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <?php $Cpu->top_block_info($cutpageinfo);?>
                <!-- /row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="white-box">
                        <?php
                        show_status_info($status_info);
                        ?>
                            <p class="text-muted"><?php echo dictionary('CLICK_WORD_CHANGE_ENTER');?></p>
                            <div class="wrapper">
                                <div class="table_wrap">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th><?php echo dictionary('CODE');?></th>
                                            <th><?php echo dictionary('DESCRIPTION');?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $get_settings_code = $db
                                            ->where("active", 1)
                                            ->where('code', 'BACKGROUND_IMAGE', '<>')
                                            ->orderBy('sort', 'asc')
                                            ->get("settings");
                                        if ($get_settings_code)
                                        {
                                            foreach ($get_settings_code as $setting_code)
                                            {
                                                ?>
                                                <tr <?php if(isset($setting_code['style'])) { ?> style="background: <?php echo $setting_code['style'];?>" <?php } ;?>>
                                                    <td data-label="<?php echo dictionary('CODE');?>">
                                                        <?php echo $setting_code['code']; ?>
                                                        <div style="font-size: 10px;"><?php echo $setting_code['description']; ?></div>
                                                    </td>
                                                    <td data-label="<?php echo dictionary('DESCRIPTION');?>">
                                                        <input class="input_focusof" type="text" name="name"
                                                            <?php if(isset($setting_code['style'])) { ?> style="background: <?php echo $setting_code['style'];?>" <?php } ;?>
                                                               value="<?php echo $setting_code['value']; ?>"
                                                               onchange="change_site_options_value('<?php echo $setting_code['id']; ?>',$(this).val());"
                                                               onpaste="this.onchange();">
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                        </tbody>
                                        <tfoot>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <div style="clear:both; width:100%;margin-bottom: 50px;"></div>
                            <form id="check_required_fields" class="form-material form-horizontal" method="post" action="" enctype="multipart/form-data">
                                <div id="item_description">

                                    <div class="form-group">
                                        <label class="col-md-12"><?php echo dictionary('MAIN_LANGUAGE_OF_THE_SAIT'); ?></label>
                                        <div class="col-sm-12">
                                            <select class="form-control" id="usergroup_list" name="main_lang">
                                                <?php
                                                $get_selected_main_language = $db
                                                    ->where('code', 'LANG_MAIN')
                                                    ->getOne("settings");

                                                $selected_main_language = $get_selected_main_language['value'];
                                                foreach ($list_of_site_langs as $site_langs)
                                                {
                                                    ?>
                                                    <option
                                                            <?php if($selected_main_language == $site_langs) { ?> selected <?php } ?>
                                                            value="<?php echo $site_langs; ?>"><?php echo  mb_ucfirst($site_langs);?>
                                                    </option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>


                                    <?php
                                    $get_logo_image_name = $db
                                        ->where('code', 'SITE_FRONT_LOGO')
                                        ->getOne("settings");

                                    $Form->edit_image($get_logo_image_name['value'], 'settings', 'logo_image', 1, dictionary('CP_FRONT_LOGO'));


                                    $get_background_image_name = $db
                                        ->where('code', 'BACKGROUND_IMAGE')
                                        ->getOne("settings");

                                    $Form->edit_image($get_background_image_name['value'], 'settings', 'image', 1, dictionary('CP_MAINPAGE_BACKGROUND_IMAGE'));
                                    ?>
                                </div>

                                <button style="float:right;" type="submit" name="submit"
                                        class="btn btn-success waves-effect waves-light m-r-10"><?php echo dictionary('SUBMIT');?>
                                </button>

                                <div style="clear: both;"></div>
                            </form>
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
        exit();
    }
}
else
{
    header("location: ".$Cpu->getURL(5));
}