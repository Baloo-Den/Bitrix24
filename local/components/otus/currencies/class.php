<?php
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Application,
    Bitrix\Main\Type\DateTime,
    Bitrix\Main\Loader,
    Bitrix\Main\SystemException;

class OtusCurrenciesComponent extends CBitrixComponent
{
    public function onPrepareComponentParams($arParams)
    {
       
        return $arParams;  // тут пишем логику обработки параметров, дополнение к параметрам по умолчанию
    }

    private function checkModules()
    {
        if(!Loader::includeModule('currency')){

            throw new \Exception("Не загружены модули необходимые для работы компонента");
        }
        return true;
    }

    private function getCurrentRate()
    {
        $currence =  $this->arParams['CURRENCY'];
        $result = Bitrix\Currency\CurrencyTable::getList([
            'select' => ['AMOUNT' , 'CURRENCY'],
            'filter' => ['NUMCODE' => $currence],
            'order' => ['SORT' => 'ASC']
        ])->fetch();
        return $result;
    }


    public function executeComponent()
    {
        try {
            $this->checkModules(); //проверяем подключение модулей
            $this->arResult['ARR_CURRENCY_RATE'] = $this->getCurrentRate();
            $this->includeComponentTemplate();//Подлключаем шаблон
        }
        catch (SystemException $e){
            ShowError($e->getMessage());
        }
    }












}