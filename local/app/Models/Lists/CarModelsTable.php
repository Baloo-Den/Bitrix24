<?
namespace Models\Lists;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\FloatField;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\StringField;
use Bitrix\Main\ORM\Fields\Validators\LengthValidator;

/**
 * Class CarmodelsTable
 * 
 * Fields:
 * <ul>
 * <li> id int mandatory
 * <li> vendor string(255) mandatory
 * <li> model string(255) mandatory
 * <li> beginyear int mandatory
 * <li> endyear int mandatory
 * <li> modification_alias string(255) mandatory
 * <li> kuzov string(255) mandatory
 * <li> modification string(255) mandatory
 * <li> lz int mandatory
 * <li> pcd double mandatory
 * <li> dia double mandatory
 * <li> bolt string(255) mandatory
 * <li> image string(255) mandatory
 * </ul>
 *
 * @package Bitrix\Carmodels
 **/

class CarModelsTable extends DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'auto_carmodels';
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
					'title' => Loc::getMessage('CARMODELS_ENTITY_ID_FIELD'),
				]
			),
			new StringField(
				'vendor',
				[
					'required' => true,
					'validation' => function()
					{
						return[
							new LengthValidator(null, 255),
						];
					},
					'title' => Loc::getMessage('CARMODELS_ENTITY_VENDOR_FIELD'),
				]
			),
			new StringField(
				'model',
				[
					'required' => true,
					'validation' => function()
					{
						return[
							new LengthValidator(null, 255),
						];
					},
					'title' => Loc::getMessage('CARMODELS_ENTITY_MODEL_FIELD'),
				]
			),
			new IntegerField(
				'beginyear',
				[
					'required' => true,
					'title' => Loc::getMessage('CARMODELS_ENTITY_BEGINYEAR_FIELD'),
				]
			),
			new IntegerField(
				'endyear',
				[
					'required' => true,
					'title' => Loc::getMessage('CARMODELS_ENTITY_ENDYEAR_FIELD'),
				]
			),
			new StringField(
				'modification_alias',
				[
					'required' => true,
					'validation' => function()
					{
						return[
							new LengthValidator(null, 255),
						];
					},
					'title' => Loc::getMessage('CARMODELS_ENTITY_MODIFICATION_ALIAS_FIELD'),
				]
			),
			new StringField(
				'kuzov',
				[
					'required' => true,
					'validation' => function()
					{
						return[
							new LengthValidator(null, 255),
						];
					},
					'title' => Loc::getMessage('CARMODELS_ENTITY_KUZOV_FIELD'),
				]
			),
			new StringField(
				'modification',
				[
					'required' => true,
					'validation' => function()
					{
						return[
							new LengthValidator(null, 255),
						];
					},
					'title' => Loc::getMessage('CARMODELS_ENTITY_MODIFICATION_FIELD'),
				]
			),
			new IntegerField(
				'lz',
				[
					'required' => true,
					'title' => Loc::getMessage('CARMODELS_ENTITY_LZ_FIELD'),
				]
			),
			new FloatField(
				'pcd',
				[
					'required' => true,
					'title' => Loc::getMessage('CARMODELS_ENTITY_PCD_FIELD'),
				]
			),
			new FloatField(
				'dia',
				[
					'required' => true,
					'title' => Loc::getMessage('CARMODELS_ENTITY_DIA_FIELD'),
				]
			),
			new StringField(
				'bolt',
				[
					'required' => true,
					'validation' => function()
					{
						return[
							new LengthValidator(null, 255),
						];
					},
					'title' => Loc::getMessage('CARMODELS_ENTITY_BOLT_FIELD'),
				]
			),
			new StringField(
				'image',
				[
					'required' => true,
					'validation' => function()
					{
						return[
							new LengthValidator(null, 255),
						];
					},
					'title' => Loc::getMessage('CARMODELS_ENTITY_IMAGE_FIELD'),
				]
			),
		];
	}
}