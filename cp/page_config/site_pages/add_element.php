<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/cp/class/include.php';

if($User->check_cp_authorization())
{
    if($User->access_control($developer_access))
    {
        $status_info = array();

        if(isset($_POST['submit']))
        {
            $ar_post_clean = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

            $show_on_left_menu = 0; if(isset($ar_post_clean['show_on_left_menu'])) { $show_on_left_menu = 1; }
            $edit_by_user = 0; if(isset($ar_post_clean['edit_by_user'])) { $edit_by_user = 1; }
            $sort = $db->escape($ar_post_clean['sort']);

            if( isset($ar_post_clean['access']) && count($ar_post_clean['access']) > 0 )
            {
                $access = '1,'.implode(",", $ar_post_clean['access']);
            }
            else
            {
                $access = 1;
            }

            $settings_db_table = "";

            $settings_db_table_dropzone_images = array();
            $settings_db_table_dropzone_images[1] = "";
            $settings_db_table_dropzone_images[2] = "";
            $settings_db_table_dropzone_images[3] = "";

            $settings_PAGE_ID = 0;
            $settings_ADD_ELEMENT_PAGE_ID = 0;
            $settings_EDIT_ELEMENT_PAGE_ID = 0;
            $settings_DELETE_ELEMENT_PAGE_ID = 0;


            if($ar_post_clean['page_type'] == 1)
            {
                // ----------------- Creiem tabele necesare pentru DB --------------------------------------------- //
                $db_table = $db::$prefix.$ar_post_clean['mysql_table_name'];
                $sql_create_table = "CREATE TABLE {$db_table} (
                                                `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                                `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                                `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
                                                `active` tinyint(4) NOT NULL DEFAULT '1',
                                                `title_ru` varchar(255) NOT NULL,
                                                `title_ro` varchar(255) NOT NULL,
                                                `title_en` varchar(255) NOT NULL,
                                                `image` varchar(50) NOT NULL,
                                                `date` datetime NOT NULL,
                                                `link` varchar(250) NOT NULL,
                                                `page_title_ru` varchar(250) NOT NULL,
                                                `page_title_ro` varchar(250) NOT NULL,
                                                `page_title_en` varchar(250) NOT NULL,
                                                `preview_ru` varchar(500) NOT NULL,
                                                `preview_ro` varchar(500) NOT NULL,
                                                `preview_en` varchar(500) NOT NULL,
                                                `text_ru` longtext NOT NULL,
                                                `text_ro` longtext NOT NULL,
                                                `text_en` longtext NOT NULL,
                                                `meta_k_ru` varchar(255) NOT NULL,
                                                `meta_k_ro` varchar(255) NOT NULL,
                                                `meta_k_en` varchar(255) NOT NULL,
                                                `meta_d_ru` varchar(255) NOT NULL,
                                                `meta_d_ro` varchar(255) NOT NULL,
                                                `meta_d_en` varchar(255) NOT NULL,
                                                `sort` int(11) NOT NULL DEFAULT '0'
                                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                                        ";

                $create_table = $db->rawQueryOne($sql_create_table);
                if(!$create_table)
                {
                    $status_info['error'][] = $db->getLastError();
                }

                $settings_db_table = $ar_post_clean['mysql_table_name'];

                if( isset($ar_post_clean['multi_upload_images']) && (int)$ar_post_clean['multi_upload_images'] > 0 )
                {
                    $dropzone_cilce_special_number = (int)$ar_post_clean['multi_upload_images'];
                    if($dropzone_cilce_special_number > 3) {$dropzone_cilce_special_number = 0;}
                    for($dropzone_table_number = 1; $dropzone_table_number <= $dropzone_cilce_special_number; $dropzone_table_number++)
                    {
                        $dropzone_table_name = $ar_post_clean['mysql_table_name'].'_dropzone_'.$dropzone_table_number.'_images';
                        $db_multiple_image_table = $db::$prefix.$dropzone_table_name;
                        $sql_create_multi_upload_images_table = "
                                                                CREATE TABLE  {$db_multiple_image_table} (
                                                                  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                                                  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                                                  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
                                                                  `parent_id` int(11) NOT NULL,
                                                                  `image` varchar(255) NOT NULL,
                                                                  `original_file_name` varchar(255) NOT NULL,
                                                                  `sort` int(11) NOT NULL
                                                                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                                                                ";

                        $create_multi_uplad_table = $db->rawQueryOne($sql_create_multi_upload_images_table);
                        if(!$create_multi_uplad_table)
                        {
                            $status_info['error'][] = $db->getLastError();
                        }

                        $settings_db_table_dropzone_images[$dropzone_table_number] = $dropzone_table_name;

                    }
                }
                // END: ----------------- Creiem tabele necesare pentru DB --------------------------------------------- //


                // Introducem datele necesare pentru lucru corect a tabelelor, in tabelul pages
                //pentru Front
                $data_page = Array (
                    "type" => 1,
                    "page" => '/'.$ar_post_clean['dir_file_name'].'/index.php',
                    "db_table" => $settings_db_table,
                    "dir_file_name" => $ar_post_clean['dir_file_name'],
                    "dropzone_image_table1" => $settings_db_table_dropzone_images[1],
                    "dropzone_image_table2" => $settings_db_table_dropzone_images[2],
                    "dropzone_image_table3" => $settings_db_table_dropzone_images[3],
                    "edit_by_user" => $edit_by_user,
                    "cpu_parrent" => 100
                );

                foreach ($list_of_site_langs as $site_langs)
                {
                    $data_page['title_'.$site_langs] = $db->escape($ar_post_clean['title_'.$site_langs]);
                    $data_page['page_title_'.$site_langs] = $db->escape($ar_post_clean['page_title_'.$site_langs]);
                    $data_page['meta_k_'.$site_langs] = $db->escape($ar_post_clean['meta_k_'.$site_langs]);
                    $data_page['meta_d_'.$site_langs] = $db->escape($ar_post_clean['meta_d_'.$site_langs]);
                    $data_page['text_'.$site_langs] = $db->escape($ar_post_clean['text_'.$site_langs]);
                }

                $insert_data_page_id = $db->insert ('pages', $data_page);
                if($insert_data_page_id)
                {
                    //----------------------------insert CPU front index----------------------------------//
                    if(isset($arrURL)) { unset($arrURL); } $arrURL = array();
                    foreach( $list_of_site_langs as $lang_index )
                    {
                        $arrURL[$lang_index] = $ar_post_clean['cpu_' . $lang_index];
                        if ($arrURL[$lang_index] == '')
                        {
                            $arrURL[$lang_index] = $ar_post_clean['title_' . $lang_index];
                        }
                    }
                    $arrURL = $Cpu->checkCpu($arrURL);
                    if(!($Cpu->updateCpu($arrURL, $insert_data_page_id)))
                    {
                        $status_info['error'][] = dictionary('CPU_ADDING_ERROR').' front index_page';
                    }
                    //----------------------- end insert CPU front index---------------------------------//

                    $data_page_detail = Array(
                        "type" => 1,
                        "page" => '/'.$ar_post_clean['dir_file_name'].'/detail.php',
                        "cpu_parrent" => $insert_data_page_id,
                        "assoc_table" => $ar_post_clean['mysql_table_name']
                    );

                    foreach ($list_of_site_langs as $site_langs)
                    {
                        $cpu_suffix = $Functions->cpu_sufixe_front_detail_page($site_langs, 1);
                        $data_page_detail['title_'.$site_langs] = $db->escape($ar_post_clean['title_'.$site_langs]).$cpu_suffix;
                        $data_page_detail['page_title_'.$site_langs] = $db->escape($ar_post_clean['page_title_'.$site_langs]);
                    }

                    $insert_data_page_detail_id = $db->insert ('pages', $data_page_detail);
                    if($insert_data_page_detail_id)
                    {
                        $settings_PAGE_ID = $insert_data_page_detail_id;
                        //----------------------------insert CPU----------------------------------//
                        if(isset($arrURL)) { unset($arrURL); } $arrURL = array();
                        foreach( $list_of_site_langs as $lang_index )
                        {
                            $cpu_suffix = $Functions->cpu_sufixe_front_detail_page($lang_index);
                            $arrURL[$lang_index] = $ar_post_clean['cpu_' . $lang_index];
                            if ($arrURL[$lang_index] == '')
                            {
                                $arrURL[$lang_index] = $ar_post_clean['title_' . $lang_index].$cpu_suffix;
                            }
                        }
                        $arrURL = $Cpu->checkCpu($arrURL);
                        if(!($Cpu->updateCpu($arrURL, $insert_data_page_detail_id)))
                        {
                            $status_info['error'][] = dictionary('CPU_ADDING_ERROR').$Functions->cpu_sufixe_front_detail_page($lang);
                        }
                        //----------------------- end insert CPU---------------------------------//
                    }
                    else
                    {
                        $status_info['error'][] = $db->getLastError();
                    }
                }
                else
                {
                    $status_info['error'][] = $db->getLastError();
                }

                //pentru CP
                $cp_data_page = Array (
                    "type" => 0,
                    "access" => $access,
                    "page" => '/cp/'.$ar_post_clean['dir_file_name'].'/index.php',
                    "db_table" => $settings_db_table,
                    "dir_file_name" => $ar_post_clean['dir_file_name'],
                    "dropzone_image_table1" => $settings_db_table_dropzone_images[1],
                    "dropzone_image_table2" => $settings_db_table_dropzone_images[2],
                    "dropzone_image_table3" => $settings_db_table_dropzone_images[3],
                    "show_on_left_menu" => $show_on_left_menu,
                    "edit_by_user" => $edit_by_user,
                    "sort" => $sort,
                    "cpu_parrent" => 1
                );

                foreach ($list_of_site_langs as $site_langs)
                {
                    $cp_data_page['title_'.$site_langs] = $db->escape($ar_post_clean['title_'.$site_langs]);
                    $cp_data_page['page_title_'.$site_langs] = $db->escape($ar_post_clean['page_title_'.$site_langs]);
                }

                $insert_cp_data_page_id = $db->insert ('pages', $cp_data_page);
                if($insert_cp_data_page_id)
                {
                    //----------------------------insert CPU----------------------------------//
                    if(isset($arrURL)) { unset($arrURL); } $arrURL = array();
                    foreach( $list_of_site_langs as $lang_index )
                    {
                        $arrURL[$lang_index] = $ar_post_clean['cpu_' . $lang_index];
                        if ($arrURL[$lang_index] == '')
                        {
                            $arrURL[$lang_index] = 'cp-'.$ar_post_clean['title_' . $lang_index];
                        }
                    }
                    $arrURL = $Cpu->checkCpu($arrURL);
                    if(!($Cpu->updateCpu($arrURL, $insert_cp_data_page_id)))
                    {
                        $status_info['error'][] = dictionary('CPU_ADDING_ERROR').' cp index_page';
                    }
                    //----------------------- end insert CPU---------------------------------//


                    // ------------------------ add_element db info ------------------------//
                    $cp_data_page_add_element = Array(
                        "type" => 0,
                        "access" => $access,
                        "page" => '/cp/'.$ar_post_clean['dir_file_name'].'/add_element.php',
                        "cpu_parrent" => $insert_cp_data_page_id
                    );

                    foreach ($list_of_site_langs as $site_langs)
                    {
                        $cpu_suffix = $Functions->cpu_sufixe_cp_add_element($site_langs, 1);
                        $cp_data_page_add_element['title_'.$site_langs] = $db->escape($ar_post_clean['title_'.$site_langs]).$cpu_suffix;
                        $cp_data_page_add_element['page_title_'.$site_langs] = $db->escape($ar_post_clean['page_title_'.$site_langs]);
                    }
                    $insert_cp_data_page_add_element_id = $db->insert ('pages', $cp_data_page_add_element);
                    if($insert_cp_data_page_add_element_id)
                    {
                        $settings_ADD_ELEMENT_PAGE_ID = $insert_cp_data_page_add_element_id;
                        //----------------------------insert CPU----------------------------------//
                        if(isset($arrURL)) { unset($arrURL); } $arrURL = array();
                        foreach( $list_of_site_langs as $lang_index )
                        {
                            $cpu_suffix = $Functions->cpu_sufixe_cp_add_element($lang_index);
                            $arrURL[$lang_index] = $ar_post_clean['cpu_' . $lang_index];
                            if ($arrURL[$lang_index] == '')
                            {
                                $arrURL[$lang_index] = $ar_post_clean['title_' . $lang_index].$cpu_suffix;
                            }
                        }
                        $arrURL = $Cpu->checkCpu($arrURL);
                        if(!($Cpu->updateCpu($arrURL, $insert_cp_data_page_add_element_id)))
                        {
                            $status_info['error'][] = dictionary('CPU_ADDING_ERROR').$Functions->cpu_sufixe_cp_add_element($lang);
                        }
                        //----------------------- end insert CPU---------------------------------//
                    }
                    else
                    {
                        $status_info['error'][] = $db->getLastError();
                    }
                    // ------------------------ end: add_element db info ------------------------//


                    // ------------------------ edit_element db info ------------------------//
                    $cp_data_page_edit_element = Array(
                        "type" => 0,
                        "access" => $access,
                        "page" => '/cp/'.$ar_post_clean['dir_file_name'].'/edit_element.php',
                        "cpu_parrent" => $insert_cp_data_page_id
                    );

                    foreach ($list_of_site_langs as $site_langs)
                    {
                        $cpu_suffix = $Functions->cpu_sufixe_cp_edit_element($site_langs, 1);
                        $cp_data_page_edit_element['title_'.$site_langs] = $db->escape($ar_post_clean['title_'.$site_langs]).$cpu_suffix;
                        $cp_data_page_edit_element['page_title_'.$site_langs] = $db->escape($ar_post_clean['page_title_'.$site_langs]);
                    }
                    $insert_cp_data_page_edit_element_id = $db->insert ('pages', $cp_data_page_edit_element);
                    if($insert_cp_data_page_edit_element_id)
                    {
                        $settings_EDIT_ELEMENT_PAGE_ID = $insert_cp_data_page_edit_element_id;
                        //----------------------------insert CPU----------------------------------//
                        if(isset($arrURL)) { unset($arrURL); } $arrURL = array();
                        foreach( $list_of_site_langs as $lang_index )
                        {
                            $cpu_suffix = $Functions->cpu_sufixe_cp_edit_element($lang_index);
                            $arrURL[$lang_index] = $ar_post_clean['cpu_' . $lang_index];
                            if ($arrURL[$lang_index] == '')
                            {
                                $arrURL[$lang_index] = $ar_post_clean['title_' . $lang_index].$cpu_suffix;
                            }
                        }
                        $arrURL = $Cpu->checkCpu($arrURL);
                        if(!($Cpu->updateCpu($arrURL, $insert_cp_data_page_edit_element_id)))
                        {
                            $status_info['error'][] = dictionary('CPU_ADDING_ERROR').$Functions->cpu_sufixe_cp_edit_element($lang);
                        }
                        //----------------------- end insert CPU---------------------------------//
                    }
                    else
                    {
                        $status_info['error'][] = $db->getLastError();
                    }
                    // ------------------------ end: edit_element db info ------------------------//


                    // ------------------------ delete_element db info ------------------------//
                    $cp_data_page_delete_element = Array(
                        "type" => 0,
                        "access" => $access,
                        "page" => '/cp/'.$ar_post_clean['dir_file_name'].'/delete_element.php',
                        "cpu_parrent" => $insert_cp_data_page_id
                    );

                    foreach ($list_of_site_langs as $site_langs)
                    {
                        $cpu_suffix = $Functions->cpu_sufixe_cp_delete_element($site_langs, 1);
                        $cp_data_page_delete_element['title_'.$site_langs] = $db->escape($ar_post_clean['title_'.$site_langs]).$cpu_suffix;
                        $cp_data_page_delete_element['page_title_'.$site_langs] = $db->escape($ar_post_clean['page_title_'.$site_langs]);
                    }
                    $insert_cp_data_page_delete_element_id = $db->insert ('pages', $cp_data_page_delete_element);
                    if($insert_cp_data_page_delete_element_id)
                    {
                        $settings_DELETE_ELEMENT_PAGE_ID = $insert_cp_data_page_delete_element_id;
                        //----------------------------insert CPU----------------------------------//
                        if(isset($arrURL)) { unset($arrURL); } $arrURL = array();
                        foreach( $list_of_site_langs as $lang_index )
                        {
                            $cpu_suffix = $Functions->cpu_sufixe_cp_delete_element($lang_index);
                            $arrURL[$lang_index] = $ar_post_clean['cpu_' . $lang_index];
                            if ($arrURL[$lang_index] == '')
                            {
                                $arrURL[$lang_index] = $ar_post_clean['title_' . $lang_index].$cpu_suffix;
                            }
                        }
                        $arrURL = $Cpu->checkCpu($arrURL);
                        if(!($Cpu->updateCpu($arrURL, $insert_cp_data_page_delete_element_id)))
                        {
                            $status_info['error'][] = dictionary('CPU_ADDING_ERROR').$Functions->cpu_sufixe_cp_delete_element($lang);
                        }
                        //----------------------- end insert CPU---------------------------------//
                    }
                    else
                    {
                        $status_info['error'][] = $db->getLastError();
                    }
                    // ------------------------ end: delete_element db info ------------------------//
                }
                else
                {
                    $status_info['error'][] = $db->getLastError();
                }


                // ------------- CREIEM DIRECTORIILE NECESARE PENTRU FRONT SI CP ------------- //
                $dir_name = $ar_post_clean['dir_file_name'];
                //Pentru Front
                $check_dir_result = is_dir($_SERVER['DOCUMENT_ROOT'].'/' . $dir_name );
                if( isset($ar_post_clean['multi_upload_images']) && (int)$ar_post_clean['multi_upload_images'] > 0 )
                {
                    if(!$check_dir_result)
                    {
                        $Functions->recurse_copy($_SERVER['DOCUMENT_ROOT'].'/cp/php/templates/generated_directory/front/two_level_catalog_multi_upload_images', $_SERVER['DOCUMENT_ROOT'].'/'.$dir_name);
                    }
                }
                else
                {
                    if(!$check_dir_result)
                    {
                        $Functions->recurse_copy($_SERVER['DOCUMENT_ROOT'].'/cp/php/templates/generated_directory/front/two_level_catalog', $_SERVER['DOCUMENT_ROOT'].'/'.$dir_name);
                    }
                }

                //Pentru CP
                $check_cp_dir_result = is_dir($_SERVER['DOCUMENT_ROOT'].'/cp/'. $dir_name );
                if( isset($ar_post_clean['multi_upload_images']) && (int)$ar_post_clean['multi_upload_images'] > 0 )
                {
                    if(!$check_cp_dir_result)
                    {
                        $Functions->recurse_copy($_SERVER['DOCUMENT_ROOT'].'/cp/php/templates/generated_directory/cp/two_level_catalog_multi_upload_images', $_SERVER['DOCUMENT_ROOT'].'/cp/'.$dir_name);
                    }
                }
                else
                {
                    if(!$check_cp_dir_result)
                    {
                        $Functions->recurse_copy($_SERVER['DOCUMENT_ROOT'].'/cp/php/templates/generated_directory/cp/two_level_catalog', $_SERVER['DOCUMENT_ROOT'].'/cp/'.$dir_name);
                    }
                }
                // -------------END: CREIEM DIRECTORIILE NECESARE PENTRU FRONT SI CP ------------- //

                // ----------------- Inscriem informatia pentru fisierul settings.php ----------------- //
                $setting_file = $_SERVER['DOCUMENT_ROOT'].'/cp/'.$dir_name.'/settings.php';
                $setting_file_content = "<?php \n";
                $setting_file_content .= '$db_table = "'.$settings_db_table.'";'."\n";
                $setting_file_content .= '$db_table_dropzone1_images = "'.$settings_db_table_dropzone_images[1].'";'."\n";
                $setting_file_content .= '$db_table_dropzone2_images = "'.$settings_db_table_dropzone_images[2].'";'."\n";
                $setting_file_content .= '$db_table_dropzone3_images = "'.$settings_db_table_dropzone_images[3].'";'."\n";
                $setting_file_content .= '$PAGE_ID = '.$settings_PAGE_ID.'; // - id of front page "/'.$settings_db_table.'/detail.php"'."\n";

                $setting_file_content .= '$ADD_ELEMENT_PAGE_ID = '.$settings_ADD_ELEMENT_PAGE_ID.'; // - id of add page "/cp/'.$settings_db_table.'/add_element.php"'."\n";
                $setting_file_content .= '$EDIT_ELEMENT_PAGE_ID = '.$settings_EDIT_ELEMENT_PAGE_ID.'; // - id of edit page "/cp/'.$settings_db_table.'/edit_element.php"'."\n";
                $setting_file_content .= '$DELETE_ELEMENT_PAGE_ID = '.$settings_DELETE_ELEMENT_PAGE_ID.'; // - id of delete page "/cp/'.$settings_db_table.'/delete_element.php"'."\n";

                $setting_file_content .= "\n";
                $setting_file_content .= '$num_page = 25; // PAGINAREA. Cite elemente vor fi afisate pe o pagina'."\n";

                $setting_file = fopen($setting_file, 'w');
                fwrite($setting_file, $setting_file_content);
                fclose($setting_file);
                //END: ----------------- Inscriem informatia pentru fisierul settings.php ----------------- //

                $status_info['success'][] = dictionary('SUCCESSFULLY_ADDED');
            }

            else

            if($ar_post_clean['page_type'] == 0)
            {
                // Introducem datele necesare pentru lucru corect a tabelelor, in tabelul pages
                //pentru Front
                $file_path_name = '/text_page/'.$ar_post_clean['dir_file_name'].'.php';
                $data_page = Array (
                    "type" => 7, // simple front page
                    "access" => $access,
                    "show_on_left_menu" => $show_on_left_menu,
                    "page" => $file_path_name,
                    "dir_file_name" => $ar_post_clean['dir_file_name'],
                    "edit_by_user" => $edit_by_user,
                    "sort" => $sort,
                    "cpu_parrent" => 100
                );

                foreach ($list_of_site_langs as $site_langs)
                {
                    $data_page['title_'.$site_langs] = $db->escape($ar_post_clean['title_'.$site_langs]);
                    $data_page['page_title_'.$site_langs] = $db->escape($ar_post_clean['page_title_'.$site_langs]);
                    $data_page['meta_k_'.$site_langs] = $db->escape($ar_post_clean['meta_k_'.$site_langs]);
                    $data_page['meta_d_'.$site_langs] = $db->escape($ar_post_clean['meta_d_'.$site_langs]);
                    $data_page['text_'.$site_langs] = $db->escape($ar_post_clean['text_'.$site_langs]);
                }

                $insert_data_page_id = $db->insert ('pages', $data_page);
                if($insert_data_page_id)
                {
                    //----------------------------insert CPU front index----------------------------------//
                    if(isset($arrURL)) { unset($arrURL); } $arrURL = array();
                    foreach( $list_of_site_langs as $lang_index )
                    {
                        $arrURL[$lang_index] = $ar_post_clean['cpu_' . $lang_index];
                        if ($arrURL[$lang_index] == '')
                        {
                            $arrURL[$lang_index] = $ar_post_clean['title_' . $lang_index];
                        }
                    }
                    $arrURL = $Cpu->checkCpu($arrURL);
                    if(!($Cpu->updateCpu($arrURL, $insert_data_page_id)))
                    {
                        $status_info['error'][] = dictionary('CPU_ADDING_ERROR');
                    }
                    //----------------------- end insert CPU front index---------------------------------//

                    // ------------- CREIEM DIRECTORIILE NECESARE PENTRU FRONT  ------------- //
                    $check_dir_result = is_dir($_SERVER['DOCUMENT_ROOT'].'/text_page' );
                    if ($check_dir_result)
                    {
                        if(is_file($_SERVER['DOCUMENT_ROOT'].$file_path_name))
                        {
                            $status_info['error'][] = dictionary("FILE_ALREADY_EXIST");
                        }
                        else
                        {
                            copy($_SERVER['DOCUMENT_ROOT'].'/cp/php/templates/generated_directory/front/text_page/index.php', $_SERVER['DOCUMENT_ROOT'].$file_path_name);
                        }

                    }
                    else
                    {
                        if (mkdir( $_SERVER['DOCUMENT_ROOT'].'/text_page' ))
                        {
                            copy($_SERVER['DOCUMENT_ROOT'].'/cp/php/templates/generated_directory/front/text_page/index.php', $_SERVER['DOCUMENT_ROOT'].$file_path_name);
                        }
                        else
                        {
                            $status_info['error'][] = dictionary('ERROR_MKDIR');
                        }
                    }
                    //END: ------------- CREIEM DIRECTORIILE NECESARE PENTRU FRONT  ------------- //
                }
                else
                {
                    $status_info['error'][] = $db->getLastError();
                }
                $status_info['success'][] = dictionary('SUCCESSFULLY_ADDED');
            }

            else

            if($ar_post_clean['page_type'] == 2)
            {
                $cpu_parrent = $db->escape($ar_post_clean['cp_page_parent_section']);
                // Introducem datele necesare pentru lucru corect a tabelelor, in tabelul pages
                $file_path_name = '/cp/simple_page/'.$ar_post_clean['dir_file_name'].'.php';
                $data_page = Array (
                    "type" => 10, // 10 - simple cp page
                    "access" => $access,
                    "show_on_left_menu" => $show_on_left_menu,
                    "page" => $file_path_name,
                    "dir_file_name" => $ar_post_clean['dir_file_name'],
                    "edit_by_user" => $edit_by_user,
                    "sort" => $sort,
                    "cpu_parrent" => (int)$cpu_parrent
                );

                foreach ($list_of_site_langs as $site_langs)
                {
                    $data_page['title_'.$site_langs] = $db->escape($ar_post_clean['title_'.$site_langs]);
                    $data_page['page_title_'.$site_langs] = $db->escape($ar_post_clean['page_title_'.$site_langs]);
                    $data_page['meta_k_'.$site_langs] = $db->escape($ar_post_clean['meta_k_'.$site_langs]);
                    $data_page['meta_d_'.$site_langs] = $db->escape($ar_post_clean['meta_d_'.$site_langs]);
                    $data_page['text_'.$site_langs] = $db->escape($ar_post_clean['text_'.$site_langs]);
                }

                $insert_data_page_id = $db->insert ('pages', $data_page);
                if($insert_data_page_id)
                {
                    //----------------------------insert CPU for simple cp pages----------------------------------//
                    if(isset($arrURL)) { unset($arrURL); } $arrURL = array();
                    foreach( $list_of_site_langs as $lang_index )
                    {
                        $arrURL[$lang_index] = $ar_post_clean['cpu_' . $lang_index];
                        if ($arrURL[$lang_index] == '')
                        {
                            $arrURL[$lang_index] = $ar_post_clean['title_' . $lang_index];
                        }
                    }
                    $arrURL = $Cpu->checkCpu($arrURL);
                    if(!($Cpu->updateCpu($arrURL, $insert_data_page_id)))
                    {
                        $status_info['error'][] = dictionary('CPU_ADDING_ERROR');
                    }
                    //----------------------- end insert CPU for simple cp pages---------------------------------//

                    // ------------- CREIEM DIRECTORIILE NECESARE PENTRU FRONT  ------------- //
                    $check_dir_result = is_dir($_SERVER['DOCUMENT_ROOT'].'/cp/simple_page' );
                    if ($check_dir_result)
                    {
                        if(is_file($_SERVER['DOCUMENT_ROOT'].$file_path_name))
                        {
                            $status_info['error'][] = dictionary("FILE_ALREADY_EXIST");
                        }
                        else
                        {
                            copy($_SERVER['DOCUMENT_ROOT'].'/cp/php/templates/generated_directory/cp/simple_page/index.php', $_SERVER['DOCUMENT_ROOT'].$file_path_name);
                        }

                    }
                    else
                    {
                        if (mkdir( $_SERVER['DOCUMENT_ROOT'].'/cp/simple_page' ))
                        {
                            copy($_SERVER['DOCUMENT_ROOT'].'/cp/php/templates/generated_directory/cp/simple_page/index.php', $_SERVER['DOCUMENT_ROOT'].$file_path_name);
                        }
                        else
                        {
                            $status_info['error'][] = dictionary('ERROR_MKDIR');
                        }
                    }
                    //END: ------------- CREIEM DIRECTORIILE NECESARE PENTRU FRONT  ------------- //
                }
                else
                {
                    $status_info['error'][] = $db->getLastError();
                }
                $status_info['success'][] = dictionary('SUCCESSFULLY_ADDED');
            }

            else

            if($ar_post_clean['page_type'] == 3)
            {
                // ----------------- Creiem tabele necesare pentru DB --------------------------------------------- //
                $db_table = $db::$prefix.$ar_post_clean['mysql_table_name'];
                $sql_create_table = "CREATE TABLE {$db_table} (
                                            `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                            `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
                                            `active` tinyint(4) NOT NULL DEFAULT '1',
                                            `title_ru` varchar(255) NOT NULL,
                                            `title_ro` varchar(255) NOT NULL,
                                            `title_en` varchar(255) NOT NULL,
                                            `image` varchar(50) NOT NULL,
                                            `date` datetime NOT NULL,
                                            `link` varchar(250) NOT NULL,
                                            `page_title_ru` varchar(250) NOT NULL,
                                            `page_title_ro` varchar(250) NOT NULL,
                                            `page_title_en` varchar(250) NOT NULL,
                                            `preview_ru` varchar(500) NOT NULL,
                                            `preview_ro` varchar(500) NOT NULL,
                                            `preview_en` varchar(500) NOT NULL,
                                            `text_ru` longtext NOT NULL,
                                            `text_ro` longtext NOT NULL,
                                            `text_en` longtext NOT NULL,
                                            `meta_k_ru` varchar(255) NOT NULL,
                                            `meta_k_ro` varchar(255) NOT NULL,
                                            `meta_k_en` varchar(255) NOT NULL,
                                            `meta_d_ru` varchar(255) NOT NULL,
                                            `meta_d_ro` varchar(255) NOT NULL,
                                            `meta_d_en` varchar(255) NOT NULL,
                                            `sort` int(11) NOT NULL DEFAULT '0'
                                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                                    ";

                $create_table = $db->rawQueryOne($sql_create_table);
                if(!$create_table)
                {
                    $status_info['error'][] = $db->getLastError();
                }

                $settings_db_table = $ar_post_clean['mysql_table_name'];

                if( isset($ar_post_clean['multi_upload_images']) && (int)$ar_post_clean['multi_upload_images'] > 0 )
                {
                    $dropzone_cilce_special_number = (int)$ar_post_clean['multi_upload_images'];
                    if($dropzone_cilce_special_number > 3) {$dropzone_cilce_special_number = 0;}
                    for($dropzone_table_number = 1; $dropzone_table_number <= $dropzone_cilce_special_number; $dropzone_table_number++)
                    {
                        $dropzone_table_name = $ar_post_clean['mysql_table_name'].'_dropzone_'.$dropzone_table_number.'_images';
                        $db_multiple_image_table = $db::$prefix.$dropzone_table_name;
                        $sql_create_multi_upload_images_table = "
                                                            CREATE TABLE  {$db_multiple_image_table} (
                                                              `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                                              `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                                              `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
                                                              `parent_id` int(11) NOT NULL,
                                                              `image` varchar(255) NOT NULL,
                                                              `original_file_name` varchar(255) NOT NULL,
                                                              `sort` int(11) NOT NULL
                                                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                                                            ";

                        $create_multi_uplad_table = $db->rawQueryOne($sql_create_multi_upload_images_table);
                        if(!$create_multi_uplad_table)
                        {
                            $status_info['error'][] = $db->getLastError();
                        }

                        $settings_db_table_dropzone_images[$dropzone_table_number] = $dropzone_table_name;

                    }
                }
                // END: ----------------- Creiem tabele necesare pentru DB --------------------------------------------- //


                //pentru CP
                $cp_data_page = Array (
                    "type" => 0,
                    "access" => $access,
                    "page" => '/cp/'.$ar_post_clean['dir_file_name'].'/index.php',
                    "db_table" => $settings_db_table,
                    "dir_file_name" => $ar_post_clean['dir_file_name'],
                    "dropzone_image_table1" => $settings_db_table_dropzone_images[1],
                    "dropzone_image_table2" => $settings_db_table_dropzone_images[2],
                    "dropzone_image_table3" => $settings_db_table_dropzone_images[3],
                    "show_on_left_menu" => $show_on_left_menu,
                    "edit_by_user" => $edit_by_user,
                    "sort" => $sort,
                    "cpu_parrent" => 1
                );

                foreach ($list_of_site_langs as $site_langs)
                {
                    $cp_data_page['title_'.$site_langs] = $db->escape($ar_post_clean['title_'.$site_langs]);
                    $cp_data_page['page_title_'.$site_langs] = $db->escape($ar_post_clean['page_title_'.$site_langs]);
                }

                $insert_cp_data_page_id = $db->insert ('pages', $cp_data_page);
                if($insert_cp_data_page_id)
                {
                    //----------------------------insert CPU----------------------------------//
                    if(isset($arrURL)) { unset($arrURL); } $arrURL = array();
                    foreach( $list_of_site_langs as $lang_index )
                    {
                        $arrURL[$lang_index] = $ar_post_clean['cpu_' . $lang_index];
                        if ($arrURL[$lang_index] == '')
                        {
                            $arrURL[$lang_index] = $ar_post_clean['title_' . $lang_index];
                        }
                    }
                    $arrURL = $Cpu->checkCpu($arrURL);
                    if(!($Cpu->updateCpu($arrURL, $insert_cp_data_page_id)))
                    {
                        $status_info['error'][] = dictionary('CPU_ADDING_ERROR').' cp index_page';
                    }
                    //----------------------- end insert CPU---------------------------------//




                    // ------------------------ add_element db info ------------------------//
                    $cp_data_page_add_element = Array(
                        "type" => 0,
                        "access" => $access,
                        "page" => '/cp/'.$ar_post_clean['dir_file_name'].'/add_element.php',
                        "cpu_parrent" => $insert_cp_data_page_id
                    );

                    foreach ($list_of_site_langs as $site_langs)
                    {
                        $cpu_suffix = $Functions->cpu_sufixe_cp_add_element($site_langs, 1);
                        $cp_data_page_add_element['title_'.$site_langs] = $db->escape($ar_post_clean['title_'.$site_langs]).$cpu_suffix;
                        $cp_data_page_add_element['page_title_'.$site_langs] = $db->escape($ar_post_clean['page_title_'.$site_langs]);
                    }
                    $insert_cp_data_page_add_element_id = $db->insert ('pages', $cp_data_page_add_element);
                    if($insert_cp_data_page_add_element_id)
                    {
                        $settings_ADD_ELEMENT_PAGE_ID = $insert_cp_data_page_add_element_id;
                        //----------------------------insert CPU----------------------------------//
                        if(isset($arrURL)) { unset($arrURL); } $arrURL = array();
                        foreach( $list_of_site_langs as $lang_index )
                        {
                            $cpu_suffix = $Functions->cpu_sufixe_cp_add_element($lang_index);
                            $arrURL[$lang_index] = $ar_post_clean['cpu_' . $lang_index];
                            if ($arrURL[$lang_index] == '')
                            {
                                $arrURL[$lang_index] = $db->escape($ar_post_clean['title_'.$lang_index]).$cpu_suffix;
                            }
                        }

                        $arrURL = $Cpu->checkCpu($arrURL);
                        if(!($Cpu->updateCpu($arrURL, $insert_cp_data_page_add_element_id)))
                        {
                            $status_info['error'][] = dictionary('CPU_ADDING_ERROR').$Functions->cpu_sufixe_cp_add_element($lang);
                        }
                        //----------------------- end insert CPU---------------------------------//
                    }
                    else
                    {
                        $status_info['error'][] = $db->getLastError();
                    }
                    // ------------------------ end: add_element db info ------------------------//


                    // ------------------------ edit_element db info ------------------------//
                    $cp_data_page_edit_element = Array(
                        "type" => 0,
                        "access" => $access,
                        "page" => '/cp/'.$ar_post_clean['dir_file_name'].'/edit_element.php',
                        "cpu_parrent" => $insert_cp_data_page_id
                    );

                    foreach ($list_of_site_langs as $site_langs)
                    {
                        $cpu_suffix = $Functions->cpu_sufixe_cp_edit_element($site_langs, 1);
                        $cp_data_page_edit_element['title_'.$site_langs] = $db->escape($ar_post_clean['title_'.$site_langs]).$cpu_suffix;
                        $cp_data_page_edit_element['page_title_'.$site_langs] = $db->escape($ar_post_clean['page_title_'.$site_langs]);
                    }
                    $insert_cp_data_page_edit_element_id = $db->insert ('pages', $cp_data_page_edit_element);
                    if($insert_cp_data_page_edit_element_id)
                    {
                        $settings_EDIT_ELEMENT_PAGE_ID = $insert_cp_data_page_edit_element_id;
                        //----------------------------insert CPU----------------------------------//
                        if(isset($arrURL)) { unset($arrURL); } $arrURL = array();
                        foreach( $list_of_site_langs as $lang_index )
                        {
                            $cpu_suffix = $Functions->cpu_sufixe_cp_edit_element($lang_index);
                            $arrURL[$lang_index] = $ar_post_clean['cpu_' . $lang_index];
                            if ($arrURL[$lang_index] == '')
                            {
                                $arrURL[$lang_index] = $db->escape($ar_post_clean['title_'.$lang_index]).$cpu_suffix;
                            }
                        }
                        $arrURL = $Cpu->checkCpu($arrURL);
                        if(!($Cpu->updateCpu($arrURL, $insert_cp_data_page_edit_element_id)))
                        {
                            $status_info['error'][] = dictionary('CPU_ADDING_ERROR').$Functions->cpu_sufixe_cp_edit_element($lang);
                        }
                        //----------------------- end insert CPU---------------------------------//
                    }
                    else
                    {
                        $status_info['error'][] = $db->getLastError();
                    }
                    // ------------------------ end: edit_element db info ------------------------//


                    // ------------------------ delete_element db info ------------------------//
                    $cp_data_page_delete_element = Array(
                        "type" => 0,
                        "access" => $access,
                        "page" => '/cp/'.$ar_post_clean['dir_file_name'].'/delete_element.php',
                        "cpu_parrent" => $insert_cp_data_page_id
                    );

                    foreach ($list_of_site_langs as $site_langs)
                    {
                        $cpu_suffix = $Functions->cpu_sufixe_cp_delete_element($site_langs, 1);
                        $cp_data_page_delete_element['title_'.$site_langs] = $db->escape($ar_post_clean['title_'.$site_langs]).$cpu_suffix;
                        $cp_data_page_delete_element['page_title_'.$site_langs] = $db->escape($ar_post_clean['page_title_'.$site_langs]);
                    }
                    $insert_cp_data_page_delete_element_id = $db->insert ('pages', $cp_data_page_delete_element);
                    if($insert_cp_data_page_delete_element_id)
                    {
                        $settings_DELETE_ELEMENT_PAGE_ID = $insert_cp_data_page_delete_element_id;
                        //----------------------------insert CPU----------------------------------//
                        if(isset($arrURL)) { unset($arrURL); } $arrURL = array();
                        foreach( $list_of_site_langs as $lang_index )
                        {
                            $cpu_suffix = $Functions->cpu_sufixe_cp_delete_element($lang_index);
                            $arrURL[$lang_index] = $ar_post_clean['cpu_' . $lang_index];
                            if ($arrURL[$lang_index] == '')
                            {
                                $arrURL[$lang_index] = $db->escape($ar_post_clean['title_'.$lang_index]).$cpu_suffix;
                            }
                        }
                        $arrURL = $Cpu->checkCpu($arrURL);
                        if(!($Cpu->updateCpu($arrURL, $insert_cp_data_page_delete_element_id)))
                        {
                            $status_info['error'][] = dictionary('CPU_ADDING_ERROR').$Functions->cpu_sufixe_cp_delete_element($lang);
                        }
                        //----------------------- end insert CPU---------------------------------//
                    }
                    else
                    {
                        $status_info['error'][] = $db->getLastError();
                    }
                    // ------------------------ end: delete_element db info ------------------------//
                }
                else
                {
                    $status_info['error'][] = $db->getLastError();
                }


                // ------------- CREIEM DIRECTORIILE NECESARE PENTRU CP ------------- //
                $dir_name = $ar_post_clean['dir_file_name'];
                //Pentru CP
                $check_cp_dir_result = is_dir($_SERVER['DOCUMENT_ROOT'].'/cp/'. $dir_name );
                if( isset($ar_post_clean['multi_upload_images']) && (int)$ar_post_clean['multi_upload_images'] > 0 )
                {
                    if(!$check_cp_dir_result)
                    {
                        $Functions->recurse_copy($_SERVER['DOCUMENT_ROOT'].'/cp/php/templates/generated_directory/cp/two_level_catalog_multi_upload_images_only_for_cp', $_SERVER['DOCUMENT_ROOT'].'/cp/'.$dir_name);
                    }
                }
                else
                {
                    if(!$check_cp_dir_result)
                    {
                        $Functions->recurse_copy($_SERVER['DOCUMENT_ROOT'].'/cp/php/templates/generated_directory/cp/two_level_catalog_only_for_cp', $_SERVER['DOCUMENT_ROOT'].'/cp/'.$dir_name);
                    }
                }
                // -------------END: CREIEM DIRECTORIILE NECESARE PENTRU FRONT SI CP ------------- //

                // ----------------- Inscriem informatia pentru fisierul settings.php ----------------- //
                $setting_file = $_SERVER['DOCUMENT_ROOT'].'/cp/'.$dir_name.'/settings.php';
                $setting_file_content = "<?php \n";
                $setting_file_content .= '$db_table = "'.$settings_db_table.'";'."\n";
                $setting_file_content .= '$db_table_dropzone1_images = "'.$settings_db_table_dropzone_images[1].'";'."\n";
                $setting_file_content .= '$db_table_dropzone2_images = "'.$settings_db_table_dropzone_images[2].'";'."\n";
                $setting_file_content .= '$db_table_dropzone3_images = "'.$settings_db_table_dropzone_images[3].'";'."\n";


                $setting_file_content .= '$ADD_ELEMENT_PAGE_ID = '.$settings_ADD_ELEMENT_PAGE_ID.'; // - id of add page "/cp/'.$settings_db_table.'/add_element.php"'."\n";
                $setting_file_content .= '$EDIT_ELEMENT_PAGE_ID = '.$settings_EDIT_ELEMENT_PAGE_ID.'; // - id of edit page "/cp/'.$settings_db_table.'/edit_element.php"'."\n";
                $setting_file_content .= '$DELETE_ELEMENT_PAGE_ID = '.$settings_DELETE_ELEMENT_PAGE_ID.'; // - id of delete page "/cp/'.$settings_db_table.'/delete_element.php"'."\n";

                $setting_file_content .= "\n";
                $setting_file_content .= '$num_page = 25; // PAGINAREA. Cite elemente vor fi afisate pe o pagina'."\n";

                $setting_file = fopen($setting_file, 'w');
                fwrite($setting_file, $setting_file_content);
                fclose($setting_file);
                //END: ----------------- Inscriem informatia pentru fisierul settings.php ----------------- //

                $status_info['success'][] = dictionary('SUCCESSFULLY_ADDED');
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
                            <h3 class="page-title"><?php echo dictionary('ADD');?></h3>
                            <?php
                            show_status_info($status_info);
                            ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <form id="check_required_fields" class="form-material form-horizontal" method="post" action="">
                                        <div id="item_description">
                                            <ul class="tabs tabs1">
                                                <li class="t1 tab-current"><a>Общие данные</a></li>
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
                                                    <label class="col-md-12"><?php echo dictionary('TYPE');?> <span style="color: red;">*</span></label>
                                                    <div class="col-md-12">
                                                        <select class="form-control" name="page_type" id="page_type">
                                                            <option selected value="0"><?php echo dictionary('SIMPLE_PAGE');?></option>
                                                            <option value="2"><?php echo dictionary('SIMPLE_PAGE_FOR_CP');?></option>
                                                            <option value="1"><?php echo dictionary('TWO_LEVEL_CATALOG');?></option>
                                                            <option value="3"><?php echo dictionary('TWO_LEVEL_CATALOG_ONLY_FOR_CP');?></option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-12"><?php echo dictionary('CATALOG_FILE');?>
                                                        <span class="red_star">*</span></label>
                                                    <div class="col-md-12">
                                                        <input type="text" name="dir_file_name" value="" id="page_or_cat_name"
                                                               class="form-control alphaonly required" placeholder="">
                                                    </div>
                                                </div>

                                                <div class="form-group" style="display:none;">
                                                    <label class="col-md-12"><?php echo dictionary('MYSQL_TABLE_NAME');?>
                                                        <span class="red_star">*</span></label>
                                                    <div class="col-md-12">
                                                        <input  type="text" name="mysql_table_name" value="" id="mysql_table_name"
                                                                class="form-control alphaonly" placeholder="">
                                                    </div>
                                                </div>

                                                <div class="form-group" style="display:none; margin-top: 5px;">
                                                    <label class="col-md-12"><?php echo dictionary('SPECIFY_TARENT_SECTION');?>
                                                    <div class="col-md-12">
                                                        <select class="form-control" name="cp_page_parent_section" id="cp_page_parent_section">
                                                            <option selected value="1">---</option>
                                                            <?php
                                                            $get_page_parents = $db
                                                                ->where('type', 0)
                                                                ->orWhere('type', 10)
                                                                ->orderBy('title_'.$lang, 'asc')
                                                                ->get('pages');
                                                            if(count($get_page_parents) > 0 )
                                                            {
                                                                foreach ($get_page_parents as $page_parents)
                                                                {
                                                                    ?>
                                                                    <option value="<?php echo $page_parents['id'];?>">
                                                                        <?php echo $page_parents['title_'.$lang];?>
                                                                    </option>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group" style="display:none;">
                                                    <label class="col-md-12"><?php echo dictionary('MULTI_UPLOAD_IMAGES');?></label>
                                                    <div class="col-md-12">
                                                        <select class="form-control" name="multi_upload_images" id="multi_upload_images">
                                                            <option selected value="0">0</option>
                                                            <option value="1">1</option>
                                                            <option value="2">2</option>
                                                            <option value="3">3</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-12"><?php echo dictionary('EDIT_BY_USER');?></label>
                                                    <div class="col-md-12">
                                                        <input type="checkbox" name="edit_by_user" checked="checked"
                                                               class="form-control" placeholder="" style="float: left; width: 50px;">
                                                    </div>
                                                </div>

                                                <hr />

                                                <div class="form-group">
                                                    <label class="col-md-12"><?php echo dictionary('ACCESSIBILITY');?></label>
                                                    <div class="col-md-12">
                                                        <?php
                                                        $get_access_type_info = $db
                                                            ->get("user_group");
                                                        if($get_access_type_info && count($get_access_type_info) > 0 )
                                                        {
                                                            foreach($get_access_type_info as $access_type_info)
                                                            {
                                                                if($access_type_info['id'] != 1)
                                                                {
                                                                    ?>
                                                                    <div style="float: left;margin-right: 100px;">
                                                                        <label><?php echo $access_type_info['title_'.$Main->lang];?></label>
                                                                        <div class="clear"></div>
                                                                        <input type="checkbox" name="access[]" checked="checked" value="<?php echo $access_type_info['id'];?>"
                                                                               class="form-control" placeholder="" style="float: left; width: 50px;">
                                                                    </div>
                                                                    <?php
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>

                                                <hr />

                                                <div class="form-group">
                                                    <label class="col-md-12"><?php echo dictionary('SHOW_ON_LEFT_MENU');?></label>
                                                    <div class="col-md-12">
                                                        <input type="checkbox" name="show_on_left_menu" checked="checked"
                                                               class="form-control" placeholder="" style="float: left; width: 50px;">
                                                    </div>
                                                </div>

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

                                                    <div class="form-group">
                                                        <label class="col-md-12"><?php echo dictionary('PAGE_TITLE');?></label>
                                                        <div class="col-md-12">
                                                            <input type="text" name="page_title_<?php echo $lang_index?>" value=""
                                                                   class="form-control" placeholder="">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-md-12"><?php echo dictionary('CPU');?></label>
                                                        <div class="col-md-12">
                                                            <input type="text" name="cpu_<?php echo $lang_index?>" value=""
                                                                   class="form-control" placeholder="">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-md-12"><?php echo dictionary('SEO_META_KEY');?></label>
                                                        <div class="col-md-12">
                                                            <input type="text" name="meta_k_<?php echo $lang_index?>" value=""
                                                                   class="form-control" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-12"><?php echo dictionary('SEO_META_DESCRIPTION');?></label>
                                                        <div class="col-md-12">
                                                            <input type="text" name="meta_d_<?php echo $lang_index?>" value=""
                                                                   class="form-control" placeholder="">
                                                        </div>
                                                    </div>

                                                    <?php
                                                        $Form->add_description('text_'.$lang_index);
                                                    ?>

                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <button style="float:right;" type="submit" name="submit"
                                                class="btn btn-success m-r-10"><?php echo dictionary('SUBMIT');?>
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

        <script type="text/javascript">
            $('select#page_type').on('change', function() {
                var selected_value =  this.value;
                if(selected_value == 0 || selected_value == 2)
                {
                    $("#mysql_table_name").closest(".form-group").css("display","none");
                    $("#multi_upload_images").closest(".form-group").css("display","none");
                    $("#mysql_table_name").removeClass("required");

                }

                if(selected_value == 1 || selected_value == 3)
                {
                    $("#mysql_table_name").closest(".form-group").css("display","block");
                    $("#multi_upload_images").closest(".form-group").css("display","block");
                    $("#mysql_table_name").addClass("required");

                    $("#cp_page_parent_section").closest(".form-group").css("display","none");
                }
                else
                if(selected_value == 2)
                {
                    $("#cp_page_parent_section").closest(".form-group").css("display","block");
                }


            })


            function check_mysql_table()
            {
                var page_type = $( "#page_type" ).val();
                var go_to_submit = false;
                var mysql_table_name = $("#mysql_table_name").val().trim();
                //controlam daca exista asa tabel in baza de date
                if(page_type == 1 || page_type == 3)
                {
                    var data = {};
                    data['task'] = 'check_mysql_table';
                    data['mysql_table_name'] = mysql_table_name;

                    $.ajax({
                        type: "POST",
                        async: false,
                        context: go_to_submit,
                        url: "/cp_ajax_<?php echo $Main->lang;?>/",
                        data: data,
                        dataType: "json",
                        success: function (ajax_data)
                        {
                            if ( ajax_data.hasOwnProperty('error') && ajax_data['error']!="" )
                            {
                                $("#mysql_table_name").closest('.form-group').find('label').css('color', '#ff460e');
                                alert(ajax_data['error']);
                                go_to_submit = false;
                            }
                            else
                            {
                                $("#mysql_table_name").closest('.form-group').find('label').css('color', '');
                                go_to_submit = true;
                            }
                        }
                    });
                }
                else
                {
                    go_to_submit = true;
                }

                return go_to_submit;
            }

            function check_root_folders()
            {
                var page_type = $( "#page_type" ).val();
                var go_to_submit = false;
                var page_or_cat_name = $("#page_or_cat_name").val().trim();
                //controlam daca exista asa nume mape in root
                var data = {};
                if(page_type == 0)
                {
                    data['task'] = 'check_text_page_files';
                }
                else if(page_type == 1 || page_type == 3)
                {
                    data['task'] = 'check_root_folders';
                }
                else if(page_type == 2)
                {
                    data['task'] = 'check_cp_simple_page_files';
                }

                data['folder_name'] = page_or_cat_name;

                $.ajax({
                    type: "POST",
                    async: false,
                    context: go_to_submit,
                    url: "/cp_ajax_<?php echo $Main->lang;?>/",
                    data: data,
                    dataType: "json",
                    success: function (ajax_data)
                    {
                        if ( ajax_data.hasOwnProperty('error') && ajax_data['error']!="" )
                        {
                            $("#page_or_cat_name").closest('.form-group').find('label').css('color', '#ff460e');
                            alert(ajax_data['error']);
                            go_to_submit = false;
                        }
                        else
                        {
                            $("#page_or_cat_name").closest('.form-group').find('label').css('color', '');
                            go_to_submit = true;
                        }
                    }
                });

                return go_to_submit;
            }

            $(":input#page_or_cat_name").bind("change", function() {
                check_root_folders();
            })

            $(":input#mysql_table_name").bind("change", function() {
                check_mysql_table();
            })

            $('form#check_required_fields').submit(function()
            {
                check_root_folders();
                check_mysql_table();

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