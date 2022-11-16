<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/cp/class/include.php';

if($User->check_cp_authorization())
{
    if($User->access_control($developer_access))
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

        $page_info = $db
            ->where('id', $id)
            ->getOne('pages');



        if( !empty($page_info['dir_file_name']) )
        {
            if( $page_info['type'] == 0 || $page_info['type'] == 1 || $page_info['type'] == 3)
            {
                // ---- IF 2 LEVEL --- //
                $special_page_array = array();
                $special_page_array[] = '/cp/'.$page_info['dir_file_name'].'/index.php';
                $special_page_array[] = '/cp/'.$page_info['dir_file_name'].'/add_element.php';
                $special_page_array[] = '/cp/'.$page_info['dir_file_name'].'/edit_element.php';
                $special_page_array[] = '/cp/'.$page_info['dir_file_name'].'/delete_element.php';
                $special_page_array[] = '/'.$page_info['dir_file_name'].'/index.php';
                $special_page_array[] = '/'.$page_info['dir_file_name'].'/detail.php';
                $check_table_info = '/'.$page_info['dir_file_name'].'/index.php';
                $sp_page_of_table_detail_elements_id = 0;

                // --- show($special_page_array);
                //remove CPU for CP files and remove files
                // --- index
                // --- add_element
                // --- edit_element
                // --- delete_element
                // remove CPU for FRONT files and remove files
                // --- index
                // --- detail

                foreach ( $special_page_array as $sp_page_array)
                {
                    $page_dir_info = $db
                        ->where('page', $sp_page_array)
                        ->getOne('pages');
                    // show($page_dir_info);

                    if($page_dir_info)
                    {
                        if($sp_page_array == '/'.$page_info['dir_file_name'].'/detail.php')
                        {
                            $sp_page_of_table_detail_elements_id = $page_dir_info['id'];
                        }

                        //remove cpu
                        $db->where('page_id', $page_dir_info['id']);
                        $db->where('elem_id', 0);
                        $db->delete('cpu');

                        $remove_page_info = $db
                            ->where('id', $page_dir_info['id'])
                            ->delete('pages', 1);
                    }

                }




                if (is_dir($_SERVER['DOCUMENT_ROOT'].'/cp/'.$page_info['dir_file_name']))
                {
                    $Functions->deleteDir($_SERVER['DOCUMENT_ROOT'].'/cp/'.$page_info['dir_file_name']);
                }

                if (is_dir($_SERVER['DOCUMENT_ROOT'].'/'.$page_info['dir_file_name']))
                {
                    $Functions->deleteDir($_SERVER['DOCUMENT_ROOT'].'/'.$page_info['dir_file_name']);
                }

                if (is_dir($_SERVER['DOCUMENT_ROOT'].'/uploads/'.$page_info['dir_file_name']))
                {
                    $Functions->deleteDir($_SERVER['DOCUMENT_ROOT'].'/uploads/'.$page_info['dir_file_name']);
                }




                // Stergerea tabelelor si imaginilor
                // remove image
                if( isset($page_info['db_table']) && !empty($page_info['db_table']) )
                {
                    $get_db_table_images = $db
                        ->get($page_info['db_table']);
                    foreach ( $get_db_table_images as $db_table_images )
                    {
                        //remove cpu
                        $db->where('page_id', $sp_page_of_table_detail_elements_id);
                        $db->where('elem_id', $db_table_images['id']);
                        $db->delete('cpu');

                        //remove main image
                        if(!empty($db_table_images['image']))
                        {
                            $Form->remove_image($page_info['db_table'], $db_table_images['image']);
                        }

                    }

                    // remove table from db
                    $db_table_name_with_prefix = $db::$prefix.$page_info['db_table'];
                    $sql_drop_db_table = " DROP TABLE {$db_table_name_with_prefix} ";
                    // show($sql_drop_db_table);
                    $Drop_db_table = $db->rawQueryOne($sql_drop_db_table);
                }

                // ---------------------- remove image from dropzone_image_table1 -----------------------------
                if( isset($page_info['dropzone_image_table1']) && !empty($page_info['dropzone_image_table1']) )
                {
                    $get_dropzone_images = $db
                        ->get($page_info['dropzone_image_table1']);
                    foreach ( $get_dropzone_images as $dropzone_image )
                    {
                        $db->where('id', $dropzone_image['id']);
                        if ($db->delete($page_info['dropzone_image_table1'], 1))
                        {
                            $Form->remove_image( $page_info['dropzone_image_table1'], $dropzone_image['image'] );
                        }
                    }
                    // remove table from db
                    $db_dropzone_image_table_name_with_prefix = $db::$prefix.$page_info['dropzone_image_table1'];
                    $sql_drop_dropzone_table = " DROP TABLE {$db_dropzone_image_table_name_with_prefix} ";
                    //show($sql_drop_dropzone_table);
                    $Drop_dropzone_table = $db->rawQueryOne($sql_drop_dropzone_table);

                    if (is_dir($_SERVER['DOCUMENT_ROOT'].'/uploads/'.$page_info['dropzone_image_table1']))
                    {
                        $Functions->deleteDir($_SERVER['DOCUMENT_ROOT'].'/uploads/'.$page_info['dropzone_image_table1']);
                    }

                }

                // -------------------------- remove image from dropzone_image_table2 ------------------------------
                if( isset($page_info['dropzone_image_table2']) && !empty($page_info['dropzone_image_table2']) )
                {
                    $get_dropzone_images = $db
                        ->get($page_info['dropzone_image_table2']);
                    foreach ( $get_dropzone_images as $dropzone_image )
                    {
                        $db->where('id', $dropzone_image['id']);
                        if ($db->delete($page_info['dropzone_image_table2'], 1))
                        {
                            $Form->remove_image( $page_info['dropzone_image_table2'], $dropzone_image['image'] );
                        }
                    }
                    // remove table from db
                    $db_dropzone_image_table_name_with_prefix = $db::$prefix.$page_info['dropzone_image_table2'];
                    $sql_drop_dropzone_table = " DROP TABLE {$db_dropzone_image_table_name_with_prefix} ";
                    //show($sql_drop_dropzone_table);
                    $Drop_dropzone_table = $db->rawQueryOne($sql_drop_dropzone_table);

                    if (is_dir($_SERVER['DOCUMENT_ROOT'].'/uploads/'.$page_info['dropzone_image_table2']))
                    {
                        $Functions->deleteDir($_SERVER['DOCUMENT_ROOT'].'/uploads/'.$page_info['dropzone_image_table2']);
                    }

                }

                // ---------------------- remove image from dropzone_image_table3 -----------------------------
                if( isset($page_info['dropzone_image_table3']) && !empty($page_info['dropzone_image_table3']) )
                {
                    $get_dropzone_images = $db
                        ->get($page_info['dropzone_image_table3']);
                    foreach ( $get_dropzone_images as $dropzone_image )
                    {
                        $db->where('id', $dropzone_image['id']);
                        if ($db->delete($page_info['dropzone_image_table3'], 1))
                        {
                            $Form->remove_image( $page_info['dropzone_image_table3'], $dropzone_image['image'] );
                        }
                    }
                    // remove table from db
                    $db_dropzone_image_table_name_with_prefix = $db::$prefix.$page_info['dropzone_image_table3'];
                    $sql_drop_dropzone_table = " DROP TABLE {$db_dropzone_image_table_name_with_prefix} ";
                    //show($sql_drop_dropzone_table);
                    $Drop_dropzone_table = $db->rawQueryOne($sql_drop_dropzone_table);

                    if (is_dir($_SERVER['DOCUMENT_ROOT'].'/uploads/'.$page_info['dropzone_image_table3']))
                    {
                        $Functions->deleteDir($_SERVER['DOCUMENT_ROOT'].'/uploads/'.$page_info['dropzone_image_table3']);
                    }

                }

                header("Location: ".$_SERVER['HTTP_REFERER']);

                //END ---- IF 2 LEVEL --- //
            }

            else if( $page_info['type'] == 7 )

            {
                // --- IF SIMPLE TEXT PAGE --- //
                //remove cpu
                $db->where('page_id', $page_info['id']);
                $db->where('elem_id', 0);
                $db->delete('cpu');

                $remove_page_info = $db
                    ->where('id', $id)
                    ->delete('pages', 1);

                //stergem fisierul din directouriul /text_page/
                if(isset($page_info['dir_file_name']) && !empty($page_info['dir_file_name']))
                {
                    unlink($_SERVER['DOCUMENT_ROOT'].'/text_page/'.$page_info['dir_file_name'].'.php');
                }
                // END:  --- IF SIMPLE TEXT PAGE --- //

                header("Location: ".$_SERVER['HTTP_REFERER']);
            }

            else if( $page_info['type'] == 10 )

            {
                // --- IF SIMPLE CP PAGE --- //
                //remove cpu
                $db->where('page_id', $page_info['id']);
                $db->where('elem_id', 0);
                $db->delete('cpu');

                $remove_page_info = $db
                    ->where('id', $id)
                    ->delete('pages', 1);

                //stergem fisierul din directouriul /cp/simple_page/
                if(isset($page_info['dir_file_name']) && !empty($page_info['dir_file_name']))
                {
                    unlink($_SERVER['DOCUMENT_ROOT'].'/cp/simple_page/'.$page_info['dir_file_name'].'.php');
                }
                // END:  --- IF SIMPLE CP PAGE --- //

                header("Location: ".$_SERVER['HTTP_REFERER']);
            }
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