<?php
usleep(20000);
require_once $_SERVER['DOCUMENT_ROOT'].'/cp/class/include.php';
$ar_get_clean = filter_input_array(INPUT_GET, FILTER_SANITIZE_SPECIAL_CHARS);
$ar_post_clean = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);


$FileDirecotry = $_SERVER['DOCUMENT_ROOT'] . '/uploads/dropzone/temp_files/';

if($User->check_cp_authorization())
{

    if (!empty($_FILES))
    {
        $explodeCurentFile = explode('.', $_FILES['file']['name']);
        $end_file = end($explodeCurentFile);
        $file_name = uniqid() . "." . $end_file; // генерируем имя файла
        $targetPath = $FileDirecotry . $file_name;  // Target path where file is to be stored
        if (move_uploaded_file($_FILES['file']['tmp_name'], $targetPath))
        {
            echo json_encode($file_name);
        }

    }

}