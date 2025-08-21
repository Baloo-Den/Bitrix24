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
     * @param  mixed $id_avto
     * @return void
     */

    public static function createDeal($id_avto)
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
            $item->set('ASSIGNED_BY_ID', 9);//Ответственным ставим Васечкинa
            $item->set('OPPORTUNITY', 10000); // Сумма
            $item->set('CURRENCY_ID', 'RUB');//Валюта
            $item->set('UF_ID_AVTO', $id_avto); // ПОльзовательское поле
            $arr_id= array(26917,26919);
            $tovar=GarageProducts::getAllPrices($arr_id);//Получаем цены для товаров            
            $products = [['PRODUCT_ID' => 26917,'QUANTITY' => 4, 'PRICE'=>$tovar[26917]], ['PRODUCT_ID' => 26919,'QUANTITY' => 1, 'PRICE'=>$tovar[26919] ]];
            $item->setProductRowsFromArrays($products);//Товары выбранные покупателем
            $context = new \Bitrix\Crm\Service\Context();
            //$user_id=\Bitrix\Main\Engine\CurrentUser::get()->getId();
            //$context->setUserId($user_id);  //ставим юзера, из-под которого делаем
            $operation = $factory->getAddOperation($item, $context);  //добавление, $context- необязателен
            $operation->disableAllChecks(); //можно отключить проверки
            $result = $operation->launch();   // Сохраняем сделку           
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
     //\Bitrix\Main\Diag\Debug::dumpToFile($id_avto,'Var','/test.log');
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
                            \Bitrix\Main\Diag\Debug::dumpToFile($item["ID"],'Var','/test.log');
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
        //'ASSOCIATED_ENTITY_TYPE_ID' => 1,
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