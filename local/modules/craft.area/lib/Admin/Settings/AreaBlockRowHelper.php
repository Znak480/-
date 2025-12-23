<?php

namespace Craft\Area\Admin\Settings;

use Bitrix\Main\Diag\Debug;
use http\Exception\UnexpectedValueException;
use Craft\Area\Entity\AreaField;
use Craft\Area\Entity\AreaFieldTable;
use Craft\Core\Helper\ModalRequestHelper;

class AreaBlockRowHelper
{

	private ?int $areaId = null;
	private ?AreaField $areaBlock = null;

	public function __construct(
		AreaField $areaBlock,
		int       $areaId
	)
	{
		$this->areaId = $areaId;
		$this->areaBlock = $areaBlock;
	}

	public function render(int $index): ?string
	{
		return $this->renderRow($index);
	}

	protected function renderRow(int $index): string
	{
		$areaField = $this->getAreaBlock();
		ob_start();
		?>
		<div class="craft-area-settings-item" data-content-block-item>

			<input type="hidden" value="<?=$areaField ? $areaField->getId() : '#NONE#';?>" name="CONTENT_BLOCK[<?=AreaFieldTable::FIELD_ID;?>][<?=$index;?>]">
			<input type="hidden" value="<?=$this->getType();?>" name="CONTENT_BLOCK[<?=AreaFieldTable::FIELD_TYPE;?>][<?=$index;?>]">
			<input type="hidden" value="<?=$this->getAreaId();?>" name="CONTENT_BLOCK[<?=AreaFieldTable::FIELD_AREA_ID;?>][<?=$index;?>]">

			<div class="craft-area-settings-item-col">
				<div><?=AreaField::getTypeLabel($this->getType());?></div>
				<?php
				if($areaField && $areaField->getId())
				{
					?>
					<div style="color:darkgrey;">id = <?=$areaField->getId();?></div>
					<?php
				}
				?>
			</div>


			<div class="craft-area-settings-item-col">
				<label class="craft-area-settings-item__label">[код свойства]</label>
				<input
					type="text"
					name="CONTENT_BLOCK[<?=AreaFieldTable::FIELD_CODE;?>][<?=$index;?>]"
					placeholder="код свойства"
					<?=$areaField ? 'value="' . $areaField->getCode() . '"' : '';?>
				>
			</div>

			<div class="craft-area-settings-item-col">
				<label class="craft-area-settings-item__label">[название свойства]</label>
				<input
					type="text"
					name="CONTENT_BLOCK[<?=AreaFieldTable::FIELD_NAME;?>][<?=$index;?>]"
					placeholder="название свойства"
					<?=$areaField ? 'value="' . $areaField->getName() . '"' : '';?>
				>
			</div>

			<div class="craft-area-settings-item-col">
				<label class="craft-area-settings-item__label">[сортировка]</label>
				<input
					type="text"
					name="CONTENT_BLOCK[<?=AreaFieldTable::FIELD_SORT;?>][<?=$index;?>]"
					placeholder="сортировка"
					<?=$areaField ? 'value="' . $areaField->getSort() . '"' : 'value="500"';?>
				>
			</div>

			<div class="craft-area-settings-item-col">
				<label class="craft-area-settings-item__label">[множественное]</label>
				<?=$this->smartCheckbox(
					'CONTENT_BLOCK[' . AreaFieldTable::FIELD_MULTIPLE . '][' . $index . ']',
					[AreaFieldTable::MULTIPLE_Y, AreaFieldTable::MULTIPLE_N],
					($areaField && $areaField->getMultiple()),
				);?>
			</div>


			<?php
			$uniq = uniqid();
			?>
			<div class="craft-area-settings-item-col">
				<label class="craft-area-settings-item__label">[настройки]</label>
				<div class="magic-settings-container">
					<input
						<?=$areaField->isComplex() ? 'style="max-width:70%;"' : '';?>
						type="text"
						name="CONTENT_BLOCK[<?=AreaFieldTable::FIELD_SETTINGS;?>][<?=$index;?>]"
						placeholder="настройки"
						<?=$areaField ? 'value="' . htmlspecialchars($areaField->getSettings()) . '"' : '';?>
						data-magick-input="<?=$uniq;?>"
					>

					<?php
					if($areaField->isComplex())
					{
						?>
						<div
							class="magic-settings"
							data-fancybox
							data-type="ajax"
							data-input="<?=$uniq;?>"
							href="<?=ModalRequestHelper::init('/local/modules/craft.area/tool/index.php')->params([
								'action'  => 'modal',
								'modal'   => 'magicSettings',
								'key'     => $uniq,
							])->build();?>"
						>
							<img src="/local/modules/craft.area/assets/images/magic.png" class="magic-settings__icon">
						</div>
						<?php
					}
					?>
				</div>
			</div>

			<div class="craft-area-settings-item-col settings-action-block">
				<label class="delete-label">
					<input data-content-block-action-remove type="radio" name="CONTENT_BLOCK[isDel][<?=$index;?>]" value="Y">
					<img class="craft-area-settings-item settings-action-remove" src="/local/modules/craft.area/assets/images/remove-red.png">
				</label>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}

	protected function getType(): ?string
	{
		return $this->areaBlock->getType();
	}

	protected function getAreaId(): ?int
	{
		return $this->areaId;
	}

	protected function getAreaBlock(): ?AreaField
	{
		return $this->areaBlock;
	}

	protected function smartCheckbox($id, $value, $checked): string
	{
		return '<input type="hidden" name="' . $id . '" value="' . htmlspecialcharsbx($value[1]) . '">
				<input type="checkbox" name="' . $id . '" value="' . htmlspecialcharsbx($value[0]) . '"' . ($checked ? ' checked' : '') . '/>';
	}
}