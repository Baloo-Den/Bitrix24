<?php

namespace Otus\Garage;

use Bitrix\Main\Event;
use Bitrix\Main\EventResult;
use Bitrix\Main\Loader;

Loader::includeModule('crm');

/**
 * Менеджер для работы со вкладками сущностей CRM
 */
class CrmTabs {
    public static function setCustomTabs(Event $event): EventResult
    {
        $tabs = $event->getParameter('tabs');
        // ID текущего элемента СРМ
        $entityID = $event->getParameter('entityID');
        // ID типа сущности: Сделка, Компания, Контакт и т.д.
        $entityTypeID = $event->getParameter('entityTypeID');

        // Проверяем, что открыта карточка именно Сделки
        if($entityTypeID == \CCrmOwnerType::Deal) {
            $tabs[] = [
                'id' => 'garage',
                'name' => 'Гараж',
                'loader' => [
                    'serviceUrl' => '/local/components/auto.list.tires2/start_my_tab.php',
                    'componentData' => [
                        'template' => '',
                        'params' => []
                    ]
                    ],
                    'sort' => 200, // Позиция вкладки в списке
            ];
        }

        // Возвращаем модифицированный массив вкладок
        return new \Bitrix\Main\EventResult(\Bitrix\Main\EventResult::SUCCESS, [
            'tabs' => $tabs,
        ]);
    }
}
