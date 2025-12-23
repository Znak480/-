<?php

namespace Craft\Core\Helper;

class UserGroupHelper
{
	public static function findByCode(string $code): ?int
	{
		$result = \Bitrix\Main\GroupTable::getList([
			'select' => [
				'ID',
			],
			'filter' => [
				'STRING_ID' => $code,
			],
			"cache"  => [
				"ttl" => 3600 * 24 * 5, # 5day
			],
		]);

		if($result->getSelectedRowsCount() != 1)
		{
			return null;
		}

		$group = $result->fetch();

		return $group['ID'];
	}
}