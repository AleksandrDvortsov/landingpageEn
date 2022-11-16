<?php
usleep(20000);
require_once $_SERVER['DOCUMENT_ROOT'].'/cp/class/include.php';
$ar_get_clean = filter_input_array(INPUT_GET, FILTER_SANITIZE_SPECIAL_CHARS);
$ar_post_clean = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);



//==================================================================================================

//REFRESH CAPTCHA
if($ar_post_clean['task']=='refreshCaptcha')
{
    require_once $_SERVER['DOCUMENT_ROOT'].'/libraries/captcha/index.php';
    echo json_encode($_SESSION['captcha']['image_src']);
    exit;
}
//==================================================================================================

//change_site_options_value
if( isset($ar_post_clean['task'],$ar_post_clean['id'],$ar_post_clean['value']) && $ar_post_clean['task']=='change_site_options_value' && $ar_post_clean['id']>0 )
{
    $status = "";
    $data = Array (
        'value' => $ar_post_clean['value']
    );

    $db->where ('id', $ar_post_clean['id']);
    if ($db->update ('settings', $data, 1))
    {
        //$status = "successfully updated!";
    }
    else
    {
        $status = "Возникла ошибка при обновлении данных, пожалуйста обратитесь к администратору сайта";
    }

    echo json_encode($status);
    exit;
}
//==================================================================================================

//change_dictionary_input_value
if( isset($ar_post_clean['task'],$ar_post_clean['id'],$ar_post_clean['field'],$ar_post_clean['value']) &&
    trim($ar_post_clean['field'])!="" && $ar_post_clean['task']=='change_dictionary_input_value' && $ar_post_clean['id']>0 )
{
    $status = "";
    $field = 'title_'.$ar_post_clean['field'];
    $data = Array (
        $field => trim($ar_post_clean['value'])
    );

    $db->where ('id', $ar_post_clean['id']);
    if ($db->update ('dictionary', $data, 1))
    {
        //$status = "successfully updated!";
    }
    else
    {
        $status = "Возникла ошибка при обновлении данных, пожалуйста обратитесь к администратору сайта";
    }

    echo json_encode($status);
    exit;
}
//==================================================================================================

//==================================================================================================
//add_phone_field
if( isset($ar_post_clean['task']) && $ar_post_clean['task']=='add_phone_field' )
{
    ?>
    <div class="phone_block">
        <input  type="text" name="phone[]" class="form-control required">
        <button onclick='remove_phone_field(this)' class="delete_button sp_cl1" type="button" title="Delete"></button>
    </div>
    <?php
    exit;
}

//==================================================================================================
//add_company_link_field
if( isset($ar_post_clean['task']) && $ar_post_clean['task']=='add_company_link_field' )
{
    ?>
    <div class="company_link_block">
        <input  type="text" name="company_link[]" class="form-control required">
        <button onclick='remove_company_link_field(this)' class="delete_button sp_cl1" type="button" title="Delete"></button>
    </div>
    <?php
    exit;
}

//==================================================================================================
//add_call_reports
if( isset($ar_post_clean['task'],$ar_post_clean['call_reports']) && $ar_post_clean['task']=='add_call_reports' && $validator->check_int($ar_post_clean['call_reports']) && $ar_post_clean['call_reports']>0)
{
    $call_reports = $ar_post_clean['call_reports'];
    ?>
    <div class="call_reports_block">
        <div class="extra_crf_block">
            <input type="datetime-local" name="call_reports[<?php echo $call_reports;?>][0]" value="<?php echo strftime('%Y-%m-%dT%H:%M', time());?>">
            <button onclick='call_reports_block(this)' class="delete_button sp_cl1" type="button" title="Delete"></button>
            <textarea name="call_reports[<?php echo $call_reports;?>][1]" class="form-control required"></textarea>
        </div>
    </div>
    <?php
    exit;
}

//==================================================================================================
if( isset($ar_post_clean['task'],$ar_post_clean['password'], $ar_post_clean['confirm_password']) && $ar_post_clean['task']=='check_user_profile_dates')
{
    $PostData = array();
    $PostData['error'] = array();

    if(strlen($ar_post_clean['password']) > 0)
    {
        if ( strlen($ar_post_clean['password']) < 8 || !preg_match("#[0-9]+#", $ar_post_clean['password']) || !preg_match("#[a-zA-Z]+#", $ar_post_clean['password']) )
        {
            $PostData['error'][] = dictionary('ENTERED_PASSWORD_REQUIREMENTS');
        }

        if ($ar_post_clean['password']!=$ar_post_clean['confirm_password'])
        {
            $PostData['error'][] = dictionary('ENTERED_PASSWORDS_NOT_MATCH');
        }
    }
    echo json_encode($PostData);
    exit;
}

//==================================================================================================

// check_cp_user_login
if( isset($ar_post_clean['task'],$ar_post_clean['login']) && $ar_post_clean['task']=='check_cp_user_login' && $ar_post_clean['login']!="")
{
    $check_login = $db
        ->where('login', $db->escape($ar_post_clean['login']))
        ->getOne('cp_users','id');
    if($check_login)
    {
        echo 'Пользователь с таким логином уже существует';
    }
    exit;
}

//==================================================================================================

//delete_dropzone_temp_file
if( $ar_post_clean['task']=='delete_dropzone_temp_file' )
{
    $FileDirecotry = $_SERVER['DOCUMENT_ROOT'] . '/uploads/dropzone/temp_files/';
    if (is_file($FileDirecotry.$ar_post_clean['file_path']))
    {
        if(unlink($FileDirecotry.$ar_post_clean['file_path']))
        {
            $status = "File Removed!";
        }
        else
        {
            $status = "Error removing file!";
        }
    }
    else
    {
        $status = "Incorect path!";
    }

    echo json_encode($status);
    exit;


}
//==================================================================================================



//single_check_list_block
if( isset($ar_post_clean['task']) && $ar_post_clean['task']=='single_check_list_block' && trim($ar_post_clean['description'])!="")
{
    ?>
    <div class="single_check_list_block">
        <span class="check_list_number"></span><span>.</span>
        <input readonly  class="check_list_read_only check_list_single_input" type="text" name="check_list[]" value="<?php echo $ar_post_clean['description'];?>">
        <button type="button" class="delete_button remove_single_checklist"></button>
    </div>
    <?php
    exit;
}

//==================================================================================================




//==================================================================================================
//change_subcatalog_section
if( isset($ar_post_clean['task'],$ar_post_clean['subcatalog_section_id'],$ar_post_clean['db_filter_options_table'],$ar_post_clean['db_filter_options_values_table'])
    && $ar_post_clean['task']=='change_subcatalog_section'
    && is_numeric($ar_post_clean['subcatalog_section_id']) && $ar_post_clean['subcatalog_section_id']>0
    && !empty($ar_post_clean['db_filter_options_table']) && !empty($ar_post_clean['db_filter_options_values_table'])
)
{
    $catalog_id = (int)$ar_post_clean['subcatalog_section_id'];
    $db_filter_options_table = $Form->hide_dates('decrypt', $ar_post_clean['db_filter_options_table']);
    $db_filter_options_values_table = $Form->hide_dates('decrypt', $ar_post_clean['db_filter_options_values_table']);

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

    ?>
    <script type="text/javascript">
        $('.slimscroll_select_option').slimScroll({
            height: '150px',
            width: '100%',
            alwaysVisible: true
        });
    </script>
    <?php
    exit;
}
//==================================================================================================

if( isset($ar_post_clean['task'],$ar_post_clean['folder_name']) && $ar_post_clean['task']=='check_root_folders' && trim($ar_post_clean['folder_name'])!="" )
{
    $ajax_data = array();

    $dir = trim($ar_post_clean['folder_name']);
    $path_target = $_SERVER['DOCUMENT_ROOT'].'/';

    $result = is_dir($path_target . $dir);
    if ($result)
    {
        $ajax_data['error'] = dictionary('FOLDER_ALREADY_EXIST');
    }

    echo json_encode($ajax_data);
    exit;
}

//==================================================================================================

if( isset($ar_post_clean['task'],$ar_post_clean['folder_name']) && $ar_post_clean['task']=='check_text_page_files' && trim($ar_post_clean['folder_name'])!="" )
{
    $ajax_data = array();

    $file = trim($ar_post_clean['folder_name']).'.php';
    $path_target = $_SERVER['DOCUMENT_ROOT'].'/text_page/'.$file;

    $result = file_exists($path_target);
    if ($result)
    {
        $ajax_data['error'] = dictionary('FILE_ALREADY_EXIST');
    }

    echo json_encode($ajax_data);
    exit;
}

//==================================================================================================


if( isset($ar_post_clean['task'],$ar_post_clean['mysql_table_name']) && $ar_post_clean['task']=='check_mysql_table' && trim($ar_post_clean['mysql_table_name'])!="" )
{
    $ajax_data = array();
    if ($db->tableExists ($ar_post_clean['mysql_table_name']))
    {
        $ajax_data['error'] = dictionary('MYSQL_TABLE_ALREADY_EXIST');
    }
    echo json_encode($ajax_data);
    exit;
}

//==================================================================================================

//==================================================================================================

if( isset($ar_post_clean['task'],$ar_post_clean['folder_name']) && $ar_post_clean['task']=='check_cp_simple_page_files' && trim($ar_post_clean['folder_name'])!="" )
{
    $ajax_data = array();

    $file = trim($ar_post_clean['folder_name']).'.php';
    $path_target = $_SERVER['DOCUMENT_ROOT'].'/cp/simple_page/'.$file;

    $result = file_exists($path_target);
    if ($result)
    {
        $ajax_data['error'] = dictionary('FILE_ALREADY_EXIST');
    }

    echo json_encode($ajax_data);
    exit;
}

//==================================================================================================


































//==================================================================================================
//search_company
if( isset($ar_post_clean['task'],$ar_post_clean['search_value']) && $ar_post_clean['task']=='search_user')
{
    $current_user_id = $User->getId();
    $searched_value = $ar_post_clean['search_value'];
    if(trim($searched_value)!="")
    {
        $users_list = $db->rawQuery ('
                                      Select
                                              *

                                      from
                                            '.$db::$prefix.'cp_users

                                      where
                                            login LIKE \'%'.$searched_value.'%\'

                                          GROUP BY id
                                     ');
    }
    else
    {
        $users_list = $db
            ->get("cp_users");
    }


    foreach ($users_list as $user)
    {
        $user_status = $User->getCpUserStatus($user['id']);
        ?>
        <tr <?php if($user['active'] == 0) { ?>style="background: #cfd6de;" <?php } ?>>
            <td style="vertical-align: middle;"><?php echo $user['login'];?></td>
            <td style="vertical-align: middle;"><?php echo $user_status['title_'.$Main->lang];?></td>
            <td>
                <?php
                $image_path = $_SERVER['DOCUMENT_ROOT'] . '/uploads/cp_user_photo/' . $user['image'];
                if (isset($user['image']) && $user['image'] != "" && is_file($image_path)) {
                    $imagethumg = newthumbs($user['image'], 'cp_user_photo', 100, 100, 3, 1);
                    ?>
                    <div class="col-md-12" style="text-align: center;">
                        <img src="<?php echo $imagethumg; ?>">
                    </div>
                <?php
                }
                ?>
            </td>
            <td style="width: 60px;vertical-align: middle;">
                <a href="<?php echo $Cpu->getURL(35);?>?id=<?php echo $user['id'] ?>">
                    <button class="edit_button" type="button" title="Edit"></button>
                </a>
                <?php
                /*
                <a href="<?php echo $Cpu->getURL(36);?>?id=<?php echo $user['id'] ?>"
                   onclick="return confirm('<?php echo dictionary('CONFIRM_DELETE_ELEMENT');?>');">
                    <button class="delete_button" type="button"
                            title="Delete"></button>
                </a>
                */
                ?>
            </td>
        </tr>
    <?php
    }

    exit;
}

//==================================================================================================
//search_cp_pages
if( isset($ar_post_clean['task'],$ar_post_clean['search_value']) && $ar_post_clean['task']=='search_cp_pages')
{
    $current_user_id = $User->getId();
    $searched_value = $ar_post_clean['search_value'];
    if(trim($searched_value)!="")
    {
        if(!$User->access_control($developer_access))
        {
            $get_cp_pages = $db->rawQuery ('
                                      Select
                                              *

                                      from
                                            '.$db::$prefix.'pages


                                      where
                                              (
                                                page LIKE \'%' . $searched_value . '%\'
                                             OR title_ru LIKE \'%' . $searched_value . '%\'
                                             OR title_ro LIKE \'%' . $searched_value . '%\'
                                             OR title_en LIKE \'%' . $searched_value . '%\'
                                             )
                                             AND edit_by_user = 1
                                             AND (
                                                    type = 0 OR type = 7 OR type = 10
                                                  )


                                        ORDER BY id ASC
                                     ');
        }
        else
        {
            $get_cp_pages = $db->rawQuery ('
                                      Select
                                              *

                                      from
                                            '.$db::$prefix.'pages


                                      where
                                              (
                                                page LIKE \'%' . $searched_value . '%\'
                                             OR title_ru LIKE \'%' . $searched_value . '%\'
                                             OR title_ro LIKE \'%' . $searched_value . '%\'
                                             OR title_en LIKE \'%' . $searched_value . '%\'
                                             )
                                             AND (
                                                    type = 0 OR type = 7 OR type = 10
                                                  )



                                        ORDER BY id ASC
                                     ');
        }

    }
    else
    {
        if(!$User->access_control($developer_access))
        {
            $get_cp_pages = $db
                ->where("edit_by_user", 1)
                ->where("type", 0)
                ->orWhere("type", 7)
                ->orWhere("type", 10)
                ->orderBy ("id","asc")
                ->get("pages");
        }
        else
        {
            $get_cp_pages = $db
                ->where("type", 0)
                ->orWhere("type", 7)
                ->orWhere("type", 10)
                ->orderBy ("id","asc")
                ->get("pages");
        }
    }

//
    foreach ($get_cp_pages as $cp_pages)
    {
        $exploded_url = array_filter( explode("/", $cp_pages['page']), 'strlen' );
        ?>
        <tr>
            <td data-label="<?php echo dictionary('ID');?>"><?php echo $cp_pages['id'];?></td>
            <td data-label="<?php echo dictionary('CODE');?>">
                <?php echo $cp_pages['page'];?>
            </td>
            <td data-label="<?php echo dictionary('DESCRIPTION');?>"><?php echo $cp_pages['title_'.$Main->lang];?></td>
            <td class="no_background">
                <a href="<?php echo $Cpu->getURL(11)?>?id=<?php echo $cp_pages['id']?>">
                    <button class="edit_button" type="button" title="Edit"></button>
                </a>
                <?php
                if( $exploded_url['1'] == 'text_page' || ($exploded_url['1'] == 'cp' && $exploded_url['2'] == 'simple_page') || in_array('index.php', $exploded_url) && !empty($cp_pages['dir_file_name']) )
                {
                    ?>
                    <a href="<?php echo $Cpu->getURL(208)?>?id=<?php echo $cp_pages['id']?>"
                       onclick="return confirm('<?php echo dictionary('CONFIRM_DELETE_PAGE');?>');">
                        <button class="delete_button" type="button" title="Delete"></button>
                    </a>
                <?php
                }
                ?>
            </td>
        </tr>
    <?php
    }

    exit;
}

//==================================================================================================


//search_site_pages
if( isset($ar_post_clean['task'],$ar_post_clean['search_value']) && $ar_post_clean['task']=='search_site_pages')
{
    $current_user_id = $User->getId();
    $searched_value = $ar_post_clean['search_value'];
    if(trim($searched_value)!="")
    {
        if(!$User->access_control($developer_access))
        {
            $get_site_pages = $db->rawQuery ('
                                      Select
                                              *

                                      from
                                            '.$db::$prefix.'pages


                                      where
                                              (
                                                page LIKE \'%' . $searched_value . '%\'
                                             OR title_ru LIKE \'%' . $searched_value . '%\'
                                             OR title_ro LIKE \'%' . $searched_value . '%\'
                                             OR title_en LIKE \'%' . $searched_value . '%\'
                                             )
                                             AND edit_by_user = 1
                                             AND (
                                                    type = 1 OR type = 7
                                                  )


                                        ORDER BY id ASC
                                     ');
        }
        else
        {
            $get_site_pages = $db->rawQuery ('
                                      Select
                                              *

                                      from
                                            '.$db::$prefix.'pages


                                      where
                                              (
                                                page LIKE \'%' . $searched_value . '%\'
                                             OR title_ru LIKE \'%' . $searched_value . '%\'
                                             OR title_ro LIKE \'%' . $searched_value . '%\'
                                             OR title_en LIKE \'%' . $searched_value . '%\'
                                             )
                                             AND (
                                                    type = 1 OR type = 7
                                                  )



                                        ORDER BY id ASC
                                     ');
        }

    }
    else
    {
        if(!$User->access_control($developer_access))
        {
            $get_site_pages = $db
                ->where("type", 1)
                ->orWhere("type", 7)
                ->where("edit_by_user", 1)
                ->orderBy ("id","asc")
                ->get("pages");
        }
        else
        {
            $get_site_pages = $db
                ->where("type", 1)
                ->orWhere("type", 7)
                ->orderBy ("id","asc")
                ->get("pages");
        }
    }

//
    foreach ($get_site_pages as $site_pages)
    {
        $exploded_url = array_filter( explode("/", $site_pages['page']), 'strlen' );
        ?>
        <tr>
            <td data-label="<?php echo dictionary('ID');?>"><?php echo $site_pages['id'];?></td>
            <td data-label="<?php echo dictionary('CODE');?>">
                <?php echo $site_pages['page'];?>
            </td>
            <td data-label="<?php echo dictionary('DESCRIPTION');?>"><?php echo $site_pages['title_'.$Main->lang];?></td>
            <td class="no_background">
                <a href="<?php echo $Cpu->getURL(46)?>?id=<?php echo $site_pages['id']?>">
                    <button class="edit_button" type="button" title="Edit"></button>
                </a>
                <?php
                if( $exploded_url['1'] == 'text_page' || in_array('index.php', $exploded_url) && !empty($site_pages['dir_file_name']) )
                {
                    ?>
                    <a href="<?php echo $Cpu->getURL(209)?>?id=<?php echo $site_pages['id']?>"
                       onclick="return confirm('<?php echo dictionary('CONFIRM_DELETE_PAGE');?>');">
                        <button class="delete_button" type="button" title="Delete"></button>
                    </a>
                <?php
                }
                ?>
            </td>
        </tr>
    <?php
    }

    exit;
}

//==================================================================================================


//search_dictionary_word
if( isset($ar_post_clean['task'],$ar_post_clean['search_value']) && $ar_post_clean['task']=='search_dictionary_word')
{
    $current_user_id = $User->getId();
    $searched_value = $ar_post_clean['search_value'];
    if(trim($searched_value)!="")
    {
        if(!$User->access_control($developer_access))
        {
            $get_settings_code = $db->rawQuery ('
                                      Select
                                              *

                                      from
                                            '.$db::$prefix.'dictionary

                                      where
                                            (
                                                code LIKE \'%' . $searched_value . '%\'
                                             OR title_ru LIKE \'%' . $searched_value . '%\'
                                             OR title_ro LIKE \'%' . $searched_value . '%\'
                                             OR title_en LIKE \'%' . $searched_value . '%\'
                                             )
                                             AND edit_by_user = 1

                                          GROUP BY id
                                     ');
        }
        else
        {
            $get_settings_code = $db->rawQuery ('
                                      Select
                                              *

                                      from
                                            '.$db::$prefix.'dictionary

                                      where
                                            (
                                                code LIKE \'%' . $searched_value . '%\'
                                             OR title_ru LIKE \'%' . $searched_value . '%\'
                                             OR title_ro LIKE \'%' . $searched_value . '%\'
                                             OR title_en LIKE \'%' . $searched_value . '%\'
                                             )



                                          GROUP BY id
                                     ');
        }


    }
    else
    {
        if(!$User->access_control($developer_access))
        {
            $get_settings_code = $db
                ->where("edit_by_user", 1)
                ->get("dictionary");
        }
        else
        {
            $get_settings_code = $db
                ->get("dictionary");
        }
    }

    foreach ($get_settings_code as $setting_code)
    {
        ?>
        <tr>
            <td data-label="<?php echo dictionary('CODE');?>">
                <?php echo $setting_code['code'];?>
            </td>
            <td data-label="<?php echo dictionary('LANG');?>">
                <?php
                foreach ( $list_of_site_langs as $site_langs)
                {
                    echo mb_ucfirst($site_langs) . ': <br>';
                }
                ?>
            </td>
            <td data-label="<?php echo dictionary('DESCRIPTION');?>">
                <?php
                foreach ( $list_of_site_langs as $site_langs)
                {
                    ?>
                    <input class="input_focusof" type="text"
                           data-language = "<?php echo $site_langs;?>"
                           value="<?php echo $setting_code['title_'.$site_langs];?>"
                           onchange="change_dictionary_input_value('<?php echo $setting_code['id']; ?>',$(this).data('language'),$(this).val());"
                           onpaste="this.onchange();">
                <?php
                }
                ?>
            </td>
            <?php
            if($User->access_control($developer_access))
            {
                ?>
                <td class="no_background">
                    <a href="<?php echo $Cpu->getURL(27);?>?id=<?php echo $setting_code['id'] ?>"
                       onclick="return confirm('<?php echo dictionary('CONFIRM_DELETE_ELEMENT');?>');">
                        <button class="delete_button" type="button"
                                title="Delete"></button>
                    </a>
                </td>
            <?php
            }
            ?>
        </tr>
    <?php
    }

    exit;
}

//==================================================================================================



//update_name_of_filemanager_element
if( isset($ar_post_clean['task'],$ar_post_clean['id'],$ar_post_clean['value'], $ar_post_clean['section_id']) && $ar_post_clean['task']=='update_name_of_filemanager_element' &&
    trim($ar_post_clean['value'])!="" &&  $ar_post_clean['id']>0 )
{
    $ajax_data = array();
    $ajax_data['file_name_updated'] = 0;
    $data = Array (
        'parent_id' => (int)$ar_post_clean['section_id'],
        'original_file_name' => $ar_post_clean['value']
    );

    $db->where ('id', $ar_post_clean['id']);
    if ($db->update ('file_manager_dropzone', $data, 1))
    {
        $ajax_data['status'] = dictionary('SUCCESSFULLY_UPDATED');
        $ajax_data['value'] = $ar_post_clean['value'];
        $ajax_data['file_name_updated'] = 1;
    }
    else
    {
        $ajax_data['status'] = dictionary('ERRORS_IN_URL_ADDRESS');
    }

    echo json_encode($ajax_data);
    exit;
}
//==================================================================================================

//edit_filemanager_element
if(
    isset($ar_post_clean['task'],$ar_post_clean['id']) && $ar_post_clean['task']=='edit_filemanager_element'
    && is_numeric($ar_post_clean['id']) && $ar_post_clean['id'] > 0
    && is_numeric($ar_post_clean['section_id'])
  )
{
    $catalog_id = (int)$ar_post_clean['section_id'];
    $db_catalog_table = 'file_manager_catalog';
    //controlam daca exista asa fisier in baza de date ( cu asa ID )
    $filemanager_element_info = $db
        ->where('id', (int)$ar_post_clean['id'])
        ->getOne('file_manager_dropzone');
    if($filemanager_element_info['original_file_name'])
    {
        ?>
        <div class="popUpgltop">
            <div class="close" onclick="close_popUpGal()"></div>
            <div style="clear:both; width: 100%; height: 5px;"></div>
            <div style="color: #8d9ea7; font-size: 14px;text-align: center;"><?php echo dictionary('EDIT_FILEMANAGER_ELEMENT');?></div>

            <form id="check_required_fields" method="post" action="">
                <div class="form-group">
                    <label class="col-md-12"><?php echo dictionary('SPECIFY_TARENT_SECTION');?> <span style="color: red;">*</span></label>
                    <div class="col-md-12">
                        <select class="form-control" id="section_id" name="section_id">
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

                <div class="clear"></div>
                <div class="form-group" style="margin-top: 10px;">
                    <label class="col-md-12"><?php echo dictionary('TITLE');?> <span style="color: red;">*</span></label>
                    <div class="col-md-12">
                        <input type="text" id="filemanager_name" value="<?php echo $filemanager_element_info['original_file_name'];?>"
                               class="form-control required" placeholder="" >
                    </div>
                </div>
                <div style="clear:both; width: 100%;"></div>
                <div id="filemanager_status_info"></div>
                <button style="float:right; margin-top:10px;" type="submit" name="submit"
                        class="btn btn-success waves-effect waves-light m-r-10"><?php echo dictionary('SUBMIT');?>
                </button>
            </form>
            <div style="clear:both; width: 100%; height: 15px;"></div>
        </div>
        <?php
    }
    else
    {
        ?>
        <div class="popUpgltop">
            <div class="close" onclick="close_popUpGal()"></div>
            <div style="clear:both; width: 100%; height: 5px;"></div>
            <div style="color: #8d9ea7; font-size: 14px;text-align: center;"><?php echo dictionary('ERRORS_IN_URL_ADDRESS');?></div>
            <div style="clear:both; width: 100%; height: 15px;"></div>
        </div>
        <?php
    }


    ?>
        <script>
            $('form#check_required_fields').submit(function()
            {
                var go_to_submit = true;
                $("#filemanager_status_info").html("");

                $( ".form-group label" ).each(function() {
                    $(this).css('color', '');
                });

                $( ".required" ).each(function() {
                    if(!$(this).val().trim())
                    {
                        // data[$(this).attr("name")] = $(this).closest('.form-group').find('label').text();
                        $(this).closest('.form-group').find('label').css('color', '#ff460e');
                        go_to_submit = false;
                    }

                });


                if(go_to_submit == false)
                {
                    alert("<?php echo dictionary('FILL_REQUIRED_FIELDS');?>");
                    return false;
                }
                else
                {
                    var element_id = parseInt("<?php echo (int)$ar_post_clean['id'];?>")
                    var initial_section_id = parseInt("<?php echo $catalog_id;?>");
                    var data = {};
                    data['task'] = 'update_name_of_filemanager_element';
                    data['id'] = element_id;
                    data['value'] = $('#filemanager_name').val().trim();

                    data['section_id'] = parseInt($('select#section_id option:selected').val())

                    $.ajax({
                        type: "POST",
                        url: "/cp_ajax_<?php echo $Main->lang;?>/",
                        data: data,
                        dataType: "json",
                        success: function (ajax_data)
                        {
                            if (ajax_data.hasOwnProperty('status') && ajax_data['status'] != "")
                            {
                                //$("#filemanager_status_info").html(ajax_data['status']);

                                if (ajax_data.hasOwnProperty('file_name_updated') && ajax_data['file_name_updated'] == 1)
                                {
                                    $('#filemanager_original_name_element_'+element_id).html(ajax_data['value']);
                                    if(initial_section_id != data['section_id'])
                                    {
                                        $('#filemanager_original_name_element_'+element_id).closest('.folder_block').remove();
                                    }
                                    close_popUpGal();
                                }
                                else
                                {
                                    $("#filemanager_status_info").html("<?php echo dictionary('ERRORS_IN_URL_ADDRESS');?>");
                                }

                            }
                            else
                            {
                                $("#filemanager_status_info").html("<?php echo dictionary('ERRORS_IN_URL_ADDRESS');?>");
                            }

                            
                        }
                    });

                }

                return false;
            });
        </script>
    <?php

}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//remove_element_of_filemanager
if( isset($ar_post_clean['task'],$ar_post_clean['id']) && $ar_post_clean['task']=='remove_element_of_filemanager' && $ar_post_clean['id']>0 )
{
    $ajax_data = array();
    $ajax_data['removed'] = 0;

    $filemanager_element_info = $db
        ->where('id', (int)$ar_post_clean['id'])
        ->getOne('file_manager_dropzone');
    if($filemanager_element_info)
    {
        $db->where('id', (int)$ar_post_clean['id']);
        if ($db->delete('file_manager_dropzone', 1))
        {
          $Form->remove_image('file_manager_dropzone', $filemanager_element_info['image']);
            $ajax_data['removed'] = 1;
        }
    }

    echo json_encode($ajax_data);
    exit;
}


// remove_filemanager_element
if( isset($ar_post_clean['task'],$ar_post_clean['id']) && $ar_post_clean['task']=='remove_filemanager_element'
    && is_numeric($ar_post_clean['id']) && $ar_post_clean['id'] > 0 )
{
    //controlam daca exista asa fisier in baza de date ( cu asa ID )
    $filemanager_element_info = $db
        ->where('id', (int)$ar_post_clean['id'])
        ->getOne('file_manager_dropzone');
    if($filemanager_element_info['original_file_name'])
    {
        ?>
        <div class="popUpgltop">
            <div class="close" onclick="close_popUpGal()"></div>
            <div style="clear:both; width: 100%; height: 5px;"></div>
            <div style="color: #8d9ea7; font-size: 14px;text-align: center;"><?php echo dictionary('CONFIRM_DELETE_ELEMENT');?></div>

            <form id="check_required_fields" method="post" action="">
                <div style="clear:both; width: 100%;"></div>
                <div id="filemanager_status_info"></div>
                <div style="position:relative; float:left; margin-top:10px; left: 30px;  background: #337ab7; border: none;"  onclick="close_popUpGal()"
                        class="btn btn-success waves-effect waves-light m-r-10"><?php echo dictionary('CANCEL');?>
                </div>
                <button style="position:relative; float:right; margin-top:10px; right: 20px; background: #ff6849; border: none;" type="submit" name="submit"
                        class="btn btn-success waves-effect waves-light m-r-10"><?php echo dictionary('DELETE');?>
                </button>
            </form>
            <div style="clear:both; width: 100%; height: 15px;"></div>
        </div>
        <?php
    }
    else
    {
        ?>
        <div class="popUpgltop">
            <div class="close" onclick="close_popUpGal()"></div>
            <div style="clear:both; width: 100%; height: 5px;"></div>
            <div style="color: #8d9ea7; font-size: 14px;text-align: center;"><?php echo dictionary('ERRORS_IN_URL_ADDRESS');?></div>
            <div style="clear:both; width: 100%; height: 15px;"></div>
        </div>
        <?php
    }


    ?>
    <script>
        $('form#check_required_fields').submit(function()
        {
            $("#filemanager_status_info").html("");

            var element_id = parseInt("<?php echo (int)$ar_post_clean['id'];?>")
            var data = {};
            data['task'] = 'remove_element_of_filemanager';
            data['id'] = element_id;

            $.ajax({
                type: "POST",
                url: "/cp_ajax_<?php echo $Main->lang;?>/",
                data: data,
                dataType: "json",
                success: function (ajax_data)
                {
                    if (ajax_data.hasOwnProperty('removed') && ajax_data['removed'] == 1)
                    {
                        $('#filemanager_original_name_element_'+element_id).closest('.folder_block').remove();
                        close_popUpGal();
                    }
                    else
                    {
                        $("#filemanager_status_info").html("<?php echo dictionary('ERRORS_IN_URL_ADDRESS');?>");
                    }


                }
            });

            return false;
        });
    </script>
    <?php

}






/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//update_name_of_filemanager_folder
if( isset($ar_post_clean['task'],$ar_post_clean['id'],$ar_post_clean['value'], $ar_post_clean['section_id']) && $ar_post_clean['task']=='update_name_of_filemanager_folder' &&
    trim($ar_post_clean['value'])!="" &&  $ar_post_clean['id']>0 )
{
    $ajax_data = array();
    $ajax_data['folder_name_updated'] = 0;
    $data = Array (
        'section_id' => (int)$ar_post_clean['section_id'],
    );

    foreach ($list_of_site_langs as $site_langs)
    {
        $data['title_'.$site_langs] = $db->escape($ar_post_clean['value']);
    }

    $db->where ('id', $ar_post_clean['id']);
    if ($db->update ('file_manager_catalog', $data, 1))
    {
        $ajax_data['status'] = dictionary('SUCCESSFULLY_UPDATED');
        $ajax_data['value'] = $ar_post_clean['value'];
        $ajax_data['folder_name_updated'] = 1;
    }
    else
    {
        $ajax_data['status'] = dictionary('ERRORS_IN_URL_ADDRESS');
    }

    echo json_encode($ajax_data);
    exit;
}
//edit_filemanager_folder
if(
    isset($ar_post_clean['task'],$ar_post_clean['id']) && $ar_post_clean['task']=='edit_filemanager_folder'
    && is_numeric($ar_post_clean['id']) && $ar_post_clean['id'] > 0
    && is_numeric($ar_post_clean['section_id'])
)
{
    $catalog_id = (int)$ar_post_clean['section_id'];
    $db_catalog_table = 'file_manager_catalog';
    //controlam daca exista asa fisier in baza de date ( cu asa ID )
    $filemanager_element_info = $db
        ->where('id', (int)$ar_post_clean['id'])
        ->getOne('file_manager_catalog', 'id, title_en');
    if($filemanager_element_info)
    {
        ?>
        <div class="popUpgltop">
            <div class="close" onclick="close_popUpGal()"></div>
            <div style="clear:both; width: 100%; height: 5px;"></div>
            <div style="color: #8d9ea7; font-size: 14px;text-align: center;"><?php echo dictionary('EDIT_FILEMANAGER_FOLDER');?></div>

            <form id="check_required_fields" method="post" action="">
                <div class="form-group">
                    <label class="col-md-12"><?php echo dictionary('SPECIFY_TARENT_SECTION');?> <span style="color: red;">*</span></label>
                    <div class="col-md-12">
                        <select class="form-control" id="section_id" name="section_id">
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

                <div class="clear"></div>
                <div class="form-group" style="margin-top: 10px;">
                    <label class="col-md-12"><?php echo dictionary('TITLE');?> <span style="color: red;">*</span></label>
                    <div class="col-md-12">
                        <input type="text" id="filemanager_name" value="<?php echo $filemanager_element_info['title_en'];?>"
                               class="form-control required" placeholder="" >
                    </div>
                </div>
                <div style="clear:both; width: 100%;"></div>
                <div id="filemanager_status_info"></div>
                <button style="float:right; margin-top:10px;" type="submit" name="submit"
                        class="btn btn-success waves-effect waves-light m-r-10"><?php echo dictionary('SUBMIT');?>
                </button>
            </form>
            <div style="clear:both; width: 100%; height: 15px;"></div>
        </div>
        <?php
    }
    else
    {
        ?>
        <div class="popUpgltop">
            <div class="close" onclick="close_popUpGal()"></div>
            <div style="clear:both; width: 100%; height: 5px;"></div>
            <div style="color: #8d9ea7; font-size: 14px;text-align: center;"><?php echo dictionary('ERRORS_IN_URL_ADDRESS');?></div>
            <div style="clear:both; width: 100%; height: 15px;"></div>
        </div>
        <?php
    }


    ?>
    <script>
        $('form#check_required_fields').submit(function()
        {
            var go_to_submit = true;
            $("#filemanager_status_info").html("");

            $( ".form-group label" ).each(function() {
                $(this).css('color', '');
            });

            $( ".required" ).each(function() {
                if(!$(this).val().trim())
                {
                    $(this).closest('.form-group').find('label').css('color', '#ff460e');
                    go_to_submit = false;
                }

            });


            if(go_to_submit == false)
            {
                alert("<?php echo dictionary('FILL_REQUIRED_FIELDS');?>");
                return false;
            }
            else
            {
                var element_id = parseInt("<?php echo (int)$ar_post_clean['id'];?>")
                var initial_section_id = parseInt("<?php echo $catalog_id;?>");
                var data = {};
                data['task'] = 'update_name_of_filemanager_folder';
                data['id'] = element_id;
                data['value'] = $('#filemanager_name').val().trim();

                data['section_id'] = parseInt($('select#section_id option:selected').val())

                $.ajax({
                    type: "POST",
                    url: "/cp_ajax_<?php echo $Main->lang;?>/",
                    data: data,
                    dataType: "json",
                    success: function (ajax_data)
                    {
                        if (ajax_data.hasOwnProperty('status') && ajax_data['status'] != "")
                        {
                           // $("#filemanager_status_info").html(ajax_data['status']);

                            if (ajax_data.hasOwnProperty('folder_name_updated') && ajax_data['folder_name_updated'] == 1)
                            {
                                $('#filemanager_original_folder_name_'+element_id).html(ajax_data['value']);
                                if(initial_section_id != data['section_id'])
                                {
                                    $('#filemanager_original_folder_name_'+element_id).closest('.folder_block').remove();
                                }
                                close_popUpGal();
                            }
                            else
                            {
                                $("#filemanager_status_info").html("<?php echo dictionary('ERRORS_IN_URL_ADDRESS');?>");
                            }

                        }
                        else
                        {
                            $("#filemanager_status_info").html("<?php echo dictionary('ERRORS_IN_URL_ADDRESS');?>");
                        }
                    }
                });

            }

            return false;
        });
    </script>
    <?php

}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//remove_folder_of_filemanager
if( isset($ar_post_clean['task'],$ar_post_clean['id']) && $ar_post_clean['task']=='remove_folder_of_filemanager' && $ar_post_clean['id']>0 )
{
    $ajax_data = array();
    $ajax_data['folder_removed'] = 0;
    $db_catalog_table = 'file_manager_catalog';
    $db_catalog_dropzone_table = 'file_manager_dropzone';
    $catalog_id = (int)$ar_post_clean['id'];
    $filemanager_folder_info = $db
        ->where('id', $catalog_id )
        ->getOne($db_catalog_table);
    if($filemanager_folder_info)
    {
        $tree = $Functions->getDirectoryChildren($catalog_id, $db_catalog_table);
        $tree[] = $catalog_id;

        foreach($tree as $tree_catalog_id)
        {
            // remove files from folders
            $get_remove_folder_elements = $db
                ->where('parent_id', $tree_catalog_id)
                ->get($db_catalog_dropzone_table, null, 'id, image');

            foreach($get_remove_folder_elements as $remove_folder_elements)
            {
                $remove_filemanager_element_data_from_db = $db
                    ->where('id', $remove_folder_elements['id'])
                    ->delete($db_catalog_dropzone_table,1);

                $Form->remove_image($db_catalog_dropzone_table, $remove_folder_elements['image']);
            }

            //remove folder
            $remove_filemanager_folder = $db
                ->where('id', $tree_catalog_id)
                ->delete($db_catalog_table,1);
            if($remove_filemanager_folder)
            {
                //remove cpu
                $db->where('page_id', 344); // 344 - id of file_manager_catalog
                $db->where('elem_id', $tree_catalog_id);
                $db->delete('cpu');
            }

            $ajax_data['folder_removed'] = 1;
        }
    }

    echo json_encode($ajax_data);
    exit;
}


// remove_filemanager_folder
if( isset($ar_post_clean['task'],$ar_post_clean['id']) && $ar_post_clean['task']=='remove_filemanager_folder'
    && is_numeric($ar_post_clean['id']) && $ar_post_clean['id'] > 0 )
{
    //controlam daca exista asa fisier in baza de date ( cu asa ID )
    $filemanager_element_info = $db
        ->where('id', (int)$ar_post_clean['id'])
        ->getOne('file_manager_catalog');
    if($filemanager_element_info)
    {
        ?>
        <div class="popUpgltop">
            <div class="close" onclick="close_popUpGal()"></div>
            <div style="clear:both; width: 100%; height: 10px;"></div>
            <div style="color: #8d9ea7; font-size: 14px;text-align: center;"><?php echo dictionary('CONFIRM_DELETE_CATALOG');?></div>

            <form id="check_required_fields" method="post" action="">
                <div style="clear:both; width: 100%;"></div>
                <div id="filemanager_status_info"></div>
                <div style="position:relative; float:left; margin-top:10px; left: 30px;  background: #337ab7; border: none;"  onclick="close_popUpGal()"
                     class="btn btn-success waves-effect waves-light m-r-10"><?php echo dictionary('CANCEL');?>
                </div>
                <button style="position:relative; float:right; margin-top:10px; right: 20px; background: #ff6849; border: none;" type="submit" name="submit"
                        class="btn btn-success waves-effect waves-light m-r-10"><?php echo dictionary('DELETE');?>
                </button>
            </form>
            <div style="clear:both; width: 100%; height: 15px;"></div>
        </div>
        <?php
    }
    else
    {
        ?>
        <div class="popUpgltop">
            <div class="close" onclick="close_popUpGal()"></div>
            <div style="clear:both; width: 100%; height: 5px;"></div>
            <div style="color: #8d9ea7; font-size: 14px;text-align: center;"><?php echo dictionary('ERRORS_IN_URL_ADDRESS');?></div>
            <div style="clear:both; width: 100%; height: 15px;"></div>
        </div>
        <?php
    }


    ?>
    <script>
        $('form#check_required_fields').submit(function()
        {

            $("#filemanager_status_info").html("");

            var element_id = parseInt("<?php echo (int)$ar_post_clean['id'];?>")
            var data = {};
            data['task'] = 'remove_folder_of_filemanager';
            data['id'] = element_id;

            $.ajax({
                type: "POST",
                url: "/cp_ajax_<?php echo $Main->lang;?>/",
                data: data,
                dataType: "json",
                success: function (ajax_data)
                {
                    if (ajax_data.hasOwnProperty('folder_removed') && ajax_data['folder_removed'] == 1)
                    {
                        $('#filemanager_original_folder_name_'+element_id).closest('.folder_block').remove();
                        close_popUpGal();
                    }
                    else
                    {
                        $("#filemanager_status_info").html("<?php echo dictionary('ERRORS_IN_URL_ADDRESS');?>");
                    }

                }
            });

            return false;
        });
    </script>
    <?php

}

// ===================================================================================================================//
//add_element_options_block
if(
    isset($ar_post_clean['task'], $ar_post_clean['block_counter'])
    && $ar_post_clean['task']=='add_element_options_block'
    && is_numeric($ar_post_clean['block_counter']) && $ar_post_clean['block_counter']>=0
)
{
    ?>
    <div class="element_option_block">
        <button style="float: right;" onclick="remove_element_option_block(this,0)" class="delete_button" type="button" title="Delete"></button>
        <?php
        $element_options_counter = 'tempId_'.(int)$ar_post_clean['block_counter'];
        foreach( $list_of_site_langs as $lang_index )
        {
            ?>
            <div class="form-group">
                <label class="col-md-12"><?php echo mb_ucfirst($lang_index);?>
                    <span style="color: red;">*</span>
                </label>
                <div class="col-md-12">
                    <input type="text"
                           name="element_options[<?php echo $element_options_counter;?>][title_<?php echo $lang_index;?>]" value="" class="form-control required" placeholder="">
                </div>
            </div>
            <?php
        }
        ?>
        <div class="form-group">
            <label class="col-md-12">
                <?php echo dictionary('SORT');?>
            </label>
            <div class="col-md-12">
                <input style="width: 70px;" type="number" name="element_options[<?php echo $element_options_counter;?>][sort]" value="0" class="form-control " placeholder="">
            </div>
        </div>
    </div>
    <?php

    exit;
}

//remove_element_options_block
if( isset($ar_post_clean['task'],$ar_post_clean['id'], $ar_post_clean['table'])
    && $ar_post_clean['task']=='remove_element_options_block'
    && $ar_post_clean['id']>0
    && trim($ar_post_clean['table']) != ''
)
{
    $table_add_options = $db->escape($ar_post_clean['table']);
    $ajax_data = array();
    $ajax_data['status_info'] = 0;

    $remove_current_element_parameters = $db
        ->where('id', (int)$ar_post_clean['id'])
        ->delete($table_add_options, 1);

    if($remove_current_element_parameters)
    {
        $ajax_data['status_info'] = 1;
    }

    echo json_encode($ajax_data);
    exit;
}
// ===================================================================================================================//





























































































































// ===========================================================================================================
// TASK SYSTEM FUNCTION. INFINITE LOOP
if( isset($ar_post_clean['task']) && $ar_post_clean['task']=='TASKSYSTEMLOOP' )
{
    $data = array();
    if($User->check_cp_authorization())
    {
        $current_time =  new DateTime();
        $data['clock'] = $current_time->format("H:i:s");
    }
    else
    {
        $data['error'] = "User not authorizated";
    }

    echo json_encode($data);
    exit;
}

// ===========================================================================================================



// ===========================================================================================================
//change_request_form_status
if( isset($ar_post_clean['task'],$ar_post_clean['id'],$ar_post_clean['status']) && $ar_post_clean['task']=='change_request_form_status' && $ar_post_clean['id']>0 )
{
    $ajax_data = "";
    $status = 0;
    if($ar_post_clean['status'] == 0 )
    {
        $status = 1;
    }

    $data = Array (
        'status' => $status
    );

    $db->where ('id', (int)$ar_post_clean['id']);
    if ($db->update ('request_form', $data, 1))
    {
       // $ajax_data = "successfully updated!";
    }

    echo json_encode($ajax_data);
    exit;
}

//==================================================================================================//
//change_element_status
if( isset($ar_post_clean['task'],$ar_post_clean['table'],$ar_post_clean['elem_id'],$ar_post_clean['current_status'])
                            &&
    $ar_post_clean['task']=='change_element_status'
                            &&
    trim($ar_post_clean['table']) != ''
                            &&
    ( $ar_post_clean['current_status'] == 0 || $ar_post_clean['current_status'] == 1 )
   )
{
    $ajax_data = array();
    $ajax_data['status'] = 0;

    $new_element_status = 0;
    if($ar_post_clean['current_status'] == 0)
    {
        $new_element_status = 1;
    }

    $data = Array (
        'active' => $new_element_status
    );

    $element_table = trim($ar_post_clean['table']);
    $update_element_activity = $db
        ->where('id', (int)$ar_post_clean['elem_id'])
        ->update($element_table, $data, 1);
    if ($update_element_activity)
    {
        $ajax_data['status'] = 1;
        $ajax_data['new_element_status'] = $new_element_status;
    }

    echo json_encode($ajax_data);
    exit;

}
//==================================================================================================//