<?php
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


        $CATALOG_LEVEL = $Main->catalog_level($id);

        $catalog_ids_containter = array();
        $local_ids_containter = array();
        $catalog_ids_containter[] = $id;
        $local_ids_containter[] = $id;
        $loop = true;

        while($loop)
        {
            $found_children = false;
            if(isset($temp_conteiner))
            {
                unset($temp_conteiner);
            }
            $temp_conteiner = array();

            foreach($local_ids_containter as $ids_containter)
            {
                $get_catalogs_info = $db
                    ->where('section_id', $ids_containter)
                    ->get($db_catalog_table);
                if (count($get_catalogs_info) > 0)
                {
                    $found_children = true;
                    foreach ($get_catalogs_info as $catalogs_info)
                    {
                        $catalog_ids_containter[] = $catalogs_info['id'];
                        $temp_conteiner[] = $catalogs_info['id'];
                    }
                }
            }

            unset($local_ids_containter);
            $local_ids_containter = array();
            $local_ids_containter = $temp_conteiner;

            if(!$found_children)
            {
                $loop = false;
            }

        }


        if( count($catalog_ids_containter) > 0 )
        {
            $catalog_ids_containter = array_reverse($catalog_ids_containter);
            //show($catalog_ids_containter);
            foreach($catalog_ids_containter as $containter)
            {
                $select_catalog_elements = $db
                    ->where('section_id',$containter)
                    ->get($db_catalog_elements_table, null, "id");
                if( count($select_catalog_elements) > 0 )
                {
                    foreach($select_catalog_elements as $element)
                    {
                        $Form->remove_catalog_element($db,$element['id'],$db_catalog_elements_table,$CPU_ELEM_ID,$db_front_cpu_table,$db_catalog_elements_images,$db_catalog_elements_parameters_table);
                    }
                }

                //aflam daca catalogul curent are imagine
                $check_catalog_image = $db
                    ->where('id', $containter)
                    ->getOne($db_catalog_table);

                $remove_catalog = $db
                        ->where('id', $containter)
                        ->delete($db_catalog_table);
                if($remove_catalog)
                {
                    //remove cpu
                    $db->where('page_id', $CPU_CATEGORY_ID);
                    $db->where('elem_id', $containter);
                    $db->delete($db_front_cpu_table);

                    //remove main image
                    if(!empty($check_catalog_image['image']))
                    {
                        $Form->remove_image($db_catalog_table, $check_catalog_image['image']);
                    }

                    //remove main image
                    if(!empty($check_catalog_image['image2']))
                    {
                        $Form->remove_image($db_catalog_table, $check_catalog_image['image2']);
                    }
                }
            }

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