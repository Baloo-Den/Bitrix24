<?php
namespace Otus\Homework;

use Bitrix\Main\Entity;
class OtusEntityTable extends Entity\DataManager
{
    public static function getTableName(): string
    {
        return 'client_lists';
    }

    public static function getMap(): array
    {
        return [
            new Entity\IntegerField('ID', ['primary' => true, 'autocomplete' => true]),
            new Entity\StringField('UF_NAME', ['required' => true]),
            new Entity\StringField('UF_LASTNAME', ['required' => true]),
            new Entity\StringField('UF_PHONE', ['required' => true]),
            new Entity\StringField('UF_JOBPOSITION', ['required' => true]),
            new Entity\StringField('UF_SCORE', ['required' => true]),
        ];
    }
}
