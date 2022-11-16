<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/cp/class/include.php';

session_unset();
session_destroy();

header("location: ".$Cpu->getURL(5));