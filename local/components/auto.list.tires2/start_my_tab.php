<?php

use Bitrix\Crm\Service\Container;
use Bitrix\Main\Application;
use Bitrix\Main\Config\Option;


require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true){
    die();
}

$APPLICATION->IncludeComponent(
    'auto.list.tires2',
    '',
    []
);

require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_after.php');
die();


