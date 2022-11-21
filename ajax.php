<?php
usleep(20000);
require_once $_SERVER['DOCUMENT_ROOT'].'/cp/class/include.php';
$ar_get_clean = filter_input_array(INPUT_GET, FILTER_SANITIZE_SPECIAL_CHARS);
$ar_post_clean = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

// ===========================================================================================================

// return_form_required_input_info
if( isset($ar_post_clean['task'],$ar_post_clean['error_array']) && $ar_post_clean['task']=='return_form_required_input_info' && count($ar_post_clean['error_array']) > 0 )
{
    foreach( $ar_post_clean['error_array'] as $required_field )
    {
        //---------------------------SELECT OPTIONS -----------------------//
        // Pentru toate select-uri se afiseaza un mesaj  unic-comun
        if(!strcmp ( $required_field , 'select_options'))
        {
            ?>
            <div>
                <?php echo dictionary('EMTY_REQUIRED_INPUT_FIELD_SELECT_OPTIONS');?>
            </div>
            <?php
        }
        //--------------------------------------------------//

        //---------------------------FIO-----------------------//
        if(!strcmp ( $required_field , 'fio'))
        {
            ?>
            <div>
                <?php echo dictionary('EMTY_REQUIRED_INPUT_FIELD_FIO');?>
            </div>
            <?php
        }
        //--------------------------------------------------//

        //---------------------------FIRST NAME-----------------------//
        if(!strcmp ( $required_field , 'first_name'))
        {
            ?>
            <div>
                <?php echo dictionary('EMTY_REQUIRED_INPUT_FIELD_FIRSTNAME');?>
            </div>
            <?php
        }
        //--------------------------------------------------//

        //---------------------------LAST NAME-----------------------//
        if(!strcmp ( $required_field , 'last_name'))
        {
            ?>
            <div>
                <?php echo dictionary('EMTY_REQUIRED_INPUT_FIELD_LASTNAME');?>
            </div>
            <?php
        }
        //--------------------------------------------------//

        //---------------------------EMAIL-----------------------//
        if(!strcmp ( $required_field , 'email'))
        {
            ?>
            <div>
                <?php echo dictionary('EMTY_REQUIRED_INPUT_FIELD_EMAIL');?>
            </div>
            <?php
        }
        //--------------------------------------------------//

        //---------------------------PHONE-----------------------//
        if(!strcmp ( $required_field , 'phone'))
        {
            ?>
            <div>
                <?php echo dictionary('EMTY_REQUIRED_INPUT_FIELD_PHONE_NUMBER');?>
            </div>
            <?php
        }
        //--------------------------------------------------//

        //---------------------------MESSAGE-----------------------//
        if(!strcmp ( $required_field , 'message'))
        {
            ?>
            <div>
                <?php echo dictionary('EMTY_REQUIRED_INPUT_FIELD_MESSAGE');?>
            </div>
            <?php
        }
        //--------------------------------------------------//

        //---------------------------MESSAGE-----------------------//
        if(!strcmp ( $required_field , 'keystring'))
        {
            ?>
            <div>
                <?php echo dictionary('EMTY_REQUIRED_INPUT_FIELD_CAPTCHA');?>
            </div>
            <?php
        }
        //--------------------------------------------------//
        //---------------------------Subject-----------------------//
        if(!strcmp ( $required_field , 'subject'))
        {
            ?>
            <div>
                <?php echo dictionary('EMTY_REQUIRED_INPUT_FIELD_SUBJECT');?>
            </div>
            <?php
        }
        //--------------------------------------------------//

        //---------------------------Question-----------------------//
        if(!strcmp ( $required_field , 'question'))
        {
            ?>
            <div>
                <?php echo dictionary('EMTY_REQUIRED_INPUT_FIELD_ENTER_YOUR_QUESTION');?>
            </div>
            <?php
        }
        //--------------------------------------------------//



    }
}




// return_form_required_input_info_type2
if( isset($ar_post_clean['task'],$ar_post_clean['error_array']) && $ar_post_clean['task']=='return_form_required_input_info_type2' && count($ar_post_clean['error_array']) > 0 )
{
    $ajax_data = array();
    $sp_counter = 0;
    foreach( $ar_post_clean['error_array'] as $required_field )
    {
        //Controlam daca cimpul este de tip select
        $trunck_field_name = explode(':',$required_field);

        if(isset($trunck_field_name[1]) && $trunck_field_name[1] == 'selection_type')
        {
            $required_field = $trunck_field_name[0];
            $ajax_data[$sp_counter]['field'] = $required_field;
            $ajax_data[$sp_counter]['html'] = "<div class='required_field_info'>".dictionary('EMTY_REQUIRED_INPUT_FIELD_SELECT_OPTIONS')."</div>";
        }
        else
        {
            //-----------------------------------------------------//
            $field_finded = FALSE;

            if(!strcmp ( $required_field , 'fio'))
            {
                $field_finded = TRUE;
                $ajax_data[$sp_counter]['field'] = $required_field;
                $ajax_data[$sp_counter]['html'] = "<div class='required_field_info'>".dictionary('EMTY_REQUIRED_INPUT_FIELD_FIO')."</div>";
            }
            else if(!strcmp ( $required_field , 'first_name'))
            {
                $field_finded = TRUE;
                $ajax_data[$sp_counter]['field'] = $required_field;
                $ajax_data[$sp_counter]['html'] = "<div class='required_field_info'>".dictionary('EMTY_REQUIRED_INPUT_FIELD_FIRSTNAME')."</div>";
            }
            else if(!strcmp ( $required_field , 'last_name'))
            {
                $field_finded = TRUE;
                $ajax_data[$sp_counter]['field'] = $required_field;
                $ajax_data[$sp_counter]['html'] = "<div class='required_field_info'>".dictionary('EMTY_REQUIRED_INPUT_FIELD_LASTNAME')."</div>";
            }
            else if(!strcmp ( $required_field , 'email'))
            {
                $field_finded = TRUE;
                $ajax_data[$sp_counter]['field'] = $required_field;
                $ajax_data[$sp_counter]['html'] = "<div class='required_field_info'>".dictionary('EMTY_REQUIRED_INPUT_FIELD_EMAIL')."</div>";
            }
            else if(!strcmp ( $required_field , 'phone'))
            {
                $field_finded = TRUE;
                $ajax_data[$sp_counter]['field'] = $required_field;
                $ajax_data[$sp_counter]['html'] = "<div class='required_field_info'>".dictionary('EMTY_REQUIRED_INPUT_FIELD_PHONE_NUMBER')."</div>";
            }
            else if(!strcmp ( $required_field , 'message'))
            {
                $field_finded = TRUE;
                $ajax_data[$sp_counter]['field'] = $required_field;
                $ajax_data[$sp_counter]['html'] = "<div class='required_field_info'>".dictionary('EMTY_REQUIRED_INPUT_FIELD_MESSAGE')."</div>";
            }
            else if(!strcmp ( $required_field , 'keystring'))
            {
                $field_finded = TRUE;
                $ajax_data[$sp_counter]['field'] = $required_field;
                $ajax_data[$sp_counter]['html'] = "<div class='required_field_info'>".dictionary('EMTY_REQUIRED_INPUT_FIELD_CAPTCHA')."</div>";
            }
            else if(!strcmp ( $required_field , 'subject'))
            {
                $field_finded = TRUE;
                $ajax_data[$sp_counter]['field'] = $required_field;
                $ajax_data[$sp_counter]['html'] = "<div class='required_field_info'>".dictionary('EMTY_REQUIRED_INPUT_FIELD_SUBJECT')."</div>";
            }
            else if(!strcmp ( $required_field , 'question'))
            {
                $field_finded = TRUE;
                $ajax_data[$sp_counter]['field'] = $required_field;
                $ajax_data[$sp_counter]['html'] = "<div class='required_field_info'>".dictionary('EMTY_REQUIRED_INPUT_FIELD_ENTER_YOUR_QUESTION')."</div>";
            }


            //-----------------------------------------------------//

            if($field_finded === FALSE)
            {
                $ajax_data[$sp_counter]['field'] = $required_field;
                $ajax_data[$sp_counter]['html'] = "<div class='required_field_info'>".dictionary('EMTY_REQUIRED_INPUT_FIELD_COMMON_INFO')."</div>";
            }
        }






        $sp_counter++;
    }

    echo json_encode($ajax_data);
}

//====================================================================================================================//
// form_contact_us
if( isset($ar_post_clean['task']) && $ar_post_clean['task']=='form_contact_us' )
{
    $ajax_data = array();
    $ajax_data['html'] = array();
    $ajax_data['error'] = FALSE;
    $value =  array();
    parse_str($_POST['form_data'], $value);

    $ajax_data['form_data'] = $value;

    if (!filter_var( $value['email'], FILTER_VALIDATE_EMAIL))
    {
        $ajax_data['html'][] = dictionary('FRONT_WRONG_EMAIL_FORMAT');
        $ajax_data['error'] = TRUE;
    }

    if(!$ajax_data['error'])
    {
        $CSRF_VALIDATION = $Token->validateToken($value);

        if($CSRF_VALIDATION['result'])
        {
            $ajax_data['new_token_value'] = $CSRF_VALIDATION['new_token_value'];
            $form_processing_data = Array (
                "fio" => $value['fio'],
                "email" => $value['email'],
                "question" => $value['question']
            );

            if(isset($value['phone']) && trim($value['phone']) != '' )
            {
                $form_processing_data['phone'] = $value['phone'];
            }
            if(isset($value['subject']) && trim($value['subject']) != '' )
            {
                $form_processing_data['subject'] = $value['subject'];
            }


            $inserted_id = $db->insert ('contact_us', $form_processing_data);


            if (!$inserted_id)
            {
                $ajax_data['html'][] = dictionary('FORM_SEND_RESULT_ERROR');
                $ajax_data['error'] = 1;
            }
            else
            {
                require_once $_SERVER['DOCUMENT_ROOT'] . '/libraries/libmail/libmail.php';
                $from_title = "Forma - Contact";
                $text = '';

                if(isset($value['fio']) && trim($value['fio']) != '' )
                {
                    $text .= "Fio: ".$value['fio']."<br>";
                }
                if(isset($value['email']) && trim($value['email']) != '' )
                {
                    $text .= "Email: ".$value['email']."<br>";
                }
                if(isset($value['phone']) && trim($value['phone']) != '' )
                {
                    $text .= "Tel: ".$value['phone']."<br>";
                }
                if(isset($value['subject']) && trim($value['subject']) != '' )
                {
                    $text .= "Tema: ".$value['subject']."<br>";
                }
                if(isset($value['question']) && trim($value['question']) != '' )
                {
                    $text .= "Question: ".$value['question']."<br>";
                }

                $m = new Mail;

                $m->From( $from_title.";". $GLOBALS['ar_define_settings']['DONOTREPLY_EMAIL']); // от кого отправляется почта
                $m->To( $GLOBALS['ar_define_settings']['SEND_FORM_REQUEST_TO_EMAIL'] );
                $m->Subject( "Forma - Contact" );
                $m->Body( $text,"html");
                $m->Priority(3) ;    // приоритет письма
                $m->smtp_on($GLOBALS['ar_define_settings']['DONOTREPLY_SMTP'],$GLOBALS['ar_define_settings']['DONOTREPLY_EMAIL'],$GLOBALS['ar_define_settings']['DONOTREPLY_EMAIL_PASSWORD'], $GLOBALS['ar_define_settings']['DONOTREPLY_EMAIL_PORT']);
                if(@$m->Send())
                {
                    $ajax_data['html'][] = dictionary('FORM_SEND_RESULT_SUCCESS');
                }
                else
                {
                    $ajax_data['html'][] = dictionary('FORM_SEND_RESULT_ERROR');
                    $ajax_data['error'] = true;
                }

                unset($m);
            }




        }
        else
        {
            exit('WRONG CSRF token');
        }
    }

    echo json_encode($ajax_data);
}

//====================================================================================================================//
// appointment_records
if( isset($ar_post_clean['task']) && $ar_post_clean['task']=='appointment_records' )
{

    $ajax_data = array();
    $ajax_data['html'] = array();
    $ajax_data['error'] = FALSE;
    $value =  array();
    parse_str($_POST['form_data'], $value);

    $ajax_data['form_data'] = $value;

    //----------------------------------------------------------//
    if ( isset($value['email']) && !filter_var( $value['email'], FILTER_VALIDATE_EMAIL))
    {
        $ajax_data['html'][] = dictionary('FRONT_WRONG_EMAIL_FORMAT');
        $ajax_data['error'] = TRUE;
    }
    //----------------------------------------------------------//
    if(!$ajax_data['error'])
    {
        $CSRF_VALIDATION = $Token->validateToken($value);

        if($CSRF_VALIDATION['result'])
        {
            $ajax_data['new_token_value'] = $CSRF_VALIDATION['new_token_value'];

            $form_processing_data = Array ();
            if(isset($value['fio']) && trim($value['fio']) != '' )
            {
                $form_processing_data['fio'] = trim($value['fio']);
            }
            if(isset($value['department']) && $value['department'] > 0 )
            {
                $form_processing_data['department'] = (int)$value['department'];
            }
            if(isset($value['doctor']) && $value['doctor'] > 0 )
            {
                $form_processing_data['doctor'] = (int)$value['doctor'];
            }
            if(isset($value['phone']) && trim($value['phone']) != '' )
            {
                $form_processing_data['phone'] = trim($value['phone']);
            }
            if(isset($value['date']) && trim($value['date']) != '' )
            {
                $date = new DateTime($value['date']);
                $form_processing_data['date'] =  $date->format(" y-m-d H:i:s");
            }
            if(isset($value['email']) && trim($value['email']) != '' )
            {
                $form_processing_data['email'] = $value['email'];
            }
            if(isset($value['ref_element_type']) && $value['ref_element_type'] > 0 )
            {
                $form_processing_data['ref_element_type'] = (int)$value['ref_element_type'];
            }
            if(isset($value['ref_element_id']) && $value['ref_element_id'] >= 0 )
            {
                $form_processing_data['ref_element_id'] = (int)$value['ref_element_id'];
            }

            $inserted_id = $db->insert ('appointment_records', $form_processing_data);

            if (!$inserted_id)
            {
                $ajax_data['html'][] = dictionary('FORM_SEND_RESULT_ERROR');
                $ajax_data['error'] = 1;
            }
            else
            {
                require_once $_SERVER['DOCUMENT_ROOT'] . '/libraries/libmail/libmail.php';
                $from_title = "Forma de inregistrare";
                $text = '';

                if(isset($value['fio']) && trim($value['fio']) != '' )
                {
                    $text .= "Fio: ".$value['fio']."<br>";
                }
                if(isset($value['department']) && trim($value['department']) != '' )
                {
                    $text .= "Departament: ".department_data($value['department'])['title']."<br>";
                }
                if(isset($value['doctor']) && trim($value['doctor']) != '' )
                {
                    $text .= "Doctor: ".doctor_data($value['doctor'])['title']."<br>";
                }
                if(isset($value['date']) && trim($value['date']) != '' )
                {
                    $text .= "Data programarii: ".$date->format(" y-m-d H:i:s")."<br>";
                }
                if(isset($value['email']) && trim($value['email']) != '' )
                {
                    $text .= "Email: ".$value['email']."<br>";
                }
                if(isset($value['phone']) && trim($value['phone']) != '' )
                {
                    $text .= "Phone: ".$value['phone']."<br>";
                }
                if(isset($value['ref_element_type'],$value['ref_element_id']) && $value['ref_element_type'] > 0 && $value['ref_element_id'] >= 0 )
                {
                    $host_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
                    $href_link = $host_link.$Cpu->getURL($value['ref_element_type'], $value['ref_element_id']);
                    $text .= "<a href='".$href_link."'>".$href_link."</a>"."<br>";
                }
                $m = new Mail;

                $m->From( $from_title.";". $GLOBALS['ar_define_settings']['DONOTREPLY_EMAIL']); // от кого отправляется почта
                $m->To( $GLOBALS['ar_define_settings']['SEND_FORM_REQUEST_TO_EMAIL'] );
                $m->Subject( "Forma de inregistrare" );
                $m->Body( $text,"html");
                $m->Priority(3) ;    // приоритет письма
                $m->smtp_on($GLOBALS['ar_define_settings']['DONOTREPLY_SMTP'],$GLOBALS['ar_define_settings']['DONOTREPLY_EMAIL'],$GLOBALS['ar_define_settings']['DONOTREPLY_EMAIL_PASSWORD'], $GLOBALS['ar_define_settings']['DONOTREPLY_EMAIL_PORT']);
                if($m->Send())
                {
                    $ajax_data['html'][] = dictionary('FORM_SEND_RESULT_SUCCESS');
                }
                else
                {
                    $ajax_data['html'][] = dictionary('FORM_SEND_RESULT_ERROR');
                    $ajax_data['error'] = true;
                }

                unset($m);
            }
        }
        else
        {
            exit('WRONG CSRF token');
        }
    }

    echo json_encode($ajax_data);
}

//===================================================================================================================//
// get_department_doctors
if( isset($ar_post_clean['task'], $ar_post_clean['dep_id'])
    && $ar_post_clean['task']=='get_department_doctors'
    && $ar_post_clean['dep_id'] > 0
)
{
   // show('get_department_doctors');
    $get_departets_doctors_info = $db
        ->where('active',1)
        ->get('doctors'); 
    if($get_departets_doctors_info && count($get_departets_doctors_info)>0)
    {
        ?>
        <select class="selectmenu required" id="doctor_ajax_info" name="doctor">
            <option selected="selected"><?php echo dictionary('FRONT_APR_SELECT_DOCTOR');?></option>
            <?php
            foreach ($get_departets_doctors_info as $departets_doctors_info)
            {
                $userialized_dep_elem_array = unserialize($departets_doctors_info['d_id']);
                if( is_array($userialized_dep_elem_array) && in_array($ar_post_clean['dep_id'], $userialized_dep_elem_array) )
                {
                    ?>
                    <option value="<?php echo $departets_doctors_info['id'];?>">
                        <?php echo $departets_doctors_info['title_'.$lang];?>
                    </option>
                    <?php
                }
            }
            ?>
        </select>
        <?php
    }

}

//====================================================================================================================//

// Get doctors by departaments
if( isset($ar_post_clean['task'], $ar_post_clean['dep_id'])
    && $ar_post_clean['task']=='get_doctors_by_departaments'
    && $ar_post_clean['dep_id'] >= -1
)
{
    $ajax_data = array();
    $ajax_data = $ar_post_clean;

    if($ar_post_clean['dep_id'] == -1){
        $get_table_info = $db
            ->orderBy('sort','asc')
            ->where('active', 1)
            ->where('isOnline', 1)
            ->get('doctors');
    }else{
        $get_table_info = $db
            ->orderBy('sort','asc')
            ->where('active',1)
            ->get('doctors');
    }


    if($ar_post_clean['dep_id'] == 0)
    {
        ?>
        <div class="sp_dv7">
            <div class="sp_dv7T">
                <?php echo dictionary('DOC_PG_VIEW_ALL');?>
            </div>
        </div>
        <?php
    }
    else if($ar_post_clean['dep_id'] == -1){
        ?>
        <div class="sp_dv7">
            <div class="sp_dv7T">
                <?php echo dictionary('ISONLINE');?>
            </div>
        </div>
        <?php
    }
    else
    {
        $doctor_departament_data_info = $db
            ->where('id', $ar_post_clean['dep_id'])
            ->getOne('departaments', 'title_'.$lang.' as title');
        if($doctor_departament_data_info)
        {
            ?>
            <div class="sp_dv7">
                <div class="sp_dv7T">
                    <?php echo $doctor_departament_data_info['title'];?>
                </div>
            </div>
            <?php
        }
    }

    foreach ($get_table_info as $table_info)
    {
        $userialized_dep_elem_array = unserialize($table_info['d_id']);

        if($ar_post_clean['dep_id'] == 0 || $ar_post_clean['dep_id'] == -1)
        {
            $rw_id = $table_info['id'];
            $doctor_image = $db
                ->where('parent_id', $table_info['id'])
                ->getOne('doctors_images');
            $thumb_image = $Functions->image_thumb($doctor_image['image'], 'doctors_images','270','270','2','1');
            if(empty($thumb_image))
            {
                $thumb_image = '/css/images/no-photo.jpg';
            }


            $get_doctor_departament = $db
                ->where('id', $userialized_dep_elem_array, 'IN')
                ->get('departaments', null, 'title_'.$lang.' as title');
            ?>
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <div class="single-team-member">
                    <div class="img-holder">
                    <?php 
                        if($table_info['isOnline']){
                            ?>
                            <img src="/images/icon/online.png" alt="" style="position: absolute;width: 24px;margin: 10px;">
                            <?php
                        }else{
                            ?>
                            <img src="/images/icon/offline.png" alt="" style="position: absolute;width: 24px;margin: 10px;">
                            <?php
                        }
                    ?>
                        <img src="<?php echo $thumb_image; ?>" alt="<?php echo $table_info['title_'.$lang];?>">
                        <div class="overlay-style">
                            <div class="box">
                                <div class="content">
                                    <div class="top">
                                        <h3><?php echo $table_info['title_'.$lang];?></h3>
                                        <span>
                                            <?php
                                                echo  preview_text($table_info['text_2_'.$lang]).'<br/>';
                                            ?>
                                        </span>
                                    </div>
                                    <span class="border"></span>
                                    <div class="bottom">
                                        <ul>
                                            <li>
                                                <a class="link-btn-doctor" href="<?php echo $Cpu->getURL('703', $table_info['id'])?>">
                                                    <?php echo dictionary('FRONT_DETAILS');?>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-holder">
                            <h3><?php echo $table_info['title_'.$lang];?></h3>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        else
        {
            if( is_array($userialized_dep_elem_array) && in_array($ar_post_clean['dep_id'], $userialized_dep_elem_array) )
            {
                $rw_id = $table_info['id'];
                $doctor_image = $db
                    ->where('parent_id', $table_info['id'])
                    ->getOne('doctors_images');
                $thumb_image = $Functions->image_thumb($doctor_image['image'], 'doctors_images','270','270','2','1');
                if(empty($thumb_image))
                {
                    $thumb_image = '/css/images/no-photo.jpg';
                }


                $get_doctor_departament = $db
                    ->where('id', $userialized_dep_elem_array, 'IN')
                    ->get('departaments', null, 'title_'.$lang.' as title');
                ?>
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                    <div class="single-team-member">
                        <div class="img-holder">
                        <?php 
                            if($table_info['isOnline']){
                                ?><img class="icon-is-online" src="/images/icon/online.png" alt="" title="<?php echo dictionary('DOCTORACCEPTSONLINE');?>"><?php
                            }else{
                                ?><img class="icon-is-online" src="/images/icon/offline.png" alt="" title="<?php echo dictionary('DOCTORNOACCEPTSONLINE');?>"><?php
                            }
                        ?>
                            <img src="<?php echo $thumb_image; ?>" alt="<?php echo $table_info['title_'.$lang];?>">
                            <div class="overlay-style">
                                <div class="box">
                                    <div class="content">
                                        <div class="top">
                                            <h3><?php echo $table_info['title_'.$lang];?></h3>
                                            <span>
                                                 <?php
                                                 echo  preview_text($table_info['text_2_'.$lang]).'<br/>';
                                                 ?>
                                            </span>
                                        </div>
                                        <span class="border"></span>
                                        <div class="bottom">
                                            <ul>
                                                <li>
                                                    <a class="link-btn-doctor" href="<?php echo $Cpu->getURL('703', $table_info['id'])?>">
                                                        <?php echo dictionary('FRONT_DETAILS');?>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-holder">
                                <h3><?php echo $table_info['title_'.$lang];?></h3>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        }




    }

}


//====================================================================================================================//
// pop_up - content_editor
if( isset($ar_post_clean['task'],$ar_post_clean['type']) && $ar_post_clean['task']=='content_editor' && trim($ar_post_clean['type']) != '' )
{
    if($User->check_cp_authorization())
    {
        if(!strcmp ( $ar_post_clean['type'] , 'dictionary_code'))
        {
            $dictionary_code = $db->escape($ar_post_clean['code']);
            $setting_code = $db
                ->where('code', $dictionary_code)
                ->getOne("dictionary");
            if($setting_code)
            {
                ?>
                <div class="popUpgltop_dev dictionary_pop_up">
                    <div class="inside">
                        <div class="close" onclick="close_popUpGal_with_refresh()"></div>
                        <div style="clear:both; width: 100%; height: 5px;"></div>
                        <div style="color: #8d9ea7; font-size: 14px;text-align: center;"><?php echo dictionary('CONTROL_PANEL_DICTIONARY');?></div>
                        <?php
                        foreach ( $list_of_site_langs as $site_langs)
                        {
                            ?>
                            <div class="dev_content_lang">
                                <?php echo mb_ucfirst($site_langs);?>
                            </div>
                            <textarea class="wpcf7-form-control input_focusof" data-language = "<?php echo $site_langs;?>"
                                      onchange="change_dictionary_input_value('<?php echo $setting_code['id']; ?>',$(this).data('language'),$(this).val());"
                                      onpaste="this.onchange();"><?php echo trim($setting_code['title_'.$site_langs]);?></textarea>
                            <?php
                        }
                        ?>
                    </div>
                    <div style="clear:both; width: 100%; height: 15px;"></div>
                </div>
                <?php
            }
        }
    }
}

//====================================================================================================================//

//====================================================================================================================//
// appointment_records_second_type
if( isset($ar_post_clean['task']) && $ar_post_clean['task']=='appointment_records_second_type' )
{
    $ajax_data = array();
    $ajax_data['html'] = array();
    $ajax_data['error'] = FALSE;
    $value =  array();
    parse_str($_POST['form_data'], $value);

    $ajax_data['form_data'] = $value;

    //----------------------------------------------------------//
    if ( isset($value['email']) && !filter_var( $value['email'], FILTER_VALIDATE_EMAIL))
    {
        $ajax_data['html'][] = dictionary('FRONT_WRONG_EMAIL_FORMAT');
        $ajax_data['error'] = TRUE;
    }
    //----------------------------------------------------------//
    if(!$ajax_data['error'])
    {
        $CSRF_VALIDATION = $Token->validateToken($value);

        if($CSRF_VALIDATION['result'])
        {
            $ajax_data['new_token_value'] = $CSRF_VALIDATION['new_token_value'];

            $form_processing_data = Array ();
            if(isset($value['fio']) && trim($value['fio']) != '' )
            {
                $form_processing_data['fio'] = trim($value['fio']);
            }
            if(isset($value['department']) && $value['department'] > 0 )
            {
                $form_processing_data['department'] = (int)$value['department'];
            }
            if(isset($value['doctor']) && $value['doctor'] > 0 )
            {
                $form_processing_data['doctor'] = (int)$value['doctor'];
            }
            if(isset($value['phone']) && trim($value['phone']) != '' )
            {
                $form_processing_data['phone'] = trim($value['phone']);
            }
            if(isset($value['date']) && trim($value['date']) != '' )
            {
                $date = new DateTime($value['date']);
                $form_processing_data['date'] =  $date->format(" y-m-d H:i:s");
            }
            if(isset($value['email']) && trim($value['email']) != '' )
            {
                $form_processing_data['email'] = $value['email'];
            }
            if(isset($value['ref_element_type']) && $value['ref_element_type'] > 0 )
            {
                $form_processing_data['ref_element_type'] = (int)$value['ref_element_type'];
            }
            if(isset($value['ref_element_id']) && $value['ref_element_id'] >= 0 )
            {
                $form_processing_data['ref_element_id'] = (int)$value['ref_element_id'];
            }

            $inserted_id = $db->insert ('appointment_records', $form_processing_data);

            if (!$inserted_id)
            {
                $ajax_data['html'][] = dictionary('FORM_SEND_RESULT_ERROR');
                $ajax_data['error'] = 1;
            }
            else
            {
                require_once $_SERVER['DOCUMENT_ROOT'] . '/libraries/libmail/libmail.php';
                $from_title = "Forma de inregistrare";
                $text = '';

                if(isset($value['fio']) && trim($value['fio']) != '' )
                {
                    $text .= "Fio: ".$value['fio']."<br>";
                }
                if(isset($value['department']) && trim($value['department']) != '' )
                {
                    $text .= "Departament: ".department_data($value['department'])['title']."<br>";
                }
                if(isset($value['doctor']) && trim($value['doctor']) != '' )
                {
                    $text .= "Doctor: ".doctor_data($value['doctor'])['title']."<br>";
                }
                if(isset($value['date']) && trim($value['date']) != '' )
                {
                    $text .= "Data programarii: ".$date->format(" y-m-d H:i:s")."<br>";
                }
                if(isset($value['email']) && trim($value['email']) != '' )
                {
                    $text .= "Email: ".$value['email']."<br>";
                }
                if(isset($value['phone']) && trim($value['phone']) != '' )
                {
                    $text .= "Phone: ".$value['phone']."<br>";
                }

                if(isset($value['ref_element_type'],$value['ref_element_id']) && $value['ref_element_type'] > 0 && $value['ref_element_id'] >= 0 )
                {
                    $host_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
                    $href_link = $host_link.$Cpu->getURL($value['ref_element_type'], $value['ref_element_id']);
                    $text .= "<a href='".$href_link."'>".$href_link."</a>"."<br>";
                }






                $m = new Mail;

                $m->From( $from_title.";". $GLOBALS['ar_define_settings']['DONOTREPLY_EMAIL']); // от кого отправляется почта
                $m->To( $GLOBALS['ar_define_settings']['SEND_FORM_REQUEST_TO_EMAIL'] );
                $m->Subject( "Forma de inregistrare" );
                $m->Body( $text,"html");
                $m->Priority(3) ;    // приоритет письма
                $m->smtp_on($GLOBALS['ar_define_settings']['DONOTREPLY_SMTP'],$GLOBALS['ar_define_settings']['DONOTREPLY_EMAIL'],$GLOBALS['ar_define_settings']['DONOTREPLY_EMAIL_PASSWORD'], $GLOBALS['ar_define_settings']['DONOTREPLY_EMAIL_PORT']);
                if($m->Send())
                {
                    $ajax_data['html'][] = dictionary('FORM_SEND_RESULT_SUCCESS');
                }
                else
                {
                    $ajax_data['html'][] = dictionary('FORM_SEND_RESULT_ERROR');
                    $ajax_data['error'] = true;
                }

                unset($m);
            }
        }
        else
        {
            exit('WRONG CSRF token');
        }
    }

    echo json_encode($ajax_data);
}


//====================================================================================================================//
// question_answer_request
if( isset($ar_post_clean['task']) && $ar_post_clean['task']=='question_answer_request' )
{

    $ajax_data = array();
    $ajax_data['html'] = array();
    $ajax_data['error'] = FALSE;
    $value =  array();
    parse_str($_POST['form_data'], $value);

    $ajax_data['form_data'] = $value;

    if (!filter_var( $value['email'], FILTER_VALIDATE_EMAIL))
    {
        $ajax_data['html'][] = dictionary('FRONT_WRONG_EMAIL_FORMAT');
        $ajax_data['error'] = TRUE;
    }

    if(!$ajax_data['error'])
    {
        $CSRF_VALIDATION = $Token->validateToken($value);

        if($CSRF_VALIDATION['result'])
        {
            $ajax_data['new_token_value'] = $CSRF_VALIDATION['new_token_value'];


            $form_processing_data = Array (
                "fio" => $value['fio'],
                'department' => $value['department'],
                "email" => $value['email'],
                "subject" => $value['subject'],
                "question" => $value['question'],
                'ref_element_type' => $value['ref_element_type'],
                'ref_element_id' => $value['ref_element_id']
            );

            $inserted_id = $db->insert ('ask_questions', $form_processing_data);

            if (!$inserted_id)
            {
                $ajax_data['html'][] = dictionary('FORM_SEND_RESULT_ERROR');
                $ajax_data['error'] = 1;
            }
            else
            {
                require_once $_SERVER['DOCUMENT_ROOT'] . '/libraries/libmail/libmail.php';
                $from_title = "Forma - Întrebări";
                $text = '';

                if(isset($value['fio']) && trim($value['fio']) != '' )
                {
                    $text .= "Fio: ".$value['fio']."<br>";
                }
                if(isset($value['department']) && trim($value['department']) != '' )
                {
                    $text .= "Departament: ".department_data($value['department'])['title']."<br>";
                }
                if(isset($value['email']) && trim($value['email']) != '' )
                {
                    $text .= "Email: ".$value['email']."<br>";
                }

                if(isset($value['subject']) && trim($value['subject']) != '' )
                {
                    $text .= "Tema: ".$value['subject']."<br>";
                }
                if(isset($value['question']) && trim($value['question']) != '' )
                {
                    $text .= "Question: ".$value['question']."<br>";
                }

                $m = new Mail;

                $m->From( $from_title.";". $GLOBALS['ar_define_settings']['DONOTREPLY_EMAIL']); // от кого отправляется почта
                $m->To( $GLOBALS['ar_define_settings']['SEND_FORM_REQUEST_TO_EMAIL'] );
                $m->Subject( "Forma - Întrebări" );
                $m->Body( $text,"html");
                $m->Priority(3) ;    // приоритет письма
                $m->smtp_on($GLOBALS['ar_define_settings']['DONOTREPLY_SMTP'],$GLOBALS['ar_define_settings']['DONOTREPLY_EMAIL'],$GLOBALS['ar_define_settings']['DONOTREPLY_EMAIL_PASSWORD'], $GLOBALS['ar_define_settings']['DONOTREPLY_EMAIL_PORT']);
                if($m->Send())
                {
                    $ajax_data['html'][] = dictionary('FORM_SEND_RESULT_SUCCESS');
                }
                else
                {
                    $ajax_data['html'][] = dictionary('FORM_SEND_RESULT_ERROR');
                    $ajax_data['error'] = true;
                }

                unset($m);
            }




        }
        else
        {
            exit('WRONG CSRF token');
        }
    }

    echo json_encode($ajax_data);
}

//====================================================================================================================//
// ajax_dinamic_packets
if( isset($ar_post_clean['task'],$ar_post_clean['dep_id']) && $ar_post_clean['task']=='ajax_dinamic_packets'
    && is_numeric($ar_post_clean['dep_id']) && $ar_post_clean['dep_id'] >= 0 )
{
    ?>
    <div class="pakets-medikal owl-carousel">
        <?php
        if($ar_post_clean['dep_id'] == 0)
        {
            $get_medical_packages_data_info = $db
                ->where('active', 1)
                ->orderBy('sort', 'asc')
                ->get('medical_packages');
        }
        else
        {
            $get_medical_packages_data_info = $db
                ->where('active', 1)
                ->where('dep_id', (int)$ar_post_clean['dep_id'])
                ->orderBy('sort', 'asc')
                ->get('medical_packages');
        }

        if($get_medical_packages_data_info && count($get_medical_packages_data_info))
        {
            foreach ($get_medical_packages_data_info as $medical_packages_data_info)
            {
                $medical_packages_cpu = $Cpu->getURL(773, $medical_packages_data_info['id']);
                ?>
                <div class="pakets-item">
                    <div class="pakets-img">
                        <?php
                        $medical_packages_thumb_image = $Functions->image_thumb($medical_packages_data_info['image'], 'medical_packages', 700, 400, 741, 1);
                        ?>
                        <a href="<?php echo $medical_packages_cpu;?>" class="link-img" style="background-image: url(<?php echo $medical_packages_thumb_image;?>);"></a>
                    </div>
                    <div class="pakets-content">
                        <div class="pakets-content--header">
                            <h3><a href="<?php echo $medical_packages_cpu;?>"><?php echo $medical_packages_data_info['title_'.$lang];?></a></h3>
                        </div>
                        <div class="pakets-content--body">
                            <ul>
                                <?php
                                if(isset($medical_packages_data_info['design_for_'.$lang]) && trim($medical_packages_data_info['design_for_'.$lang])!='')
                                {
                                    ?>
                                    <li><div><?php echo dictionary('FRONT_CP_DESIGN_FOR').' '.$medical_packages_data_info['design_for_'.$lang];?></div></li>
                                    <?php
                                }
                                ?>
                                <?php
                                if(isset($medical_packages_data_info['duration_'.$lang]) && trim($medical_packages_data_info['duration_'.$lang])!='')
                                {
                                    ?>
                                    <li><div><?php echo dictionary('FRONT_CP_DURATION').' '.$medical_packages_data_info['duration_'.$lang];?></div></li>
                                    <?php
                                }
                                ?>
                                <?php
                                if(isset($medical_packages_data_info['price']) && $medical_packages_data_info['price']>0)
                                {
                                    ?>
                                    <li><div><?php echo dictionary('FRONT_PRICE_KEY_741').' '.$medical_packages_data_info['price'].' '.dictionary('LEI');?></div></li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </div>
                        <div class="pakets-content--footer">
                            <a href="<?php echo $medical_packages_cpu;?>" class="btn btn-default btn-block button-sl">
                                <?php echo dictionary('FRONT_JOIN_TODAY');?>
                            </a>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        ?>
    </div>
    <?php

}

//===================================================================================================================//
//  ajax_dinamic_doctors
if( isset($ar_post_clean['task'],$ar_post_clean['dep_id']) && $ar_post_clean['task']=='ajax_dinamic_doctors'
    && is_numeric($ar_post_clean['dep_id']) && $ar_post_clean['dep_id'] >= 0 )
{
    ?>
    <div class="doktors-block owl-carousel">
        <?php
        $get_doctors_data_info = $db
            ->where('active', 1)
            ->where('show_on_main_page', 1)
            ->orderBy('sort', 'asc')
            ->get('doctors');
        if($get_doctors_data_info && count($get_doctors_data_info))
        {
            foreach ($get_doctors_data_info as $doctors_data_info)
            {
                if($ar_post_clean['dep_id'] == 0)
                {
                    $doctors_data_info_cpu = $Cpu->getURL(703, $doctors_data_info['id']);
                    ?>
                    <div class="pakets-item">
                        <div class="pakets-img">
                            <?php
                            $doctor_image = $db
                                ->where('parent_id', $doctors_data_info['id'])
                                ->orderBy('sort', 'asc')
                                ->getOne('doctors_images');
                            $doctors_data_info_thumb_image = $Functions->image_thumb($doctor_image['image'], 'doctors_images', 712, 330, 749, 0);
                            if(empty($doctors_data_info_thumb_image))
                            {
                                $doctors_data_info_thumb_image = '/css/images/no-photo.jpg';
                            }

                            ?>
                            <a href="<?php echo $doctors_data_info_cpu;?>" class="link-img" style="background-image: url(<?php echo $doctors_data_info_thumb_image;?>);-webkit-background-size: contain;background-size: contain;"></a>
                        </div>
                        <div class="pakets-content">
                            <div class="pakets-content--header">
                                <h3><a href="<?php echo $doctors_data_info_cpu;?>"><?php echo $doctors_data_info['title_'.$lang];?></a></h3>
                                <h6 class="subtitle">
                                    <?php echo preview_text($doctors_data_info['text_3_'.$lang], 100);?></h6>
                            </div>
                            <div class="pakets-content--body">
                                <p><?php echo preview_text($doctors_data_info['text_2_'.$lang], 100);?></p>
                            </div>
                            <div class="pakets-content--footer">
                                <a href="<?php echo $doctors_data_info_cpu;?>" class="btn btn-default btn-block button-sl">
                                    <?php echo dictionary('FRONT_JOIN_TODAY2');?>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                else
                {
                    $userialized_dep_elem_array = unserialize($doctors_data_info['d_id']);
                    if( is_array($userialized_dep_elem_array) && in_array($ar_post_clean['dep_id'], $userialized_dep_elem_array) )
                    {
                        $doctors_data_info_cpu = $Cpu->getURL(703, $doctors_data_info['id']);
                        ?>
                        <div class="pakets-item">
                            <div class="pakets-img">
                                <?php
                                $doctor_image = $db
                                    ->where('parent_id', $doctors_data_info['id'])
                                    ->orderBy('sort', 'asc')
                                    ->getOne('doctors_images');
                                $doctors_data_info_thumb_image = $Functions->image_thumb($doctor_image['image'], 'doctors_images', 712, 330, 749, 0);
                                if(empty($doctors_data_info_thumb_image))
                                {
                                    $doctors_data_info_thumb_image = '/css/images/no-photo.jpg';
                                }

                                ?>
                                <a href="<?php echo $doctors_data_info_cpu;?>" class="link-img" style="background-image: url(<?php echo $doctors_data_info_thumb_image;?>);-webkit-background-size: contain;background-size: contain;"></a>
                            </div>
                            <div class="pakets-content">
                                <div class="pakets-content--header">
                                    <h3><a href="<?php echo $doctors_data_info_cpu;?>"><?php echo $doctors_data_info['title_'.$lang];?></a></h3>
                                    <h6 class="subtitle">
                                        <?php echo preview_text($doctors_data_info['text_3_'.$lang], 100);?></h6>
                                </div>
                                <div class="pakets-content--body">
                                    <p><?php echo preview_text($doctors_data_info['text_2_'.$lang], 100);?></p>
                                </div>
                                <div class="pakets-content--footer">
                                    <a href="<?php echo $doctors_data_info_cpu;?>" class="btn btn-default btn-block button-sl">
                                        <?php echo dictionary('FRONT_JOIN_TODAY2');?>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }

            }
        }
        ?>
    </div>
    <?php

}