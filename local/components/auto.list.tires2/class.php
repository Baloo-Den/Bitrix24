<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Models\Lists\CarModelsTable as Car;

/**
 * AvtoListComponent
 */

class AvtoListComponent extends CBitrixComponent
{
    /**
     * getVendor
     *
     * @return void
     */
    
    private function getVendor()
    {
        $data = Car::getList([
            'select' => ['vendor'],
            'order' => ['vendor' => 'ASC'],
            'group' => array('vendor')
            ]);
        while ($item = $data->fetch()) 
            {
                $list[] = array( "NAME" => $item["vendor"] );
            }
        return $list;
    }

        /**
     * getMark
     *
     * @return void
     */
    
    private function getMark($mark)
    {  
        $data = Car::getList([
            "filter" => array("vendor" => $mark),
            'select' => ['model'],
            'order' => ['model' => 'ASC'],
            'group' => array('model')
            ]);
        while ($item = $data->fetch()) 
            {
                $list[] = array( "NAME" => $item["model"] );
            }
            
        return $list;
    } 

        /**
     * getYear
     *
     * @return void
     */
         
    private function getYear($mark, $model)  
    {
        $data = Car::getList([
            "filter" => array("vendor" => $mark, "model" => $model),
            'runtime' => array(new \Bitrix\Main\Entity\ExpressionField(
                'MIN',
                'MIN(%s)',
                ['beginyear']

            ),new \Bitrix\Main\Entity\ExpressionField(
                'MAX',
                'MAX(%s)',
                ['endyear']

            )),
            'select' => array('MIN','MAX'),            
            ]);
        while ($item = $data->fetch()) 
            {
                $year =  range($item['MIN'], $item['MAX']);
            }
            $list= array();
            foreach ($year as $el)
            {
                 $list[]['NAME']=$el;
            }
        return $list;
    }
    
        /**
     * getModification
     *
     * @return void
     */
    
    private function getModification($mark, $model, $year)
    {  
        $data = Car::getList([
            "filter" => array("vendor" => $mark, "model" => $model, ">=beginyear" => $year),
            'select' => ['modification'],
            'order' => ['modification' => 'ASC'],
            'group' => array('modification')
            ]);
        while ($item = $data->fetch()) 
            {
                $list[] = array( "NAME" => $item["modification"] );
            }
        return $list;
    } 
    public function executeComponent()
    {
        
        $this->arResult['CARS'] = $this->getVendor(); // получаем записи таблицы
        if(!empty($this->arParams['AUTO_MARK']))
            { 
                $this->arResult['MODEL'] = $this->getMark($this->arParams['AUTO_MARK']); //     
            }

        if(!empty($this->arParams['AUTO_MARK']) && !empty($this->arParams['AUTO_MODEL']))
            {
                $this->arResult['YEAR'] = $this->getYear($this->arParams['AUTO_MARK'], $this->arParams['AUTO_MODEL']);
            }      
        if(!empty($this->arParams['AUTO_MARK']) && !empty($this->arParams['AUTO_MODEL']) && !empty($this->arParams['AUTO_YEAR']))
        {
            $this->arResult['MODIFICATION'] = $this->getModification($this->arParams['AUTO_MARK'], $this->arParams['AUTO_MODEL'], $this->arParams['AUTO_YEAR']);
        }
        $this->includeComponentTemplate();
    }    
}