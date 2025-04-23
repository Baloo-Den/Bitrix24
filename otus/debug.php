<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
use \Bitrix\Main\Diag\Debug;
$date = date("d.m.Y G:i:s");
Debug::writeToFile($date, $varName = "", $fileName = "/logs/task_1.log");
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");