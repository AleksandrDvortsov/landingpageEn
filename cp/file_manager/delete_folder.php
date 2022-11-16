<?php
exit("remove folder");
require_once $_SERVER['DOCUMENT_ROOT'] . '/cp/class/include.php';
require_once("settings.php");

if($User->check_cp_authorization())
{
	if($User->access_control($Form->page_access($page_data['id'])))
    {
        $ar_get_clean = filter_input_array(INPUT_GET, FILTER_SANITIZE_SPECIAL_CHARS);
        $status_info = array();
        if (isset($ar_get_clean['section_id']) && $validator->check_int($ar_get_clean['section_id']) && $ar_get_clean['section_id']>0)
        {
            $id =  $ar_get_clean['section_id'];
        }
        else
        {
            include_once $_SERVER['DOCUMENT_ROOT'].'/cp/php/templates/errors_in_url_address.php';
            exit();
        }


        function remove_catalog_element($db,$id,$db_catalog_elements_table,$CPU_ELEM_ID,$db_front_cpu_table,$db_catalog_elements_images,$db_catalog_elements_parameters_table)
        {
            $db->where('id', $id);
            if($db->delete($db_catalog_elements_table, 1))
            {
                //remove cpu
                $db->where('page_id', $CPU_ELEM_ID);
                $db->where('elem_id', $id);
                $db->delete($db_front_cpu_table);

                // remove images ---------------------------------------------------------------//
                $get_table_dropzone_images = $db
                    ->where('parent_id', $id)
                    ->get($db_catalog_elements_images);
                foreach ( $get_table_dropzone_images as $table_dropzone_image )
                {
                    $db->where('id', $table_dropzone_image['id']);
                    if ($db->delete($db_catalog_elements_images, 1))
                    {
                        remove_image($db_catalog_elements_images, $table_dropzone_image['image']);
                    }
                }
                $db->where('parent_id', $id);
                $db->delete($db_catalog_elements_images);
                //--------------------------------------------------------------------------------//

                //--- remove paramenters ----------------------------//
                $remove_current_element_parameters = $db
                    ->where('element_id', $id)
                    ->delete($db_catalog_elements_parameters_table);
                //--------------------------------------------------//
            }
        }


        header("Location: ".$_SERVER['HTTP_REFERER']);

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