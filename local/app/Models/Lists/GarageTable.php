<?php
namespace Models\Lists;
use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\StringField;
use Bitrix\Main\ORM\Fields\Validators\LengthValidator;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Fields\Relations\ManyToMany;
use Bitrix\Main\Entity\Query\Join;
use Bitrix\Main\Localization\Loc;
use Models\Lists\CarModelsTable as Car;


class GarageTable extends DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'auto_users';
	}

	/**
	 * Returns entity map definition.
	 *
	 * @return array
	 */
	public static function getMap()
	{
		return [
			new IntegerField(
				'id',
				[
					'primary' => true,
					'autocomplete' => true,
					'title' => Loc::getMessage('USERS_ENTITY_ID_FIELD'),
				]
			),
			new IntegerField(
				'car_id',
				[
					'required' => true,
					'title' => Loc::getMessage('USERS_ENTITY_CAR_ID_FIELD'),
				]
			),
			new IntegerField(
				'user_id',
				[
					'required' => true,
					'title' => Loc::getMessage('USERS_ENTITY_USER_ID_FIELD'),
				]
			),
			new IntegerField(
				'probeg',
				[
					'required' => true,
					'title' => Loc::getMessage('USERS_ENTITY_PROBEG_FIELD'),
				]
			),
			new StringField(
				'color',
				[
					'required' => true,
					'validation' => function()
					{
						return[
							new LengthValidator(null, 255),
						];
					},
					'title' => Loc::getMessage('USERS_ENTITY_COLOR_FIELD'),
				]
			),
			new IntegerField(
				'year',
				[
					'required' => true,
					'title' => Loc::getMessage('CARMODELS_ENTITY_YEAR_FIELD'),
				]
			),	
			new StringField(
				'gos_number',
				[
					'required' => true,
					'validation' => function()
					{
						return[
							new LengthValidator(null, 256),
						];
					},
					'title' => Loc::getMessage('USERS_ENTITY_GOS_NUMBER_FIELD'),
				]
			),					
			'AUTO' => (new Reference(//Создаём виртуальное поле
				'AUTO',
				Car::class,
				['=this.car_id' => 'ref.id'],//Соответствие столбца car_id и столбца id таблицы автомобилей
				['join_type' => 'INNER']
			)),			
		];
	}
}
