<?php
namespace Models\Lists;

\Bitrix\Main\Loader::includeModule("crm");

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\StringField;
use Bitrix\Main\ORM\Fields\Validators\LengthValidator;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Fields\Relations\ManyToMany;

use Bitrix\Main\Entity\Query\Join;
use Bitrix\CRM\ContactTable;
use Models\Lists\DoctorsPropertyValuesTable as DocsTable;
use Models\Lists\DoctorsProcPropertyValuesTable as ProcTable;


class HospitalClientsTable extends DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'hospital_clients';
	}

	/**
	 * Returns entity map definition.
	 *
	 * @return array
	 */
	public static function getMap()
	{
		return [
			'id' => (new IntegerField('id',
					[]
				))->configureTitle(Loc::getMessage('CLIENTS_ENTITY_ID_FIELD'))
						->configurePrimary(true)
						->configureAutocomplete(true)
			,
			'first_name' => (new StringField('first_name',
					[
						'validation' => function()
						{
							return[
								new LengthValidator(null, 50),
							];
						},
					]
				))->configureTitle(Loc::getMessage('CLIENTS_ENTITY_FIRST_NAME_FIELD'))
			,
			'last_name' => (new StringField('last_name',
					[
						'validation' => function()
						{
							return[
								new LengthValidator(null, 50),
							];
						},
					]
				))->configureTitle(Loc::getMessage('CLIENTS_ENTITY_LAST_NAME_FIELD'))
			,			
			'age' => (new IntegerField('age',
					[]
				))->configureTitle(Loc::getMessage('CLIENTS_ENTITY_AGE_FIELD'))
			,
			'doctor_id' => (new IntegerField('doctor_id',
					[]
				))->configureTitle(Loc::getMessage('CLIENTS_ENTITY_DOCTOR_ID_FIELD'))
			,
			'procedure_id' => (new IntegerField('procedure_id',
					[]
				))->configureTitle(Loc::getMessage('CLIENTS_ENTITY_PROCEDURE_ID_FIELD'))
			,
			'contact_id' => (new IntegerField('contact_id',
					[]
				))->configureTitle(Loc::getMessage('CLIENTS_ENTITY_CONTACT_ID_FIELD'))
			,
'PROCEDURA' => (new Reference(
    'PROCEDURA',
    ProcTable::class,
    ['=this.procedure_id' => 'ref.IBLOCK_ELEMENT_ID'],
    ['join_type' => 'INNER']
)),
'DOCTORS' => (new Reference(
    'DOCTORS',
    DocsTable::class,
    ['=this.doctor_id' => 'ref.IBLOCK_ELEMENT_ID'],
    ['join_type' => 'INNER']
))
		];
	}
}