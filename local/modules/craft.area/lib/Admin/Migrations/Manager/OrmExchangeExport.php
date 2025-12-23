<?php

namespace Craft\Area\Admin\Migrations\Manager;

use Bitrix\Main\ORM\Query\Result as QueryResult;
use Craft\Area\Admin\Migrations\Exchange\CustomWriterTag;
use Craft\Area\Entity\Area;
use Craft\Area\Entity\AreaContentTable;
use Craft\Area\Entity\AreaFieldTable;
use Craft\Area\Entity\AreaTable;
use Sprint\Migration\Exchange\WriterTag;

class OrmExchangeExport
{

	protected QueryResult $ormQuery;

	public function setQuery(QueryResult $ormQuery): self
	{
		$this->ormQuery = $ormQuery;

		return $this;
	}

	protected function insertField(&$xml, $val, $data): void
	{
		$field = new WriterTag('field');
		$field->addValueTag($val, $data);
		$xml->addChild($field);
	}

	public function execute()
	{
		$objectsCollection = $this->ormQuery->fetchCollection();


		$tag = new WriterTag('tmp');


		foreach($objectsCollection as $area)
		{
			/* @var Area $area */

			$item = new WriterTag('item');
			$this->insertField($item, $area->getId(), ['orm' => 'Area', 'code' => AreaTable::FIELD_ID]);
			$this->insertField($item, $area->getActive() ? AreaTable::ACTIVE_Y : AreaTable::ACTIVE_N, ['orm' => 'Area', 'code' => AreaTable::FIELD_ACTIVE]);
			$this->insertField($item, $area->getName(), ['orm' => 'Area', 'code' => AreaTable::FIELD_NAME]);
			$this->insertField($item, $area->getCode(), ['orm' => 'Area', 'code' => AreaTable::FIELD_CODE]);
			$this->insertField($item, $area->getSort(), ['orm' => 'Area', 'code' => AreaTable::FIELD_SORT]);


			$fields = $area->fillFields();
			$fieldsTag = null;
			if($fields)
			{
				$fieldsTag = new WriterTag('fields');
				foreach($fields as $field)
				{
					$fieldTag = new WriterTag('areaField');
					$this->insertField($fieldTag, $field->getId(), ['orm' => 'AreaField', 'code' => AreaFieldTable::FIELD_ID]);
					$this->insertField($fieldTag, $field->getActive() ? AreaFieldTable::ACTIVE_Y : AreaFieldTable::ACTIVE_N, ['orm' => 'AreaField', 'code' => AreaFieldTable::FIELD_ACTIVE]);
					$this->insertField($fieldTag, $field->getName(), ['orm' => 'AreaField', 'code' => AreaFieldTable::FIELD_NAME]);
					$this->insertField($fieldTag, $field->getCode(), ['orm' => 'AreaField', 'code' => AreaFieldTable::FIELD_CODE]);
					$this->insertField($fieldTag, $field->getSort(), ['orm' => 'AreaField', 'code' => AreaFieldTable::FIELD_SORT]);
					$this->insertField($fieldTag, $field->getType(), ['orm' => 'AreaField', 'code' => AreaFieldTable::FIELD_TYPE]);
					$this->insertField($fieldTag, $field->getSettings(), ['orm' => 'AreaField', 'code' => AreaFieldTable::FIELD_SETTINGS]);
					$this->insertField($fieldTag, $field->getMultiple() ? AreaFieldTable::MULTIPLE_Y : AreaFieldTable::MULTIPLE_N, ['orm' => 'AreaField', 'code' => AreaFieldTable::FIELD_MULTIPLE]);
					$this->insertField($fieldTag, $field->getAreaId(), ['orm' => 'AreaField', 'code' => AreaFieldTable::FIELD_AREA_ID]);

					$fieldsTag->addChild($fieldTag);
				}

			}
			if($fieldsTag)
			{
				$item->addChild($fieldsTag);
			}


			$contentList = $area->fillContent();
			$contentListTag = null;
			if($contentList)
			{
				$contentListTag = new WriterTag('content');

				foreach($contentList as $content)
				{
					$contentItemTag = new WriterTag('contentItem');

					if($content->fillField()->isImage())
					{
						if($content->getField()->getMultiple())
						{
							$contentValue = $content->getValueEx();
							$ids = array_map(function($item) {
								return $item['ID'];
							}, $contentValue);

							$ids = array_filter($ids);

							if($ids)
							{
								$field = new CustomWriterTag('field');
								$field->addFileWithParam($ids, true, [
									'orm'                                 => 'AreaContent',
									'code'                                => AreaContentTable::FIELD_VALUE,
									AreaContentTable::FIELD_AREA_ID       => $content->getAreaId(),
									AreaContentTable::FIELD_AREA_FIELD_ID => $content->getAreaBlockId(),
								]);
								$contentItemTag->addChild($field);
							}
						} else
						{
							$contentValue = $content->getValueEx();
							if($contentValue['ID'])
							{
								$field = new CustomWriterTag('field');
								$field->addFileWithParam($contentValue['ID'], false, [
									'orm'                                 => 'AreaContent',
									'code'                                => AreaContentTable::FIELD_VALUE,
									AreaContentTable::FIELD_AREA_ID       => $content->getAreaId(),
									AreaContentTable::FIELD_AREA_FIELD_ID => $content->getAreaBlockId(),
								]);
								$contentItemTag->addChild($field);
							}
						}

					} else
					{
						$this->insertField($contentItemTag, $content->getValue(), [
							'orm'                                 => 'AreaContent',
							'code'                                => AreaContentTable::FIELD_VALUE,
							AreaContentTable::FIELD_AREA_ID       => $content->getAreaId(),
							AreaContentTable::FIELD_AREA_FIELD_ID => $content->getAreaBlockId(),
						]);
					}


					$contentListTag->addChild($contentItemTag);
				}
			}


			if($contentListTag)
			{
				$item->addChild($contentListTag);
			}

			$tag->addChild($item);

		}

		return $tag;

	}
}

