<?php

namespace Craft\Core\Html;

use Bitrix\Main\Diag\Debug;

class FileMapper
{
	public static function map(array $files): array
	{
		$_files = [];

		foreach($files as $propertyCode => $fileData)
		{
			if(!is_array($fileData['tmp_name']))
			{
				if(!mb_strlen($fileData['tmp_name']))
				{
					continue;
				}

				$_files[$propertyCode][] = $fileData;
			} else
			{
				foreach($fileData as $key => $values)
				{
					if(!mb_strlen($values['tmp_name']))
					{
						continue;
					}

					foreach($values as $index => $value)
					{
						$_files[$propertyCode][$index][$key] = $value;
					}
				}
			}
		}


		return $_files;
	}
}