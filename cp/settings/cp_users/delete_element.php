<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/cp/class/include.php';
if($User->check_cp_authorization())
{
    if ($User->access_control($client_access))
    {
        $ar_get_clean = filter_input_array(INPUT_GET, FILTER_SANITIZE_SPECIAL_CHARS);
        if (isset($ar_get_clean['id']))
        {
            $id =  $ar_get_clean['id'];
        }
        else
        {
            include_once $_SERVER['DOCUMENT_ROOT'].'/cp/php/templates/errors_in_url_address.php';
            exit();
        }

        if( $validator->check_int($id) && $id>0 )
        {
            $check_if_user_exist = $db
                                        ->where ("id", $id)
                                        ->getOne("cp_users");
            if($check_if_user_exist)
            {
                //dezactivam utilizatorul
                $data = Array (
                    'active' => 0
                );

                $db->where ('id', $check_if_user_exist['id']);
                $db->update ('cp_users', $data);

                /* Nu este nevoie de stergerea utilizatorului din baza de date
                $db->where('id', $check_if_user_exist['id']);
                $db->delete('cp_users', 1);

                //remove main image
                $Form->remove_image('cp_user_photo', $check_if_user_exist['image']);
                */


                header("Location: ".$_SERVER['HTTP_REFERER']);
            }
            else
            {
                include_once $_SERVER['DOCUMENT_ROOT'].'/cp/php/templates/errors_in_url_address.php';
                exit();
            }
        }

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