<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/cp/class/include.php';
if($User->check_cp_authorization())
{
    if ($User->access_control($developer_access))
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
            $db->where ("id", $id);
            $word_info= $db->getOne("dictionary");
            if($word_info)
            {
                $db->where('id', $word_info['id']);
                $db->delete('dictionary', 1);
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