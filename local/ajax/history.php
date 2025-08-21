<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');//Обязательная строка инициирующая движок Битрикса, но не подключающая шаблон

use Bitrix\Main\Loader;
use Otus\Garage\GarageFactory;

$id_deal=GarageFactory::searchAvtoToService($_REQUEST['id'],'all');//Выцепить ид сделок по ид авто
//var_dump($_REQUEST);
$timeline=GarageFactory::getTimeline($id_deal,'all');//Выцепить историю
foreach ($timeline as $key=>$value)
{
    foreach ($value as $key1=>$value1)
    {
        echo $key1.'-'.$value1.'<BR>';
        
    }
}
exit;