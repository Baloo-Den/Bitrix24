<?php

namespace Otus\OtusTable;

use Bitrix\Main\Entity;
use Bitrix\Main\Localization\Loc;
use Bitrix\Rest\RestException;

Loc::loadMessages(__FILE__);

/*
 *Таблица созданная запросом:
 * CREATE TABLE rest_table (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    NAME VARCHAR(255) NOT NULL
);
  */

class OtusRestTable extends Entity\DataManager
{
    /**
     * @return string
     */
    public static function getTableName(): string
    {
        return 'rest_table';
    }

    /**
     * @return array
     */
    public static function getMap(): array
    {
        return [
            new Entity\IntegerField('ID', [
                'primary' => true,
                'autocomplete' => true,
            ]),
            new Entity\StringField('NAME', [
                'required' => true,
            ]),
        ];
    }

    /**
     * @param $params
     * @return void
     * @throws RestException
     */
    public static function validateAdd($params): void
    {
        if (empty($params['NAME'])) {
            throw new RestException(Loc::getMessage("FIELD_IS_REQUIRED", ["#FIELD#" => 'NAME']), 0);
        }
    }

    /**
     * @param $params
     * @return void
     * @throws RestException
     */
    public static function validateUpdate($params): void
    {
        if (empty($params['ID'])) {
            throw new RestException(Loc::getMessage("FIELD_IS_REQUIRED", ["#FIELD#" => 'ID']), 0);
        }
        if (isset($params['NAME']) && empty($params['NAME'])) {
            throw new RestException(Loc::getMessage("FIELD_IS_REQUIRED", ["#FIELD#" => 'NAME']), 0);
        }
    }

    /**
     * @param $params
     * @return void
     * @throws RestException
     */
    public static function validateGet($params): void
    {
        if (empty($params['ID'])) {
            throw new RestException(Loc::getMessage("FIELD_IS_REQUIRED", ["#FIELD#" => 'ID']), 0);
        }
    }

    /**
     * @param $params
     * @return void
     * @throws RestException
     */
    public static function validateDelete($params): void
    {
        if (empty($params['ID'])) {
            throw new RestException(Loc::getMessage("FIELD_IS_REQUIRED", ["#FIELD#" => 'ID']), 0);
        }
    }

}
