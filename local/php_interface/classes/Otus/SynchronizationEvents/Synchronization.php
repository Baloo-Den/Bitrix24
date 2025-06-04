<?php

namespace Otus\SynchronizationEvents;
use Bitrix\Main\Loader;
use Bitrix\Crm\DealTable;
use Bitrix\Crm\Service;
use Bitrix\Crm\Service\Container;
use Bitrix\Crm;

class Synchronization

{
    public static $iBlockID = 20;
    public static function OnAfterDealAdd(&$arFields) 
    {
        global $USER;
  
        Loader::requireModule('crm');
        Loader::includeModule('iblock');
        
        if($arFields["BLOCK_HANDLER"] == true){
            return $arFields;
        }

        if(!self::CheckExistElement($arFields['ID']))
        {
            
                $el = new \CIBlockElement;
                $PROP = [
                    "DEAL" => $arFields['ID'],
                    "SUMM" =>  $arFields['OPPORTUNITY'],
                    "RESPONSIBLE" => $arFields['ASSIGNED_BY_ID'],

                ];
                $elementData = Array(
                    "MODIFIED_BY"    => $USER->GetID(),
                    "IBLOCK_ID"=> self::$iBlockID,
                    'ACTIVE' => 'Y',
                    "PROPERTY_VALUES"=> $PROP,
                    "BLOCK_HANDLER" => true,
                    "NAME"           => 'Заявка созданная на основании сделки: '.$arFields['TITLE'] ,
                );
                //\Bitrix\Main\Diag\Debug::dumpToFile($arFields,'Var','/test.log');               
                $elementID = $el->Add($elementData);

                $deal = new \CCrmDeal(false);
                $arDealParams['UF_IBLOCK_ID_EL'] = $elementID;
            
            return false;
        }
    }

    public static function CheckExistElement($dealID){
       Loader::includeModule('iblock');
        $arSelect = Array("ID");
        $arFilter = Array("IBLOCK_ID"=>self::$iBlockID, "PROPERTY_DEAL"=>$dealID);
        $res = \CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>1), $arSelect);
        if($res->GetNextElement()){ 
            return true;
        }else{
            return false;
        }
    }

    public static function GetIdDeal($dealID){
       Loader::includeModule('iblock');
        $arSelect = Array("ID");
        $arFilter = Array("IBLOCK_ID"=>self::$iBlockID, "PROPERTY_DEAL"=>$dealID);
        $res = \CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>1), $arSelect);
        if($ob=$res->GetNextElement()){ 
            $arFields = $ob->GetFields(); 
            //\Bitrix\Main\Diag\Debug::dumpToFile($arFields,'Var','/test.log');
            return $arFields["ID"];
        }else{
            return false;
        }
    }

    public static function OnAfterDealUpdate(&$arFields) 
    {
        global $USER;

        Loader::requireModule('crm');
        Loader::includeModule('iblock');

        $id_deal=self::GetIdDeal($arFields['ID']);
        //\Bitrix\Main\Diag\Debug::dumpToFile($id_deal,'Var','/test.log');    
        if(!empty($id_deal))
        {
            $el = new \CIBlockElement;
            $PROP = [
                "DEAL" => $arFields['ID'],
                "SUMM" => $arFields['OPPORTUNITY'],
                "RESPONSIBLE" => $arFields['ASSIGNED_BY_ID'],
            ];
            $arLoadProductArray = Array(
                "MODIFIED_BY"    => $USER->GetID(),
                "PROPERTY_VALUES"=> $PROP,
                "BLOCK_HANDLER" => true,
            );

            $res = $el->Update($id_deal, $arLoadProductArray);
        }
    }

    public static function OnElementAfterUpdate(&$arFields)
    {

       Loader::includeModule('iblock');
        $arSelect = Array("PROPERTY_DEAL","PROPERTY_SUMM","PROPERTY_RESPONSIBLE");
        $arFilter = Array("IBLOCK_ID"=>self::$iBlockID, "PROPERTY_DEAL_VALUE"=>$arFields["ID"]);
        $res = \CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>1), $arSelect);
        if($ob=$res->GetNextElement()){ 
            $allFields = $ob->GetFields(); 
        }
        $factory = \Bitrix\Crm\Service\Container::getInstance()->getFactory(2);
        $item = $factory->getItem($allFields["PROPERTY_DEAL_VALUE"]);// ID сделки
        $fields['OPPORTUNITY'] =$allFields["PROPERTY_SUMM_VALUE"]; //сумма
        $fields['ASSIGNED_BY_ID'] =$allFields["PROPERTY_RESPONSIBLE_VALUE"];//ответсвенный

        $item->setFromCompatibleData($fields);
        $operation = $factory->getUpdateOperation($item);
        $operation->disableAllChecks();
        $result = $operation->launch();

    }

}