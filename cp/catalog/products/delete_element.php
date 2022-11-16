<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/cp/class/include.php';
require_once( __DIR__ . "/../settings.php");

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
            ->getOne($db_catalog_elements_table, "image");

        $db->where('id', $id);
        if($db->delete($db_catalog_elements_table, 1))
        {
            //remove cpu
            $db->where('page_id', $CPU_ELEM_ID);
            $db->where('elem_id', $id);
            $db->delete($db_front_cpu_table);

            //remove image
            $Form->remove_image($db_catalog_elements_table, $table_info['image']);

            // remove dropzone images ---------------------------------------------------------------//
            $get_table_dropzone_images = $db
                ->where('parent_id', $id)
                ->get($db_catalog_elements_images);
            foreach ( $get_table_dropzone_images as $table_dropzone_image )
            {
                $db->where('id', $table_dropzone_image['id']);
                if ($db->delete($db_catalog_elements_images, 1))
                {
                    $Form->remove_image($db_catalog_elements_images, $table_dropzone_image['image']);
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


            ?>
            <script>
                document.location.href = '<?php echo $_SERVER['HTTP_REFERER'];?>';
            </script>
            <?php

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