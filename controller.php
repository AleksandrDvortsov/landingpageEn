<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/cp/class/include.php';
//защита от иньекций
//$CCpu->inject();
$pageData = $Cpu->GetCPU();
$exploded_url = explode("?", $_SERVER['REQUEST_URI']);


if(!$pageData)
{
    header('HTTP/1.0 404 Not Found');
    include($_SERVER['DOCUMENT_ROOT']."/404.php");
    exit;
}
elseif($pageData==301){
    header('HTTP/1.1 301 Moved Permanently');
    if(isset($exploded_url[1]) && $exploded_url[1]!="")
    {
        header("Location: ".$exploded_url[0]."/?".$exploded_url[1]);
    }
    else
    {
        header("Location: ".$exploded_url[0]."/");
    }
    exit;
}

$Main->lang = $pageData['lang'];
// Массив словаря для текущего языка
$GLOBALS['ar_define_langterms'] = $Main->GetDefineLangTerms();
$_SESSION['last_lang'] = $pageData['lang'];

$page_data = $Cpu->GetPageData($pageData);

if(!$page_data)
{
    $Cpu->page404();
}

// cutpageinfo - вспомогательный массив для вывода блока с хлебными крошками, названием странице и автоматической генерации кнопки назад
$cutpageinfo = array('cpu' => $pageData['cpu'], 'title' => $page_data['title'], 'lang' => $Main->lang);
$lang = $Main->lang;


 
include($_SERVER['DOCUMENT_ROOT'].$pageData['page']);
exit();
