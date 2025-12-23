<?php

namespace Craft\Area\Entity;

use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\BooleanField;
use Bitrix\Main\ORM\Fields\DatetimeField;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\Relations\OneToMany;
use Bitrix\Main\ORM\Fields\StringField;
use Bitrix\Main\Type\DateTime;

class AreaTable extends DataManager
{

	const FIELD_ID = 'ID';
	const FIELD_NAME = 'NAME';
	const FIELD_CODE = 'CODE';
	const FIELD_ACTIVE = 'ACTIVE';
	const FIELD_SORT = 'SORT';
	const FIELD_CREATED_AT = 'CREATED_AT';
	const FIELD_UPDATED_AT = 'UPDATED_AT';

	const R_FIELDS = 'FIELDS';
	const R_CONTENT = 'CONTENT';

	const ACTIVE_Y = 'Y';
	const ACTIVE_N = 'N';

	public static function getTableName()
	{
		return 'craft_area';
	}

	public static function getMap()
	{
		return [
			(new IntegerField(self::FIELD_ID))
				->configureTitle('ID')
				->configureAutocomplete()
				->configurePrimary(),
			(new StringField(self::FIELD_NAME))
				->configureTitle('Название')
				->configureRequired(),
			(new StringField(self::FIELD_CODE))
				->configureTitle('Символьный код')
				->configureRequired(),
			(new BooleanField(self::FIELD_ACTIVE))
				->configureTitle('Активность')
				->configureDefaultValue(self::ACTIVE_Y)
				->configureValues(self::ACTIVE_N, self::ACTIVE_Y),
			(new IntegerField(self::FIELD_SORT))
				->configureTitle('Сортировка')
				->configureDefaultValue(500),
			(new DatetimeField(self::FIELD_CREATED_AT))
				->configureTitle('Дата создания')
				->configureDefaultValue(new DateTime()),
			(new DatetimeField(self::FIELD_UPDATED_AT))
				->configureTitle('Дата обновления')
				->configureDefaultValue(new DateTime()),


			// RELATIONS
			(new OneToMany(self::R_FIELDS, AreaFieldTable::class, AreaFieldTable::R_AREA))
				->configureJoinType('inner'),
			(new OneToMany(self::R_CONTENT, AreaContentTable::class, AreaContentTable::R_AREA))
				->configureJoinType('inner'),
		];
	}

	public static function getObjectClass()
	{
		return Area::class;
	}

	public static function getCollectionClass()
	{
		return AreaCollection::class;
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