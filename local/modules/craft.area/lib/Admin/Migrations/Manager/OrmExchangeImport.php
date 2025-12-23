<?php

namespace Craft\Area\Admin\Migrations\Manager;

use Bitrix\Main\Diag\Debug;
use Craft\Area\Entity\AreaContentTable;
use Sprint\Migration\Interfaces\ReaderHelperInterface;

class OrmExchangeImport implements ReaderHelperInterface
{
	public function convertReaderRecords(array $attributes, array $records): array
	{
		$areaList = $this->collectAreaList($records);
		$fieldList = $this->collectFieldList($records);
		$contentList = $this->collectContentList($records);

		return [
			[
				'areaList'    => $areaList,
				'fieldList'   => $fieldList,
				'contentList' => $contentList,
			],
		];
	}

	protected function collectAreaList($records): array
	{
		return $this->collectDataByKey($records, 'Area');
	}

	protected function collectFieldList($records): array
	{
		return $this->collectDataByKey($records, 'AreaField');
	}

	protected function collectContentList($records): array
	{
		return $this->collectDataByKey($records, 'AreaContent');
	}

	protected function collectDataByKey(array $records, string $key): array
	{

		//		Debug::dumpToFile($records);

		$result = [];
		foreach($records as $record)
		{
			$_fields = $record['fields'];

			$collectedData = array_filter($_fields, function($field) use ($key) {
				return $field['value'][0]['orm'] === $key;
			});

			$result = array_merge($result, $collectedData);
		}


		//		Debug::dumpToFile($result);
		$_tmp = [];
		foreach($result as $resultItem)
		{
			$_tmp = array_merge($_tmp, $resultItem['value']);
		}


		$_tmp2 = [];
		foreach($_tmp as $item)
		{
			if($key != 'AreaContent')
			{

				$_tmp2[$item['code']][] = $item['value'];
			} else
			{
				$_item = ['val' => $item['value']];

				if($item['AREA_ID'])
				{
					$_item[AreaContentTable::FIELD_AREA_ID] = $item['AREA_ID'];
				}

				if($item['AREA_BLOCK_ID'])
				{
					$_item[AreaContentTable::FIELD_AREA_FIELD_ID] = $item['AREA_BLOCK_ID'];
				}

				$_tmp2[$item['code']][] = $_item;
			}
		}

		//		Debug::dumpToFile($_tmp2, '', '__fix.log');

		$count = count($_tmp2[key($_tmp2)]); // Берём длину одного из массивов
		$result = [];

		// Проходим по каждому индексу
		for($i = 0; $i < $count; $i++)
		{
			$element = [];
			// Собираем значения для текущего индекса из всех ключей
			foreach($_tmp2 as $key => $values)
			{
				$element[$key] = $values[$i];
			}
			$result[] = $element;
		}


		//		Debug::dumpToFile($result);
		//		Debug::dumpToFile($result, '', '__fix222.log');


		return $result;
	}
}