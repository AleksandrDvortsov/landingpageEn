<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/cp/class/include.php';
require_once( __DIR__ . "/../settings.php");

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




            $select_catalog_elements = $db
                ->where('section_id',$id)
                ->get($db_catalog_elements_table, null, "id, image");
            if( count($select_catalog_elements) > 0 )
            {
                foreach($select_catalog_elements as $element)
                {
                   // show($element);
                    $table_info = $db
                        ->where('id', $id)
                        ->getOne($db_catalog_elements_table, "image");

                    $db->where('id', $element['id']);
                    if($db->delete($db_catalog_elements_table, 1))
                    {
                        //remove cpu
                        $db->where('page_id', $CPU_ELEM_ID);
                        $db->where('elem_id', $element['id']);
                        $db->delete($db_front_cpu_table);

                        //remove simple image
                        $Form->remove_image($db_catalog_elements_table, $element['image']);
                    }

                }
            }

            $catalog_table_info = $db
            ->where('id', $id)
            ->getOne($db_catalog_table, "image");

            $remove_catalog = $db
                ->where('id', $id)
                ->delete($db_catalog_table);
            if($remove_catalog)
            {
                //remove cpu
                $db->where('page_id', $CPU_CATEGORY_ID);
                $db->where('elem_id', $id);
                $db->delete($db_front_cpu_table);

                //remove main image
                $Form->remove_image($db_catalog_table, $catalog_table_info['image']);

            }



        ?>
        <script>
            document.location.href = '<?php echo $_SERVER['HTTP_REFERER'];?>';
        </script>
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