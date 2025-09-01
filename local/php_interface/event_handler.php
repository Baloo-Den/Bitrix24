<?php
use Bitrix\Main;
use Otus\Garage\GarageFactory;

$eventManager = Main\EventManager::getInstance();

//Вешаем обработчик на событие создания списка пользовательских свойств OnUserTypeBuildList
$eventManager->addEventHandler('iblock', 'OnIBlockPropertyBuildList', ['Otus\UserType\CUserTypeTimesheet', 'GetUserTypeDescription']);

$eventManager->addEventHandler("crm", "OnAfterCrmDealAdd", ['Otus\SynchronizationEvents\Synchronization', 'OnAfterDealAdd']);
$eventManager->addEventHandler("crm", "OnAfterCrmDealUpdate", ['Otus\SynchronizationEvents\Synchronization', 'OnAfterDealUpdate']);
$eventManager->addEventHandler('crm', 'onEntityDetailsTabsInitialized', ['\Otus\Garage\CrmTabs','setCustomTabs',]);
$eventManager->addEventHandler('catalog', '\Bitrix\Catalog\Product::onAfterUpdate', 'myUpdateProtuct');

function myUpdateProtuct(\Bitrix\Main\ORM\Event $event)
{
     $parameters = $event->getParameters();
     $id = $event->getParameter("id");
     if(!array_key_exists('TYPE', $parameters['fields'] ) && $parameters['fields']['QUANTITY'] == 0)
        {
            GarageFactory::createDealForPurchases($id);//Создаём сделку
        }
    
}



