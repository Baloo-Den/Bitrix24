<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Otus\Homework\OtusEntityTable;

class OtusHomeworkOtusGrid extends CBitrixComponent
{

    private function getColumn()
    {
        $fieldMap = OtusEntityTable::getMap(); 
        $columns = [];
        foreach ($fieldMap as $key => $field) {
            $columns[] = array(
                'id' => $field->getName(),
                'name' => $field->getTitle(),
                'default' => true
            );
        }
        return $columns;
    }

    private function getList()
    {

        $offset = $limit * ($page-1);
        $list = [];
        $data = OtusEntityTable::getList([
            //'select' => ['ID','UF_NAME','UF_LASTNAME','UF_PHONE','UF_JOBPOSITION','UF_SCORE'],
            'order' => ['ID' => 'ASC'],
            //'limit' => $limit,
            //'offset' =>$offset
        ]);
        
        while ($item = $data->fetch()) {
            $list[] = array('data' => $item);
        }

        return $list;
    }
    
    public function executeComponent()
    {
        if (!Loader::includeModule("otus.homework")) {
            ShowError("Модуль otus.homework не установлен");
            return;
        }
       
        $this->arResult['COLUMNS'] = $this->getColumn(); // получаем названия полей таблицы
        $this->arResult['LISTS'] = $this->getList(); // получаем записи таблицы
        $this->arResult['COUNT'] =  OtusEntityTable::getCount(); // количество записей          

        $this->includeComponentTemplate();
    }
}
