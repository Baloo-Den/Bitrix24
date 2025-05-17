<?php

use Bitrix\Main\Page\Asset;

CJSCore::RegisterExt(
	"my_extension", 
	array(
		"js" =>"\..\..\js\script.js",
        'css' => '',
        'rel' => array(),		
	)
);// Регистрация скриптa


CJSCore::Init(['startWorkingDay']); // Инициализация скрипта  рабочего дня