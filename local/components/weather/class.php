<?php
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Application,
    Bitrix\Main\Type\DateTime,
    Bitrix\Main\Loader,
    Bitrix\Main\SystemException;

class WeatherComponent extends CBitrixComponent
{

    private function getCurrentRate()
    {
        $access_key = '57073dbc-7866-417f-b4b2-7b761a21f7c0';

        $opts = array(
          'http' => array(
            'method' => 'GET',
            'header' => 'X-Yandex-Weather-Key: ' . $access_key
          )
        );
        
        $context = stream_context_create($opts);
        
        $file = 
        file_get_contents('https://api.weather.yandex.ru/v2/forecast?lat=52.37125&lon=4.89388', 
        false, $context);
        
        //var_dump ($file);
        $f=json_decode($file);
        $t=$f->fact;
        return $t;
    }


    public function executeComponent()
    {
        try {
            $this->arResult['WEATHER'] = $this->getCurrentRate();
            $this->includeComponentTemplate();//Подключаем шаблон
        }
        catch (SystemException $e){
            ShowError($e->getMessage());
        }
    }












}