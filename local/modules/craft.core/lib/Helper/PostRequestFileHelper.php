<?php

namespace Craft\Core\Helper;

class PostRequestFileHelper
{
	public static function prepareFileData(): array
	{
		$organizedFiles = [];

		foreach($_FILES as $fieldName => $fileData)
		{
			// Инициализируем массив для текущего поля
			$organizedFiles[$fieldName] = [];

			// Обработка множественных файлов
			if(is_array($fileData['name']))
			{
				foreach($fileData['name'] as $index => $name)
				{
					// Пропускаем пустые загрузки
					if($fileData['error'][$index] === UPLOAD_ERR_NO_FILE)
					{
						continue;
					}

					$organizedFiles[$fieldName][] = [
						'name'     => $name,
						'type'     => $fileData['type'][$index],
						'tmp_name' => $fileData['tmp_name'][$index],
						'error'    => $fileData['error'][$index],
						'size'     => $fileData['size'][$index],
					];
				}
			} // Обработка одиночного файла
			else
			{
				// Пропускаем пустую загрузку
				if($fileData['error'] === UPLOAD_ERR_NO_FILE)
				{
					continue;
				}

				$organizedFiles[$fieldName][] = [
					'name'     => $fileData['name'],
					'type'     => $fileData['type'],
					'tmp_name' => $fileData['tmp_name'],
					'error'    => $fileData['error'],
					'size'     => $fileData['size'],
				];
			}
		}

		return $organizedFiles;
	}
}