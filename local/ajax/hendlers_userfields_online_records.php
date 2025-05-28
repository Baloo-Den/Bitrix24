<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_admin_before.php';

// Получение текущего запроса
$request = Bitrix\Main\Context::getCurrent()->getRequest();

// Проверка, является ли запрос POST 
if ($request->isPost()) {
    // Получение данных из POST-запроса
    $postData = $request->getPostList()->toArray();


    $path = $_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/classes/Otus/Handlers/log.txt';
    //addFileLog(json_encode($postData, JSON_UNESCAPED_UNICODE), $path);

    \Bitrix\Main\Loader::includeModule('iblock');

    $newDate = str_replace('T', ' ', $postData['TIME']) . ":00";

    \Bitrix\Iblock\Iblock::wakeUp(18)->getEntityDataClass();//Проверяем, есть ли у данного врача в данное время пациент
    // Запрос в класс ORM
    $res = \Bitrix\Iblock\Elements\ElementbookingTable::getList( [
        'select' => ['ID'],
        'filter' =>array( ['DOCTORS_TIME.VALUE' => $postData['DOKTOR_ID']],['BOOKING_TIME.VALUE' => $newDate]),
    ])->fetchAll();
    if (count($res)>0) 
    {
        echo "Это время занято. Выберите, пожалуйста, другое."; 
        exit;
    }
       //Конец поиска

    $el = new CIBlockElement();
    
    $prop = [
        'BOOKING_TIME' => $newDate,
        'TIME_PROC' => $postData['PROC_ID'],
        'DOCTORS_TIME' => $postData['DOKTOR_ID'],
        'FIO_PROC' => $postData['NAME'],
    ];

    $arLoadProductArray = [
        'IBLOCK_ID' => 18,
        'PROPERTY_VALUES' => $prop,
        'NAME' => $postData['NAME'],
        'ACTIVE' => 'Y', // активен
    ];

    //addFileLog(json_encode($arLoadProductArray, JSON_UNESCAPED_UNICODE), $path);

    if($PRODUCT_ID = $el->Add($arLoadProductArray))//Добавляем запись в бронирование 
    {
        //echo 'New IDs: '.$PRODUCT_ID;
        echo 1;
    } else {
        echo 'Error: '.$el->LAST_ERROR;
    }
}
