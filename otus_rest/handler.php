<?php
//require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
//require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
require_once(__DIR__ . '/CRest/crest.php');
/*CEventLog::Add(array(
         "SEVERITY" => "SECURITY",
         "AUDIT_TYPE_ID" => "MY_OWN_TYPE",
         "MODULE_ID" => "main",
         "ITEM_ID" => 123,
         "DESCRIPTION" => 1111111,//var_dump($_REQUEST),
      ));*/
file_put_contents('log.log', '1234');
//\Bitrix\Main\Diag\Debug::dumpToFile($_REQUEST,'Var','/test.log');

//($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");