<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
use Bitrix\Sale;
use Otus\Garage\GarageFactory;

$APPLICATION->SetTitle("Оформление");

$sats=GarageFactory::searchAvtoToService($_SESSION['id_avto'],'boss');//Ищем в неоконченных сделках
if ($sats===false)
{
    echo 'Машина уже в сервисе!';
    exit;
}

$products= array();

$basket = Sale\Basket::loadItemsForFUser(Sale\Fuser::getId(), Bitrix\Main\Context::getCurrent()->getSite());//Получаем корзину для текущего пользователя
$basketItems = $basket->getBasketItems();//Получаем товары в корзине
foreach ($basket as $basketItem) 
    {
        $products[]=['PRODUCT_ID' => $basketItem->getField('PRODUCT_ID'), 'QUANTITY' => $basketItem->getQuantity(), 'PRICE' => $basketItem->getPrice()];
    }
        $new_avto=GarageFactory::createDeal($id,$products);//Создаём сделку
        if ($new_avto)
        {
            CSaleBasket::DeleteAll(CSaleBasket::GetBasketUserID());//Очищаем корзину
            echo 'Машина отправлена на обслуживание.';
            exit;
        }

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");