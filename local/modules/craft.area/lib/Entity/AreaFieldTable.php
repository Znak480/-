<?php

namespace Craft\Area\Entity;


use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\BooleanField;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Fields\StringField;
use Bitrix\Main\ORM\Query\Join;

class AreaFieldTable extends DataManager
{

	const FIELD_ID = 'ID';
	const FIELD_TYPE = 'TYPE';
	const FIELD_AREA_ID = 'AREA_ID';
	const FIELD_CODE = 'CODE';
	const FIELD_NAME = 'NAME';
	const FIELD_MULTIPLE = 'MULTIPLE';
	const FIELD_ACTIVE = 'ACTIVE';
	const FIELD_SORT = 'SORT';
	const FIELD_SETTINGS = 'SETTINGS';

	const R_AREA = 'AREA';
	const R_CONTENT = 'CONTENT';

	const MULTIPLE_Y = 'Y';
	const MULTIPLE_N = 'N';

	const ACTIVE_Y = 'Y';
	const ACTIVE_N = 'N';

	public static function getTableName()
	{
		return 'craft_area_field';
	}

	public static function getMap()
	{
		return [
			(new IntegerField(self::FIELD_ID))
				->configureTitle('ID')
				->configureAutocomplete()
				->configurePrimary(),
			(new IntegerField(self::FIELD_AREA_ID))
				->configureTitle('ID редактируемого блока'),
			(new StringField(self::FIELD_TYPE))
				->configureTitle('Тип блока'),
			(new StringField(self::FIELD_NAME))
				->configureTitle('Имя блока'),
			(new IntegerField(self::FIELD_SORT))
				->configureTitle('Сортировка (в адм. панели)'),
			(new StringField(self::FIELD_CODE))
				->configureTitle('Символьный код')
				->configureRequired(),
			(new BooleanField(self::FIELD_ACTIVE))
				->configureTitle('Активность')
				->configureDefaultValue(self::ACTIVE_Y)
				->configureStorageValues(self::ACTIVE_N, self::ACTIVE_Y),
			(new BooleanField(self::FIELD_MULTIPLE))
				->configureTitle('Множественные значения')
				->configureDefaultValue(self::MULTIPLE_N)
				->configureStorageValues(self::MULTIPLE_N, self::MULTIPLE_Y),
			(new StringField(self::FIELD_SETTINGS))
				->configureTitle('Настройки'),

			// RELATIONS
			(new Reference(self::R_AREA, AreaTable::class, Join::on('this.' . self::FIELD_AREA_ID, 'ref.' . AreaTable::FIELD_ID)))
				->configureJoinType('inner'),
			(new Reference(self::R_CONTENT, AreaContentTable::class, Join::on('this.' . self::FIELD_ID, 'ref.' . AreaContentTable::FIELD_AREA_FIELD_ID)))
				->configureJoinType('inner'),
		];
	}

	public static function getCollectionClass()
	{
		return AreaFieldCollection::class;
	}

	public static function getObjectClass()
	{
		return AreaField::class;
	}

	public static function getByCode(string $code)
	{
		$_object = self::getList(['filter' => [self::FIELD_CODE => $code]])->fetchObject();
		if($_object)
		{
			return $_object;
		}

		return null;
	}

	public static function emptyObjectIfNotExists($code)
	{
		$_object = self::getByCode($code);

		if($_object)
		{
			return $_object;
		}

		return self::createObject();
	}
}