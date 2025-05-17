<?php

use Bitrix\Main\Page\Asset;

CJSCore::RegisterExt(
	"my_extension", 
	array(
		"js" =>"\..\..\js\script.js"
	)
);// Регистрация скриптов


CJSCore::Init(['startWorkingDay']); // Инициализация скрипта  рабочего дня