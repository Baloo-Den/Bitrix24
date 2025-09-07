<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');//Обязательная строка инициирующая движок Битрикса, но не подключающая шаблон
use Otus\Garage\GarageProducts;

$products=GarageProducts::getAllProducts();
foreach ($products as $id)
{
    $int=GarageProducts::getRnd();//Получаем случайное число
    $update=GarageProducts::updateProduct($id, $int);//Меняем количество на складе

     if ($update)
     {
        GarageProducts::logProducts($id, $int);//Логируем
     }
}