<?php

use Bitrix\Main\Page\Asset;

\CJSCore::RegisterExt("OtusWorkingDay", array(
    "js" => "\local\js\script.js",
    "css" => "",
    "rel" => array(),
));//Подключаем свои скрипты

\CJSCore::Init(['OtusWorkingDay']); // Инициализация скрипта  рабочего дня