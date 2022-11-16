<?php
// dropzone files
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


        $db->where('id', $id);
        if($db->delete($db_table, 1))
        {
            // ------------- remove images from $db_table_dropzone1_images -------------
            if(!empty($db_table_dropzone1_images))
            {
                $get_dropzone_images1 = $db
                    ->where('parent_id', $id)
                    ->get($db_table_dropzone1_images);
                foreach ( $get_dropzone_images1 as $dropzone_image )
                {
                    $db->where('id', $dropzone_image['id']);
                    if ($db->delete($db_table_dropzone1_images, 1))
                    {
                        $Form->remove_image($db_table_dropzone1_images, $dropzone_image['image']);
                    }
                }
                $db->where('parent_id', $id);
                $db->delete($db_table_dropzone1_images);
            }
            // END: ------------- remove images from $db_table_dropzone1_images --------

            // ------------- remove images from $db_table_dropzone2_images -------------
            if(!empty($db_table_dropzone2_images))
            {
                $get_dropzone_images2 = $db
                    ->where('parent_id', $id)
                    ->get($db_table_dropzone2_images);
                foreach ( $get_dropzone_images2 as $dropzone_image )
                {
                    $db->where('id', $dropzone_image['id']);
                    if ($db->delete($db_table_dropzone2_images, 1))
                    {
                        $Form->remove_image($db_table_dropzone2_images, $dropzone_image['image']);
                    }
                }
                $db->where('parent_id', $id);
                $db->delete($db_table_dropzone2_images);
            }
            // END: ------------- remove images from $db_table_dropzone2_images --------


            // ------------- remove images from $db_table_dropzone3_images -------------
            if(!empty($db_table_dropzone3_images))
            {
                $get_dropzone_images3 = $db
                    ->where('parent_id', $id)
                    ->get($db_table_dropzone3_images);
                foreach ( $get_dropzone_images3 as $dropzone_image )
                {
                    $db->where('id', $dropzone_image['id']);
                    if ($db->delete($db_table_dropzone3_images, 1))
                    {
                        $Form->remove_image($db_table_dropzone3_images, $dropzone_image['image']);
                    }
                }
                $db->where('parent_id', $id);
                $db->delete($db_table_dropzone3_images);
            }
            // END: ------------- remove images from $db_table_dropzone3_images --------


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