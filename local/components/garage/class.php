<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Models\Lists\GarageTable;

/**
 * GarageComponent
 */

class GarageComponent extends CBitrixComponent
{
   /* private function getColumn()
    {
        $fieldMap = GarageTable::getMap(); 
        $columns = [];
        foreach ($fieldMap as $key => $field) {
            $columns[] = array(
                'id' => $field->getName(),
                'name' => $field->getTitle(),
                'default' => true
            );
        }
        return $columns;
    }*/
    
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
                //'offset' =>$offset
            ]);
            while ($item = $data->fetch()) 
                {
                    $list[] = array('data' => $item); $i++;
                }
        }
        else
        {
            $user_id=\Bitrix\Main\Engine\CurrentUser::get()->getId();//Получаем ид пользователя
            $data = GarageTable::getList([
                "filter" => array("user_id" => $user_id),
                'select' => ['id', 'car_id','probeg','color','year','gos_number','AUTO.vendor','AUTO.model','AUTO.modification','AUTO.image'],
                
            ]);
            while ($item = $data->fetch()) 
                {
                    $list[] = array('data' => $item);
                    //\Bitrix\Main\Diag\Debug::dumpToFile($item,'Var','/test.log');
                }  
                          
        }


        return $list;
    }

    public function executeComponent()
    {
 
        //$this->arResult['COLUMNS'] = $this->getColumn(); // получаем названия полей таблицы
        $this->arResult['LISTS'] = $this->getList(); // получаем записи таблицы
        //$this->arResult['COUNT'] =  GarageTable::getCount(); // количество записей  
        //$this->arResult['user_id']= \Bitrix\Main\Engine\CurrentUser::get()->getUserGroups();//Получить массив групп текущего пользователя
        //$this->arResult['fields']=$this->Factory();
        $this->includeComponentTemplate();
    }
}