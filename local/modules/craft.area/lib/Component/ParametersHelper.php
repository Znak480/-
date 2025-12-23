<?php

namespace Craft\Area\Component;

use Craft\Area\Entity\Area;
use Craft\Area\Entity\AreaTable;

class ParametersHelper
{
	public static function getAreaList(): array
	{
		$result = [];


		$query = AreaTable::getList([
			'select' => [
				AreaTable::FIELD_NAME,
				AreaTable::FIELD_ACTIVE,
				AreaTable::FIELD_CODE,
			],
		])->fetchCollection();

		foreach($query as $item)
		{
			/* @var Area $item */
			$result[$item->getCode()] = sprintf('[%s] %s', ($item->getActive() ? 'Активно' : 'Не активно'), $item->getName());
		}

		return $result;
	}
}