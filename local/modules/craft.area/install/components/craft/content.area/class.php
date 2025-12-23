<?php

use Craft\Area\Entity\Area;
use Craft\Area\Entity\AreaTable;
use Craft\Area\Entity\AreaField;
use Craft\Area\Dto\AreaContentDto;


/**
 * @property Area|null $area
 * @property AreaContentDto[] $content
 */
class CraftContentAreaComponent extends CBitrixComponent
{
	protected ?Area $area = null;
	protected array $content = [];

	public function onPrepareComponentParams($arParams)
	{
		$arParams['CODE'] = $arParams['CODE'] ?: null;

		return $arParams;
	}

	public function executeComponent()
	{
		try
		{
			$this->execute();
		} catch(Exception $e)
		{
			return;
		}

		$this->includeComponentTemplate();
	}

	/**
	 * @return void
	 * @throws Exception
	 */
	protected function execute(): void
	{
		$this->loadModule(['craft.area']);

		$this->loadData();

		$this->initLinks();
	}

	protected function loadModule(array $modules): void
	{
		foreach($modules as $module)
		{
			if(!\Bitrix\Main\Loader::includeModule($module))
			{
				throw new Exception('Модуль ' . $module . ' не подключен');
			}
		}
	}

	/**
	 * @throws Exception
	 */
	protected function loadData(): void
	{
		$this->loadArea();
		$this->collectAreaInformation();
	}

	protected function loadArea(): void
	{
		$this->area = AreaTable::getList([
			'filter' => [
				AreaTable::FIELD_CODE => $this->arParams['CODE'],
			],
		])->fetchObject();

		if(!$this->area)
		{
			throw new Exception('Редактируемый блок не найден');
		}

		$this->area->fillFields();
	}

	protected function collectAreaInformation(): void
	{
		$this->arResult['AREA'] = [
			'ID'   => $this->area->getId(),
			'NAME' => $this->area->getName(),
		];

		$fields = $this->area->fillFields();
		if(!$fields)
		{
			throw new Exception('Нет редактируемого контента');
		}


		foreach($fields as $field)
		{
			/* @var AreaField $field */
			$content = $field->fillContent();
			if(!$content)
			{
				continue;
			}

			$this->content[] = new AreaContentDto($field->getCode(), $content->getValueEx());
		}
	}

	protected function initLinks(): void
	{
		$this->AddEditAction(
			$this->area->getId(),
			$this->area->getContentEditAreaLink(),
			'Изменить ' . $this->area->getName(),
			"ELEMENT_EDIT"
		);
	}

	/**
	 * @return array|string|int|null
	 */
	public function getValue(string $propertyCode)
	{
		$contentBlockFind = array_filter($this->content, function(AreaContentDto $item) use ($propertyCode) {
			return $item->getBlockCode() == $propertyCode;
		});

		$contentBlockFind = array_values($contentBlockFind);

		$contentBlock = count($contentBlockFind) == 1 ? $contentBlockFind[0] : null;

		if($contentBlock instanceof AreaContentDto)
		{
			return $contentBlock->getValue();
		}

		return null;
	}

	// Манипуляции в шаблоне

	public function editAreaId(): string
	{
		return $this->getEditAreaId($this->area->getId());
	}

	public function editAreaName(): void
	{
		$this->content[] = [];
	}

	public function isAreaActive(): bool
	{
		return $this->area->getActive();
	}

	public function showNoActiveMessage(): ?string
	{
		global $USER;

		if(!$USER->IsAdmin())
		{
			return null;
		}

		ob_start();
		?>
		<div style="color:red; font-weight: 600;">Редактируемый блок: <?=$this->area->getName();?> - не активен</div>
		<?php
		return ob_get_clean();
	}
}