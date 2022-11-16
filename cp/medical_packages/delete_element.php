<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/cp/class/include.php';
require_once 'settings.php';

if($User->check_cp_authorization())
{
    if($User->access_control($Form->page_access($page_data['id'])))
    {
        $ar_get_clean = filter_input_array(INPUT_GET, FILTER_SANITIZE_SPECIAL_CHARS);
        $status_info = array();
        if (isset($ar_get_clean['id']) && $validator->check_int($ar_get_clean['id']) && $ar_get_clean['id']>0)
        {
            $id =  $ar_get_clean['id'];
        }
        else
        {
            include_once $_SERVER['DOCUMENT_ROOT'].'/cp/php/templates/errors_in_url_address.php';
            exit();
        }

        $table_info = $db
            ->where('id', $id)
            ->getOne($db_table, "image");

        $db->where('id', $id);
        if($db->delete($db_table, 1))
        {
            //remove cpu
            $db->where('page_id', $PAGE_ID);
            $db->where('elem_id', $id);
            $db->delete('cpu');

            //remove main image
            $Form->remove_image($db_table, $table_info['image']);

            header("Location: ".$_SERVER['HTTP_REFERER']);
        }

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