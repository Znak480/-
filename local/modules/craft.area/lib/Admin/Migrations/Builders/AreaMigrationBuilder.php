<?php

namespace Craft\Area\Admin\Migrations\Builders;

use Craft\Area\Admin\Migrations\Manager\OrmExchangeExport;
use Craft\Area\Entity\AreaTable;
use Craft\Area\Module;
use Sprint\Migration\Exchange\RestartableWriter;
use Sprint\Migration\VersionBuilder;

class AreaMigrationBuilder extends VersionBuilder
{

	protected function isBuilderEnabled()
	{
		return true;
	}

	protected function initialize()
	{
		$this->setTitle('Полный перенос редактируемых блоков');
		$this->setDescription('Выполняется полный перенос редактируемых блоков');
		$this->setGroup('[craft.area] Редактируемые блоки');

		$this->addVersionFields();
	}

	protected function execute()
	{
		$chooseElement = $this->addFieldAndReturn(
			'selectElement',
			[
				'title'  => 'Выбор редактируемых блоков',
				'width'  => 250,
				'select' => [
					[
						'title' => 'Все',
						'value' => 'all',
					],
					[
						'title' => 'Указать ID',
						'value' => 'choose_id',
					],
				],
			]
		);

		$chooseId = null;
		if($chooseElement == 'choose_id')
		{
			$chooseId = $this->addFieldAndReturn(
				'elementIdList',
				[
					'title' => 'Укажите ID редактируемых блоков через пробел',
					'width' => 400,
				]
			);
		}

		$elementIdList = [];
		if($chooseId)
		{
			$elementIdList = explode(' ', $chooseId);
		}

		$areaListFilter = [];

		if($elementIdList)
		{
			$areaListFilter[AreaTable::FIELD_ID] = $elementIdList;
		}

		$areaListResult = AreaTable::getList([
			'filter' => $areaListFilter,
		]);

		$writer = new RestartableWriter(
			$this,
			$this->getVersionExchangeDir(),
		);


		$writer->setExchangeResource('full_area_data.xml')
			->execute(
				function() { return []; },
				function() { return 0; },
				function() use ($areaListResult) {
					return (new OrmExchangeExport())->setQuery($areaListResult)->execute();
				}
			);

		$this->createVersionFile(
			Module::getModuleDir() . '/config/migrations/templates/AreaMigrationTemplate.php',
			[
				'use'    => 'Craft\Area\Admin\Migrations\Builders\AreaVersionBuilder',
				'extend' => 'AreaVersionBuilder',
			]
		);
	}
}