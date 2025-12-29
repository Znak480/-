<?php

namespace Craft\Orm;

use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\DatetimeField;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\StringField;
use Bitrix\Main\Type\DateTime;

class SearchSynonymTable extends DataManager
{
	const F_ID = 'ID';
	const F_SEARCH_TEXT = 'SEARCH_TEXT';
	const F_SEARCH_ITEMS = 'SEARCH_ITEMS';
	const F_CREATED_AT = 'CREATED_AT';
	const F_UPDATED_AT = 'UPDATED_AT';

	public static function getTableName()
	{
		return 'craft_search_synonym';
	}

	public static function getMap()
	{
		return [
			(new IntegerField(self::F_ID))
				->configureTitle('ID')
				->configurePrimary(),


			(new StringField(self::F_SEARCH_ITEMS))
				->configureTitle('Поисковые варианты')
				->configureRequired(),

			(new DatetimeField(self::F_CREATED_AT))
				->configureTitle('Дата создания')
				->configureDefaultValue(new DateTime()),

			(new DatetimeField(self::F_UPDATED_AT))
				->configureDefaultValue(new DateTime())
				->configureTitle('Дата обновления'),
		];
	}

	public static function getObjectClass()
	{
		return SearchSynonym::class;
	}

	public static function add(array $data)
	{
		$data[SearchSynonymTable::F_UPDATED_AT] = new DateTime();
		return parent::add($data);
	}

	public static function update($primary, array $data)
	{
		$data[SearchSynonymTable::F_UPDATED_AT] = new DateTime();
		return parent::update($primary, $data);
	}

}