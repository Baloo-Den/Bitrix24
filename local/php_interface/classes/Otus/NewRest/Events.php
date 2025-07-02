<?php
namespace Otus\NewRest;

use Bitrix\Rest\RestException;
use Otus\OtusTable\OtusRestTable;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Context;
Loc::loadMessages(__FILE__);

class Events
{
    /**
     * @return array[]
     */

    public static function OnRestServiceBuildDescriptionHandler()
    {
        Loc::getMessage('REST_SCOPE_OTUS.CLIENTSDATA');

        return [
            'otus.clientsdata' => [
                'otus.clientsdata.add' => [__CLASS__, 'add'],
                'otus.clientsdata.list' => [__CLASS__, 'list'],
                'otus.clientsdata.update' => [__CLASS__, 'update'],
                'otus.clientsdata.delete' => [__CLASS__, 'delete'],
            ]
        ];
    }

    /**
     * @param $arParams
     * @param $navStart
     * @param \CRestServer $server
     * @return array|int
     * @throws RestException
     */

    public static function add($arParams, $navStart, \CRestServer $server)
    {
        $clientsData = OtusRestTable::add($arParams);//Добавление нового элемента

        if($clientsData->isSuccess())//Если элемент добавился
        {
            $id = $clientsData->getId();

            return $id;//Возвращаем его идешник
        }
        else
        {
            throw new RestException(json_encode($clientsData->getErrorMessages(), JSON_UNESCAPED_UNICODE), RestException::ERROR_ARGUMENT, \CRestServer::STATUS_OK);
        }

    }

    /**
     * @param $arParams
     * @param $navStart
     * @param \CRestServer $server
     * @return array
     * @throws RestException
     */

    public static function list($arParams, $navStart, \CRestServer $server)//Получения списка
    {

        if (!empty($arParams)) //Если $arParams не пустой, делаем запрос c пришедшими данными
        {
            $arFilter = isset($arParams['filter']) ? $arParams['filter'] : [];
            $arSelect = isset($arParams['select']) ? $arParams['select'] : [];
            $arOrder = isset($arParams['order']) ? $arParams['order'] : [];
            $arLimit = isset($arParams['limit']) ? $arParams['limit'] : [];

            foreach ($arFilter as &$filter) 
            {
                $filter = htmlspecialchars($filter);
                $filter = trim($filter);
            }
        try {
            $result = OtusRestTable::getList([//Получаем список с учётом $arParams
                'filter' => $arFilter,
                'select' => $arSelect,
                'order' => $arOrder,
                'limit' => $arLimit,
                'offset' => $navStart
            ])->fetchAll();
        } catch (\Exception $e) 
            {
                throw new RestException(json_encode($e->getMessage(), JSON_UNESCAPED_UNICODE), RestException::ERROR_ARGUMENT, \CRestServer::STATUS_OK);
            }
        } else 
        {
          try 
          {
            $result = OtusRestTable::getList([//Если входных данных нет, выдаём полный список
                'select' => array("ID", "NAME"), 
             ])->fetchAll();
            } catch (\Exception $e) 
            {
                throw new RestException(json_encode($e->getMessage(), JSON_UNESCAPED_UNICODE), RestException::ERROR_ARGUMENT, \CRestServer::STATUS_OK);
            }         
        }
        return $result;
    }

    /**
     * @param $arParams
     * @param $navStart
     * @param \CRestServer $server
     * @return true
     * @throws RestException
     */
    public static function update($arParams, $navStart, \CRestServer $server)//Апдейт элемента
    {
        // Проверка идешника
        if (empty($arParams['ID'])) {
            throw new RestException(Loc::getMessage('UPDATE_ID_REQUIRED'), RestException::ERROR_ARGUMENT, \CRestServer::STATUS_OK); 
        }

        $id = $arParams['ID'];
        unset($arParams['ID']); 

       
        $result = OtusRestTable::update($id, $arParams); // Обновляем элемент в таблице

        if ($result->isSuccess()) {
            return true;
        } else {
            throw new RestException(
                json_encode($result->getErrorMessages(), JSON_UNESCAPED_UNICODE),
                RestException::ERROR_ARGUMENT,
                \CRestServer::STATUS_OK
            );
        }
    }

    /**
     * @param $arParams
     * @param $navStart
     * @param \CRestServer $server
     * @return true
     * @throws RestException
     */

    public static function delete($arParams, $navStart, \CRestServer $server) //Удаление элемента
    {
        if (empty($arParams['ID'])) {
            throw new RestException(Loc::getMessage('DELETE_ID_REQUIRED'), RestException::ERROR_ARGUMENT, \CRestServer::STATUS_OK);
        }
        
        $result = OtusRestTable::delete($arParams['ID']);// Удаляем элемент из таблицы

        if ($result->isSuccess()) {
            return true; 
        } else {
            throw new RestException(
                json_encode($result->getErrorMessages(), JSON_UNESCAPED_UNICODE),
                RestException::ERROR_ARGUMENT,
                \CRestServer::STATUS_OK
            );
        }
    }

}