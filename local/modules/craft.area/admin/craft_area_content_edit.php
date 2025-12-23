<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_before.php");

use Bitrix\Main\Loader;
use Bitrix\Main\Application;
use Bitrix\Main\UI\FileInput;
use Craft\Area\Entity\AreaField;
use Craft\Area\Entity\AreaTable;
use Craft\Area\Admin\Helper\ComplexRow;
use Craft\Area\Entity\AreaContentTable;

/**
 * @global CMain $APPLICATION
 */

$APPLICATION->SetTitle("Управление контентом");
foreach(['craft.area'] as $module)
{
	if(!Loader::includeModule($module))
	{
		$APPLICATION->ThrowException('Не подключен модуль ' . $module);
	};
}

$request = Application::getInstance()->getContext()->getRequest();
$areaId = $request->get('ID');

$area = AreaTable::getByPrimary($areaId)->fetchObject();

if(!$area)
{
	throw new Exception('Редактируемый блок не найден');
}

$fields = $area->fillFields();

CJSCore::Init([
	'craftArea',
]);

if($request->isPost() && check_bitrix_sessid())
{
	$postData = $request->getPostList()->toArray();

	foreach($fields as $field)
	{
		/* @var AreaField $field */

		$areaBlockContent = $field->fillContent();
		if(!$areaBlockContent)
		{
			$areaBlockContent = AreaContentTable::createObject();
		}

		if(!array_key_exists($field->getCode(), $postData))
		{
			continue;
		}

		$value = $postData[$field->getCode()];
		$value = $value[$field->getId()];
		if(empty($value))
		{
			continue;
		}


		/* костыль на удаление файлов */
		if($postData[$field->getCode() . '_del'] && $postData[$field->getCode()])
		{
			if($field->isComplex())
			{
				foreach($postData[$field->getCode() . '_del'] as $delRow)
				{
					foreach($delRow as $k => $v)
					{
						foreach($v as $subKey => $subValue)
						{
							if($value[$k][$subKey])
							{
								$value[$k][$subKey] = [
									'ID'     => $value[$k][$subKey],
									'is_del' => 'Y',
								];
							}
						}
					}
				}

			} else
			{
				$delete = $postData[$field->getCode() . '_del'];
				$fileIdData = $postData[$field->getCode()];
				$fieldId = $field->getId();
				$fileIdList = $fileIdData[$fieldId];

				if(is_array($fileIdList))
				{
					foreach($fileIdList as $index => $fileId)
					{
						if($delete[$fieldId][$index] == 'Y')
						{
							$value[$index] = [];
							$value[$index]['ID'] = $fileId;
							$value[$index]['is_del'] = 'Y';
						}
					}
				} else
				{
					$value = [];
					$value['ID'] = $fileIdList;
					$value['is_del'] = 'Y';
				}
			}

		}
		/* костыль на удаление файлов */


		if(!$areaBlockContent->getAreaId())
		{
			$areaBlockContent->setAreaId($areaId);
		}

		if(!$areaBlockContent->getAreaBlockId())
		{
			$areaBlockContent->setAreaBlockId($field->getId());
		}


		$areaBlockContent->setValueEx($value);

		$areaBlockContent->save();
	}


	LocalRedirect(JEDI_AREA_ADMIN_URL_EDIT_CONTENT . '?ID=' . $areaId);
}

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_after.php");

/* контент*/

$aTabs = [
	[
		"DIV"   => "edit1",
		"TAB"   => 'Основное',
		"ICON"  => "iblock_section",
		"TITLE" => 'Редактирумая область: ' . $area->getName() . ' - управление контентом',
	],
];
$tabControl = new CAdminForm('craftAreaContentEditTabControl', $aTabs);

$tabControl->BeginEpilogContent();
echo bitrix_sessid_post();

?>
	<input type="hidden" name="ID" value="<?=$area->getId();?>">
<?php

$tabControl->EndEpilogContent();


$tabControl->Begin();


$tabControl->BeginNextFormTab();
$tabControl->BeginCustomField("CONTENT", '', true);

if($fields->count() > 0)
{
	?>
	<?php
	foreach($fields as $field)
	{
		/* @var AreaField $field */

		$content = $field->fillContent();
		?>
		<input type="hidden" name="AREA_BLOCK_ID[]" value="<?=$field->getId();?>">
		<?php
		switch($field->getType())
		{
			case AreaField::BLOCK_TYPE_STRING:
				?>
				<tr>
					<td class="adm-detail-content-cell-l">
						<div><?=$field->getName();?>:</div>
						<div style="color:darkgray;">[<?=$field->getCode();?>]</div>
					</td>
					<td class="adm-detail-content-cell-r">


						<?php
						if($field->getMultiple())
						{
							for($i = 0; $i < 5; $i++)
							{
								$_values = null;
								if($content)
								{
									$_values = $content->getValueEx();
								}
								?>
								<div style="margin-bottom: 5px;">
									<input
										type="text"
										name="<?=$field->getCode();?>[<?=$field->getId();?>][]"
										<?=$_values ? 'value="' . $_values[$i] . '"' : '';?>
									>
								</div>
								<?php
							}
						} else
						{
							?>
							<input
								type="text"
								name="<?=$field->getCode();?>[<?=$field->getId();?>]"
								<?=$content ? 'value="' . $content->getValueEx() . '"' : '';?>
							>
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
						<div><?=$field->getName();?>:</div>
						<div style="color:darkgray;">[<?=$field->getCode();?>]</div>
					</td>
					<td class="adm-detail-content-cell-r">
						<?php
						if($field->getMultiple())
						{
							$_values = null;
							if($content)
							{
								$_values = $content->getValueEx();
							}
							for($i = 0; $i < 5; $i++)
							{
								?>
								<div style="margin-bottom: 5px;">
								<textarea
									name="<?=$field->getCode();?>[<?=$field->getId();?>][]"
									rows="10"
									cols="35"
								><?=$_values ? $_values[$i] : null;?></textarea>
								</div>
								<?php
							}
						} else
						{
							?>
							<textarea name="<?=$field->getCode();?>[<?=$field->getId();?>]" rows="10"
									  cols="35"><?=$content ? $content->getValueEx() : null;?></textarea>
							<?php
						}
						?>

					</td>
				</tr>
				<?php
				break;
			case AreaField::BLOCK_TYPE_IMAGE:
				?>
				<tr>
					<td class="adm-detail-content-cell-l">
						<div><?=$field->getName();?>:</div>
						<div style="color:darkgray;">[<?=$field->getCode();?>]</div>
						<div style="color:red;">Старые картинки затираются</div>
					</td>
					<td class="adm-detail-content-cell-r">
						<?php


						if($field->getMultiple())
						{
							$inputName = [];
							if($content)
							{
								foreach($content->getValueEx() as $index => $imageData)
								{
									$inputName[$field->getCode() . '[' . $field->getId() . '][' . $index . ']'] = $imageData['ID'];
								}
							}

							echo FileInput::createInstance([
								"name"        => $field->getCode() . '[' . $field->getId() . '][n#IND#]',
								"description" => true,
								"upload"      => true,
								"allowUpload" => "A",
								"medialib"    => true,
								"fileDialog"  => true,
								"cloud"       => true,
								"delete"      => true,
							])->show($inputName);
						} else
						{
							$imageId = null;
							if($content)
							{
								$imageValue = $content->getValueEx();
								if(!empty($imageValue['ID']))
								{
									$imageId = $imageValue['ID'];
								}
							}
							echo FileInput::createInstance([
								"name"        => $field->getCode() . '[' . $field->getId() . ']',
								"description" => true,
								"upload"      => true,
								"allowUpload" => "A",
								"medialib"    => true,
								"fileDialog"  => true,
								"cloud"       => true,
								"delete"      => true,
								'maxCount'    => 1,
							])->show($imageId);
						}
						?>
					</td>
				</tr>
				<?php
				break;
			case AreaField::BLOCK_TYPE_HTML:
				?>
				<tr>
					<td class="adm-detail-content-cell-l">
						<div><?=$field->getName();?>:</div>
						<div style="color:darkgray;">[<?=$field->getCode();?>]</div>
					</td>
					<td class="adm-detail-content-cell-r">
						<?php
						$name = $field->getCode() . '[' . $field->getId() . ']';
						$value = $content ? $content->getValueEx() : null;

						if(CModule::IncludeModule("fileman"))
						{
							$id = preg_replace("/[^a-z0-9]/i", '', $name);
							ob_start();
							echo '<input type="hidden" name="' . $name . '[TYPE]" value="html">';
							$LHE = new CHTMLEditor();
							$LHE->Show([
								'id'               => $id,
								'width'            => '100%',
								'height'           => '400',
								'minBodyWidth'     => 350,
								'normalBodyWidth'  => 555,
								'autoResize'       => true,
								'inputName'        => $name,
								'content'          => htmlspecialchars_decode($value),
								'bUseFileDialogs'  => false,
								'bFloatingToolbar' => true,
								'bArisingToolbar'  => false,
							]);
							echo ob_get_clean();
						} else
						{
							?>
							<textarea name="<?=$name;?>" style="width: 100%; height: 400px;"><?=$value;?></textarea>
							<?php
						}
						?>
					</td>
				</tr>
				<?php
				break;
			case AreaField::BLOCK_TYPE_COMPLEX:
				?>
				<tr>
					<td class="adm-detail-content-cell-l">

					</td>
					<td class="adm-detail-content-cell-r">

						<table data-add-row-complex-target>
							<?=ComplexRow::render($field, $content);?>
						</table>

						<?php
						if($field->getMultiple())
						{
							?>
							<button
								type="button"
								class="btn-main"
								data-field-id="<?=$field->getId();?>"
								data-add-row-complex
							>Добавить
							</button>
							<?php
						}
						?>


					</td>
				</tr>
				<?php
				break;
		}
	}
	?>
	<?php
} else
{
	echo 'Блоки не найдены';
	echo '<br>';
	echo '<a href="craft_area_edit.php?ID=' . $areaId . '">Добавить</a>';
}

$tabControl->EndCustomField('CONTENT');


$tabControl->Buttons([
	"disabled" => false,
	"back_url" => "craft_area_list.php?lang=" . LANG,
]);

$tabControl->Show();

?>
	<script>
        const jsParams = <?=json_encode([
			'ajaxUrl' => '/local/modules/craft.area/tool/',
		])?>

        new JediArea(jsParams);
	</script>
<?php

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_admin.php");