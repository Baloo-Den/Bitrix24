<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');//Обязательная строка инициирующая движок Битрикса, но не подключающая шаблон
use Otus\Garage\GarageProducts;
use Bitrix\Catalog\ProductTable;


if ($_GET['destination']==='new_avto')//Компонент, выводящий форму нового авто
{
    $APPLICATION->IncludeComponent(
        'bitrix:ui.sidepanel.wrapper',
        '',
        [
            'POPUP_COMPONENT_NAME' => 'auto.list.tires2',
            'POPUP_COMPONENT_TEMPLATE_NAME' => '',
            'POPUP_COMPONENT_PARAMS' => [
                        ],
        ]
    ); 
}
 


