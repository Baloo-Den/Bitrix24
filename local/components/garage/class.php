<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Models\Lists\GarageTable;

/**
 * GarageComponent
 */

class GarageComponent extends CBitrixComponent
{
  
    /**
     * getList
     *
     * @return void
     */
    
    private function getList()
    {
        $group=getGroupUser();
        if($group)
        {
             
            $data = GarageTable::getList([
                'select' => ['id', 'car_id','probeg','color','year','gos_number','AUTO.vendor','AUTO.model','AUTO.modification','AUTO.image'],
                'order' => ['id' => 'ASC'],
                'limit' => 1000,
            ]);
            while ($item = $data->fetch()) 
                {
                    $list[] = array('data' => $item); $i++;
                }
        }
        else
        {
            $user_id=getIdUserFromUrl();
            $data = GarageTable::getList([
                "filter" => array("user_id" => $user_id),
                'select' => ['id', 'car_id','probeg','color','year','gos_number','AUTO.vendor','AUTO.model','AUTO.modification','AUTO.image'],
                
            ]);
            while ($item = $data->fetch()) 
                {
                    $list[] = array('data' => $item);
                }  
                          
        }


        return $list;
    }

    public function executeComponent()
    {
 
        $this->arResult['LISTS'] = $this->getList(); // получаем записи таблицы
        $this->includeComponentTemplate();
    }
}