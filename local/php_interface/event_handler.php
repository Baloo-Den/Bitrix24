<?php
use Bitrix\Main;

$eventManager = Main\EventManager::getInstance();

//Вешаем обработчик на событие создания списка пользовательских свойств OnUserTypeBuildList
$eventManager->addEventHandler('iblock', 'OnIBlockPropertyBuildList', ['Otus\UserType\CUserTypeTimesheet', 'GetUserTypeDescription']);

//Новые RESTы
$eventManager->addEventHandlerCompatible('rest', 'OnRestServiceBuildDescription', ['Otus\NewRest\Events', 'OnRestServiceBuildDescriptionHandler']);

$eventManager->addEventHandler("crm", "OnAfterCrmDealAdd", ['Otus\SynchronizationEvents\Synchronization', 'OnAfterDealAdd']);
$eventManager->addEventHandler("crm", "OnAfterCrmDealUpdate", ['Otus\SynchronizationEvents\Synchronization', 'OnAfterDealUpdate']);
$eventManager->addEventHandler("iblock", "OnAfterIBlockElementUpdate", ['Otus\SynchronizationEvents\Synchronization', 'OnElementAfterUpdate']);

