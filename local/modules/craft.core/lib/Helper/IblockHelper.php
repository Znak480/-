<?php

namespace Craft\Core\Helper;

use Bitrix\Main\Loader;

class IblockHelper
{
	public static function getIblockId(array $filter = []): ?int
	{

		if(!Loader::includeModule('iblock'))
		{
			return NULL;
		}

		$queryIblock = \CIBlock::GetList(
			[],
			$filter
		)->GetNext();

		if(!$queryIblock)
		{
			return NULL;
		}

		return (int)$queryIblock['ID'];
	}

	public static function getIblockIdByCode(string $code): ?int
	{
		return self::getIblockId(['CODE' => $code]);
	}


	public static function getSectionId(array $filter = []): ?int
	{
		$sectionId = null;

		$sectionQuery = \CIBlockSection::GetList(
			[],
			$filter,
			false,
			[
				'ID',
			]
		)->Fetch();


		if($sectionQuery)
		{
			$sectionId = $sectionQuery['ID'];
		}

		return $sectionId;

	}

	public static function getSectionIdByCode(string $code, int $iblockId): ?int
	{
		return self::getSectionId(['IBLOCK_ID' => $iblockId, 'CODE' => $code]);
	}

	public static function getSectionIdByName(string $name, int $iblockId): ?int
	{
		return self::getSectionId(['IBLOCK_ID' => $iblockId, 'NAME' => $name]);
	}
}