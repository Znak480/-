<?php

namespace Craft\Area\Admin\Helper;

use CModule;
use CHTMLEditor;
use Craft\Area\Dto\ComplexSettingsDto;
use Craft\Area\Entity\AreaContent;
use Craft\Area\Entity\AreaField;

class ComplexRow
{
	/**
	 * @param AreaField $field
	 * @param $inputIndex
	 * @param $content
	 * @return false|string
	 */
	public static function render(AreaField $field, ?AreaContent $content = null, $inputIndex = null)
	{
		$value = [];
		$settings = $field->getSettingsEx();
		if($content)
		{
			$value = $content->getValueEx();
		}

		if(!$field->getMultiple())
		{
			$value = [array_shift($value)];
		}

		ob_start();
		if(is_array($value))
		{
			if(!$inputIndex)
			{
				$inputIndex = 0;
			}

			foreach($value as $valueData)
			{
				self::renderSeparateLine($field, $inputIndex + 1);

				self::renderCommonRow($settings, $field, $inputIndex, $valueData);

				$inputIndex++;
			}

			self::renderSeparateLine($field, $inputIndex + 1);

			if($field->getMultiple())
			{
				self::renderCommonRow($settings, $field, $inputIndex + 1);
			}

		} else
		{
			self::renderCommonRow($settings, $field, $inputIndex);
		}
		return ob_get_clean();
	}

	private static function renderSeparateLine(AreaField $field, int $inputIndex): void
	{
		?>
		<tr>
			<td colspan="2">
				<div
					style="width: 100%;  background-color: rgba(169, 169, 169, 0.32); text-align: center; padding: 5px; color:#000; font-weight: bold;">
					[составное свойство] №<?=$inputIndex + 1;?><br><?=$field->getName();?> [<?=$field->getCode();?>][<?=$field->getId();?>]
				</div>
			</td>
		</tr>
		<?php

	}

	private static function renderCommonRow(ComplexSettingsDto $settings, AreaField $field, $index = null, $values = [])
	{
		foreach($settings->getCode() as $fieldCode)
		{
			$value = null;
			$currentField = $settings->gen($fieldCode);

			if(!$currentField)
			{
				continue;
			}

			if(!empty($values[$currentField->getCode()]))
			{
				$value = $values[$currentField->getCode()];
			}


			self::renderFields(
				$currentField,
				self::inputName($currentField, $field, $index),
				$value
			);

		}
	}

	private static function inputName(ComplexSettingsDto $fieldSettings, AreaField $field, $inputIndex): string
	{
		return $field->getCode() . '[' . $field->getId() . '][' . $inputIndex . '][' . $fieldSettings->getCode() . ']';
	}

	private static function renderFields(ComplexSettingsDto $fieldSettings, string $inputName, $fieldValue = null)
	{
		switch($fieldSettings->getField())
		{
			case AreaField::BLOCK_TYPE_STRING:
				?>
				<tr>
					<td class="adm-detail-content-cell-l">
						<div><?=$fieldSettings->getName();?></div>
						<div style="color:darkgray;">[<?=$fieldSettings->getCode();?>]</div>
					</td>
					<td class="adm-detail-content-cell-r">
						<input type="text" value="<?=$fieldValue;?>" name="<?=$inputName;?>">
					</td>
				</tr>
				<?php
				break;
			case AreaField::BLOCK_TYPE_HTML:
				?>
				<tr>
					<td class="adm-detail-content-cell-l">
						<div><?=$fieldSettings->getName();?></div>
						<div style="color:darkgray;">[<?=$fieldSettings->getCode();?>]</div>
					</td>
					<td class="adm-detail-content-cell-r">
						<?php
						if(CModule::IncludeModule("fileman"))
						{
							$id = ComplexRow . phppreg_replace("/[^a-z0-9]/i", '', $inputName) . uniqid();
							ob_start();
							echo '<input type="hidden" name="' . $inputName . '[TYPE]" value="html">';
							$LHE = new CHTMLEditor();
							$LHE->Show([
								'id'               => $id,
								'width'            => '100%',
								'height'           => '400',
								'minBodyWidth'     => 350,
								'normalBodyWidth'  => 555,
								'autoResize'       => true,
								'inputName'        => $inputName,
								'content'          => htmlspecialchars_decode($fieldValue),
								'bUseFileDialogs'  => false,
								'bFloatingToolbar' => true,
								'bArisingToolbar'  => false,
							]);
							echo ob_get_clean();
						} else
						{
							?>
							<textarea name="<?=$inputName;?>"
									  style="width: 100%; height: 400px;"><?=$fieldValue;?></textarea>
							<?php
						}
						?>
					</td>
				</tr>
				<?php
				break;
			case AreaField::BLOCK_TYPE_TEXT:
				?>
				<tr>
					<td class="adm-detail-content-cell-l">
						<div><?=$fieldSettings->getName();?></div>
						<div style="color:darkgray;">[<?=$fieldSettings->getCode();?>]</div>
					</td>
					<td class="adm-detail-content-cell-r">
                        <textarea name="<?=$inputName;?>"
								  style="width: 100%; height: 200px;"><?=$fieldValue;?></textarea>
					</td>
				</tr>
				<?php
				break;
			case AreaField::BLOCK_TYPE_IMAGE:
				?>
				<tr>
					<td class="adm-detail-content-cell-l">
						<div><?=$fieldSettings->getName();?></div>
						<div style="color:darkgray;">[<?=$fieldSettings->getCode();?>]</div>
					</td>
					<td class="adm-detail-content-cell-r">
						<?=\Bitrix\Main\UI\FileInput::createInstance([
							"name"        => $inputName,
							"description" => true,
							"upload"      => true,
							"allowUpload" => "A",
							"medialib"    => true,
							"fileDialog"  => true,
							"cloud"       => true,
							"delete"      => true,
							'maxCount'    => 1,
						])->show($fieldValue);?>

					</td>
				</tr>
				<?php
				break;
		}
	}
}