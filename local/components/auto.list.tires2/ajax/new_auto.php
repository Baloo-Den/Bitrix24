<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');//Обязательная строка инициирующая движок Битрикса, но не подключающая шаблон
use Bitrix\Main\Loader;
use Models\Lists\GarageTable;
use Otus\Garage\GarageFactory;
use Models\Lists\CarModelsTable as Car;

if (! defined ( "B_PROLOG_INCLUDED" ) || B_PROLOG_INCLUDED !== true) die ();


$data = Car::getList([
    "filter" => array("vendor" => $_REQUEST["car"], "model" => $_REQUEST["model"], ">=beginyear" => $year, "modification" =>$_REQUEST["modification"] ),
    'select' => ['id'],
     ]);
while ($item = $data->fetch()) 
     $car_id = $item['id'];

if ($_REQUEST["gos_number"])
{
    $user_id=getIdUserFromUrl();
    $result = Models\Lists\GarageTable::add(array( // Добавление новой записи
        'id' =>'',
        'car_id' => $car_id,
        'user_id' => $_SESSION['id_user_avto'],
        'probeg' => $_REQUEST["probeg"],
        'color' => $_REQUEST["color"],
        'year'=> $_REQUEST["year"],
        'gos_number'=> $_REQUEST["gos_number"],
    ));

    if ($result->isSuccess()) 
        {
             echo 'Машина добавлена в Ваш гараж';
                    
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
    //$new_avto=GarageFactory::createDeal($_REQUEST["id"]);//Создаём сделку
    //if ($result->isSuccess())
        echo 'Машина отправлена на обслуживание.';  

     exit;
}

?>