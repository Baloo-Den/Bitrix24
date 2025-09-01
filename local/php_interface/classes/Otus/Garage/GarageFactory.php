<?php
namespace Otus\Garage;

use Bitrix\Crm\Service;
use Bitrix\Crm\Service\Container;
use Bitrix\Crm\Model\Dynamic\TypeTable;
use Bitrix\Crm\Integration\CRM;
use Bitrix\Crm\DealTable;
use Bitrix\Crm\Item;
use Otus\Garage\GarageProducts;

/**
 * GarageFactory
 */

class GarageFactory
{
    public static function getAllFields()
    {
        if(\Bitrix\Main\Loader::includeModule('crm'))
        $factory = Container::getInstance()->getFactory(\CCrmOwnerType::Deal);
        if ($factory)
        {
        $fields = $factory->getFieldsCollection();
         foreach ($fields as $fieldCode => $field)
         {
            $fields_array[$field->getTitle()]=$field->getName();
         }
         return $fields_array;
        }
    } 

    /**
     * createDeal
     *
     * @param  mixed $id_avto, $products
     * @return void
     */

    public static function createDeal($id_avto, $products)
    {
        if(\Bitrix\Main\Loader::includeModule('crm'))
        $factory = Container::getInstance()->getFactory(\CCrmOwnerType::Deal);
        if ($factory)
        {
            $item = $factory->createItem();//создать элемент
            // Заполняем поля сделки
            $item->set('TYPE_ID', 1);//Воронка
            $item->set('title', 'Машина в сервис');//Заголовок сделки
            $item->set('CATEGORY_ID', 1); //Направление сделки
            $item->set('STAGE_ID', 'C1:NEW'); //Стадия сделки 
            $item->set('CONTACT_IDS', $_SESSION ["id_user_avto"]); //
            $item->set('ASSIGNED_BY_ID', 9);//Ответственным ставим Васечкинa
            $item->set('CURRENCY_ID', 'RUB');//Валюта
            $item->set('UF_ID_AVTO', $_SESSION['id_avto']); // Пoльзовательское поле
            $item->set('UF_INIZIATOR', 'New service'); //Сделка создана из обслуживания авто 
            $item->setProductRowsFromArrays($products);//Товары выбранные покупателем
            $context = new \Bitrix\Crm\Service\Context();
            $operation = $factory->getAddOperation($item, $context);  //добавление, $context- необязателен
            $operation->disableAllChecks(); //можно отключить проверки
            $result = $operation->launch();   // Сохраняем сделку   
            if ($result)       
                return true;
            else
                return false;
        }
    }

    /**
     * createDealForPurchases
     *
     * @param  mixed $id_products
     * @return void
     */

    public static function createDealForPurchases($id_products)
    {
        if(\Bitrix\Main\Loader::includeModule('crm'))
        $factory = Container::getInstance()->getFactory(\CCrmOwnerType::Deal);
        if ($factory)
        {
            $item = $factory->createItem();//создать элемент
            // Заполняем поля сделки
            $item->set('TYPE_ID', 4);//Воронка
            $item->set('title', 'Закончился товар');//Заголовок сделки
            $item->set('CATEGORY_ID', 4); //Направление сделки
            $item->set('STAGE_ID', 'C1:NEW'); //Стадия сделки 
            $item->set('UF_INIZIATOR', 'Zero products'); //
            $products = [
                            [
                                'PRODUCT_ID' => $id_products["ID"],
                                'QUANTITY' => 0,
                                //'PRICE' => $price,
                            ]
                        ];
            $item->setProductRowsFromArrays($products);//Товары выбранные покупателем
            $context = new \Bitrix\Crm\Service\Context();
            $operation = $factory->getAddOperation($item, $context);  //добавление, $context- необязателен
            $operation->disableAllChecks(); //можно отключить проверки
            $result = $operation->launch();   // Сохраняем сделку   
            if ($result)       
                return true;
            else
                return false;
        }
    }
              
    /**
     * getDeal
     *
     * @param  mixed $id
     * @return void
     */

    public static function getDeal($id)
    {
          if(\Bitrix\Main\Loader::includeModule('crm'))
        $factory = Container::getInstance()->getFactory(\CCrmOwnerType::Deal);
        if ($factory)
        {
            $item = $factory->getItem($id);
            $data=$item->getData();
            return $data;
        }      
    }
        
    /**
     * searchAvtoToService
     *
     * @param  mixed $id_avto
     * @param  mixed $dest
     * @return void
     */

    public static function searchAvtoToService($id_avto, $dest)
    {
          if(\Bitrix\Main\Loader::includeModule('crm'))
        $factory = Container::getInstance()->getFactory(\CCrmOwnerType::Deal);
        if ($factory)
        {
        switch ($dest) 
            {
                case 'boss':
                {
                        $items = $factory->getItems([
                    "filter"=>[
                        "UF_ID_AVTO"=>$id_avto,
                        ],
                        "select"=>["STAGE_ID"],
                        'limit'=>1000,
                        'offset' =>0
                    ]);            
                    foreach($items as $item)
                    {
                        if ($item["STAGE_ID"]=='C1:EXECUTING' || $item["STAGE_ID"]=='C1:NEW')
                            return  false;
                        else
                            return true;
                    }
                }
                    break;
                case 'all':
                { 
                        $items = $factory->getItems([
                    "filter"=>[
                        "UF_ID_AVTO"=>$id_avto,
                        ],
                        "select"=>["ID"],
                        'limit'=>1000,
                        'offset' =>0
                    ]);            
                    foreach($items as $item)
                    {
                       
                        $arr[]=$item["ID"];
                    }  
                    return  $arr; 
                }                 
                    break; 
            }           

        }  
        return  $arr;     
    }  
        
    /**
     * getTimeline
     *
     * @param  mixed $id
     * @return void
     */
    
    public static function  getTimeline($id) 
    {
        \Bitrix\Main\Loader::includeModule('crm');

        $obTimeLineEntity = \Bitrix\Crm\Timeline\Entity\TimelineTable::getList(array(
        'order' => array("CREATED" => "DESC"), 
        'filter' => array(
        'ASSOCIATED_ENTITY_ID' => $id,
        ),
        'limit' => 100,
        'select' => array("*"),
        ));
        while($arFields = $obTimeLineEntity->fetch()) 
        {
            $timeline[]=$arFields;
        }  
        return $timeline;      
    } 
}