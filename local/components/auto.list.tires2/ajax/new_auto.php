<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');//Обязательная строка инициирующая движок Битрикса, но не подключающая шаблон

use Bitrix\Main\Loader;
use Models\Lists\GarageTable;
use Otus\Garage\GarageFactory;
if (! defined ( "B_PROLOG_INCLUDED" ) || B_PROLOG_INCLUDED !== true) die ();
$baseName = 'auto_carmodels';
global $DB;
//var_dump($_REQUEST);exit;
//Получаем ай-ди машины
$strsql = 'SELECT id FROM '.$baseName.' WHERE vendor = "'.$_REQUEST["car"].'" AND model = "'.$_REQUEST["model"].'" AND "'.$_REQUEST["year"].'" BETWEEN beginyear AND endyear and modification = "'.$_REQUEST["modification"].'"';

$res = $DB->Query($strsql, false, $err_mess.__LINE__);
while($car = $res->fetch())
    $car_id=$car['id'];
//var_dump($_REQUEST);exit;
$sats=GarageFactory::searchAvtoToService($_REQUEST["id"],'boss');//Ищем в неоконченных сделках
if ($sats===false)
{
    echo 'Машина уже в сервисе!';
    exit;
}
//var_dump($sats);
if ($_REQUEST["gos_number"])
{
    $user_id=\Bitrix\Main\Engine\CurrentUser::get()->getId(); // \Bitrix\Main\Engine\CurrentUser::get()->getUserGroups();//Получить массив групп текущего пользователя
    $result = Models\Lists\GarageTable::add(array( // Добавление новой записи
        'id' =>'',
        'car_id' => $car_id,
        'user_id' => $user_id,
        'probeg' => $_REQUEST["probeg"],
        'color' => $_REQUEST["color"],
        'year'=> $_REQUEST["year"],
        'gos_number'=> $_REQUEST["gos_number"],
    ));

    if ($result->isSuccess()) {
        $id = $result->getId();
        //echo "Запись успешно добавлена с ID: ".$id;
        $new_avto=GarageFactory::createDeal($id);//Создаём сделку
        if ($result->isSuccess())
        {
            echo 'Машина добавлена в Ваш гараж и отправлена на обслуживание.';
            exit;
            return;
        }
            
    } 
        else 
            {
                $errors = $result->getErrors();
                foreach ($errors as $error) {
                    echo "Ошибка: ".$error->getMessage()."<br>";
                }
            }
}
else 
{
    $new_avto=GarageFactory::createDeal($_REQUEST["id"]);//Создаём сделку
    //if ($result->isSuccess())
        echo 'Машина отправлена на обслуживание.';  

     exit;
}

?>