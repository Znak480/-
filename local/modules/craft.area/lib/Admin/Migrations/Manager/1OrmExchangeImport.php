<?php

namespace Craft\Area\Admin\Migrations\Manager;

use Bitrix\Main\Diag\Debug;
use Sprint\Migration\Interfaces\ReaderHelperInterface;

class QOrmExchangeImport implements ReaderHelperInterface
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

		$result = [];
		foreach($records as $record)
		{
			$_fields = $record['fields'];

			$collectedData = array_filter($_fields, function($field) use ($key) {
				return $field['value'][0]['orm'] === $key;
			});

			Debug::dumpToFile($collectedData,'','__asdasd.log');

			$collectedData = array_map(function($field) {

				# is image
				if(is_array($field['value'][0]['value']) && $field['value'][0]['value']['tmp_name'] && count($field['value']) > 1)
				{
					$v = array_map(function($rawData) {
						return array_merge($rawData['value'], [
							'AREA_ID'       => $rawData['AREA_ID'],
							'AREA_BLOCK_ID' => $rawData['AREA_BLOCK_ID'],
						]);
					}, $field['value']);

					$_field = [];
					if($field['value'][0]['AREA_ID'])
					{
						$_field['AREA_ID'] = $field['value'][0]['AREA_ID'];
					}

					if($field['value'][0]['AREA_BLOCK_ID'])
					{
						$_field['AREA_BLOCK_ID'] = $field['value'][0]['AREA_BLOCK_ID'];
					}

					$_field['code'] = $field['value'][0]['code'];
					$_field['value'] = $v;

				} else
				{
					$_field = [
						'code'  => $field['value'][0]['code'],
						'value' => $field['value'][0]['value'],
					];

					if($field['value'][0]['AREA_ID'])
					{
						$_field['AREA_ID'] = $field['value'][0]['AREA_ID'];
					}
					if($field['value'][0]['AREA_BLOCK_ID'])
					{
						$_field['AREA_BLOCK_ID'] = $field['value'][0]['AREA_BLOCK_ID'];
					}
				}

				return $_field;
			}, $collectedData);

			$collectedData = array_reduce($collectedData, function($result, $item) use ($key) {

				if($key == 'AreaContent')
				{
					if(!is_array($item['value']))
					{
						$item['value'] = ['value' => $item['value']];
					}

					if($item['AREA_ID'])
					{
						$item['value']['AREA_ID'] = $item['AREA_ID'];
					}

					if($item['AREA_BLOCK_ID'])
					{
						$item['value']['AREA_BLOCK_ID'] = $item['AREA_BLOCK_ID'];
					}
				}


				$result[$item['code']][] = $item['value'];
				return $result;
			}, []);

			$result[] = $collectedData;

		}

//		Debug::dumpToFile($result, '', '__as.log');

//		if($key != 'AreaContent')
//		{
//			foreach($result as &$r)
//			{
//				$count = count($result[key($r)]); // Берём длину одного из массивов
//				$_result = [];
//				// Проходим по каждому индексу
//				for($i = 0; $i < $count; $i++)
//				{
//					$element = [];
//					// Собираем значения для текущего индекса из всех ключей
//					foreach($r as $key => $values)
//					{
//						$element[$key] = $values[$i];
//					}
//					$_result[] = $element;
//				}
//
//				$r = $result;
//			}
//		} else
//		{
//			$_result = $result;
//		}

		return $result;
	}
}