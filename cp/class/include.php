<?php
// Ultima editare a panoului administrativ: 25.06.2018 10:00 - Lemnaru Alexandru
session_start();
 
error_reporting (0);
@ini_set('display_errors', 0);


//error_reporting (E_ALL);
date_default_timezone_set('Europe/Chisinau');

$SERVER_NAME = "localhost";
$DB_LOGIN = "root";
$DB_PASS = "parolatemporara";
$DB_NAME = "amc";


/*
$SERVER_NAME = "localhost";
$DB_LOGIN = "root";
$DB_PASS = "";
$DB_NAME = "amc";
*/

require_once $_SERVER['DOCUMENT_ROOT'].  '/cp/class/MysqliDb.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/cp/class/MLI.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/cp/class/CPU.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/cp/class/User.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/cp/class/Validator.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/cp/class/Form.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/cp/class/HelpFunctions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/cp/class/Token.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/cp/class/Logger.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/cp/class/functions.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/cp/class/ERP.php';

$db = new MysqliDb($SERVER_NAME, $DB_LOGIN, $DB_PASS, $DB_NAME);
$db->setPrefix ('d_');
$Main = new MLI($db);
$validator = new Validator();
$Token = new Token();

$Functions = new HelpFunctions();
// Массив с стандартными настройками сервера
$GLOBALS['ar_define_settings'] = $Main->GetDefineSettings();
//Массив со всеми языками сайта
$list_of_site_langs = explode(',', $GLOBALS['ar_define_settings']['LANG_SITE']);
$Cpu = new CPU();
$Form = new Form();
$User = new User();
$Erp = new ERP();

// Доступы к файлам
// !!!!!НЕ РЕДАКТИРОВАТЬ!!!!!
$developer_access = array(1);
$client_access = array(1,2);
$user_access = array(1,2,5);
$manager_access = array(1,3);
$only_manager_access = array(3);

// css version
$css_version = uniqid();

$http_referer = (isset($_SERVER['HTTP_REFERER']) ? base64_encode($_SERVER['HTTP_REFERER']) : base64_encode('local_host'));
$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$host_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
$current_time = new DateTime( 'NOW' );
//reCaptcha config
//require_once $_SERVER['DOCUMENT_ROOT'] . '/libraries/recaptcha/config.php';
