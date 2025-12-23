<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_before.php");

use Bitrix\Main\Loader;
use Bitrix\Main\Application;
use Craft\Area\Entity\AreaTable;
use Craft\Area\Entity\AreaField;
use Craft\Area\Entity\AreaFieldTable;
use Craft\Area\Admin\Settings\AreaBlockRowHelper;

/**
 * @global CMain $APPLICATION
 */
$APPLICATION->SetTitle("Добавить блок - редактируемый контент");

foreach(['craft.area'] as $module)
{
	if(!Loader::includeModule($module))
	{
		$APPLICATION->ThrowException('Не подключен модуль ' . $module);
	}
}


CJSCore::Init([
	'craftArea',
]);

$request = Application::getInstance()->getContext()->getRequest();
$ID = $request->get('ID');

if($request->isPost())
{
	$areaModel = $ID ? AreaTable::getByPrimary($ID)->fetchObject() : AreaTable::createObject();

	$postParams = $request->getPostList()->toArray();
	$params = $postParams;

	$areaModel->fillFromArray($params);

	if($postParams['CONTENT_BLOCK'])
	{
		$fieldIdList = $postParams['CONTENT_BLOCK'][AreaFieldTable::FIELD_ID];
		$type = $postParams['CONTENT_BLOCK'][AreaFieldTable::FIELD_TYPE];
		$areaId = $postParams['CONTENT_BLOCK'][AreaFieldTable::FIELD_AREA_ID];
		$code = $postParams['CONTENT_BLOCK'][AreaFieldTable::FIELD_CODE];
		$name = $postParams['CONTENT_BLOCK'][AreaFieldTable::FIELD_NAME];
		$sort = $postParams['CONTENT_BLOCK'][AreaFieldTable::FIELD_SORT];
		$multiple = $postParams['CONTENT_BLOCK'][AreaFieldTable::FIELD_MULTIPLE];
		$settings = $postParams['CONTENT_BLOCK'][AreaFieldTable::FIELD_SETTINGS];

		$isDel = $postParams['CONTENT_BLOCK']['isDel'];

		$_skip = [];

		if(($areaModel && $areaModel->getId()) && $areaModel->fillFields())
		{
			foreach($areaModel->getFields() as $field)
			{
				$fieldId = $field->getId();
				if(!in_array($fieldId, $fieldIdList) || $isDel[$fieldId] == 'Y')
				{
					$_skip[] = $fieldId;
					$field->delete();
				}
			}
		}

		foreach($type as $index => $value)
		{
			$fieldId = $fieldIdList[$index];

			if(in_array($fieldId, $_skip))
			{
				continue;
			}

			$areaFieldModel = is_numeric($fieldId) ? AreaFieldTable::getByPrimary($fieldId)->fetchObject() : AreaFieldTable::createObject();
			$areaFieldModel->setType($value);

			if($areaId[$index])
			{
				$areaFieldModel->setAreaId($areaId[$index]);
			}

			if($code[$index])
			{
				$areaFieldModel->setCode($code[$index]);
			}

			if($name[$index])
			{
				$areaFieldModel->setName($name[$index]);
			}

			if($sort[$index])
			{
				$areaFieldModel->setSort($sort[$index]);
			}

			if($multiple[$index])
			{
				$areaFieldModel->setMultiple($multiple[$index]);
			}

			if($settings[$index])
			{
				$areaFieldModel->setSettings($settings[$index]);
			}

			$areaFieldModel->save();

			$areaModel->addToFields($areaFieldModel);
		}
	}

	$areaModel->save();

	$_GET['ID'] = $areaModel->getId();
	LocalRedirect($APPLICATION->GetCurPage() . "?" . http_build_query($_GET));
}


$areaModel = $ID ? AreaTable::getById($ID)->fetchObject() : null;

if($ID && !$areaModel)
{
	LocalRedirect(CRAFT_AREA_ADMIN_URL_LIST_AREA . "?lang=" . LANGUAGE_ID);
}

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_after.php");
$aTabs = [
	[
		"DIV"   => "edit1",
		"TAB"   => 'Настройки блока',
		"ICON"  => "iblock_section",
		"TITLE" => $areaModel ? 'Изменить: ' . $areaModel->getName() : 'Новый контентный блок',
	],
	[
		"DIV"   => "edit2",
		"TAB"   => 'Поля',
		"ICON"  => "iblock_section",
		"TITLE" => 'Поля',
	],
];
?>

	<div data-sys-msg class="sys-msg"></div>

<?php

if($ID)
{
	$aMenu = [];

	$aMenu[] = [
		"TEXT"  => 'Удалить блок',
		"TITLE" => 'Удалить блок',
		"LINK"  => JEDI_AREA_ADMIN_URL_EDIT_CONTENT . "?ID=" . $ID . "&action=delete&lang=" . LANGUAGE_ID,
		"ICON"  => "btn_delete",
	];
	if($areaModel->fillFields()->count() > 0)
	{
		$aMenu[] = [
			"TEXT"  => 'Управление контентом',
			"TITLE" => 'Управление контентом',
			"LINK"  => JEDI_AREA_ADMIN_URL_EDIT_CONTENT . "?ID=" . $ID . "&lang=" . LANGUAGE_ID,
			"ICON"  => "btn_new",
		];
	}
	$aMenu[] = [
		"TEXT"  => 'Список блоков',
		"TITLE" => 'Список блоков',
		"LINK"  => CRAFT_AREA_ADMIN_URL_LIST_AREA . "?lang=" . LANGUAGE_ID,
		"ICON"  => "btn_list",
	];

	$context = new CAdminContextMenu($aMenu);
	$context->Show();
}


$tabControl = new CAdminForm('craftAreaEditTabControl', $aTabs);
$tabControl->BeginEpilogContent();
?>
<?=bitrix_sessid_post()?>
<?php
if($ID)
{
	?>
	<input type="hidden" name="ID" value=<?=$ID?>>
	<?php
}
$tabControl->EndEpilogContent();
$tabControl->Begin();

$tabControl->BeginNextFormTab();

$entity = AreaTable::getEntity();

if($field = $entity->getField(AreaTable::FIELD_ACTIVE))
{
	$tabControl->AddCheckBoxField(
		$field->getName(),
		$field->getTitle(),
		$field->isRequired(),
		[AreaTable::ACTIVE_Y, AreaTable::ACTIVE_N],
		$areaModel ? $areaModel->getActive() : true
	);
}

if($field = $entity->getField(AreaTable::FIELD_NAME))
{
	$tabControl->AddEditField(
		$field->getName(),
		$field->getTitle(),
		$field->isRequired(),
		["size" => 35, "maxlength" => 255],
		$areaModel ? $areaModel->getName() : null
	);
}

if($field = $entity->getField(AreaTable::FIELD_CODE))
{
	$tabControl->AddEditField(
		$field->getName(),
		$field->getTitle(),
		$field->isRequired(),
		["size" => 35, "maxlength" => 255],
		$areaModel ? $areaModel->getCode() : null
	);
}

if($field = $entity->getField(AreaTable::FIELD_SORT))
{
	$tabControl->AddEditField(
		$field->getName(),
		$field->getTitle(),
		$field->isRequired(),
		["size" => 35, "maxlength" => 255],
		$areaModel ? $areaModel->getSort() : 500
	);
}

/*
$tabControl->BeginCustomField("ENTITY_ID", '', true);
$tabControl->EndCustomField("ENTITY_ID");
*/


if($ID && $areaModel)
{
	$tabControl->BeginNextFormTab();
	$tabControl->BeginCustomField("content", null, true);
	?>

	<div data-content-block-list class="craft-area-settings-list">
		<?php
		foreach($areaModel->fillFields() as $index => $areaFieldModel)
		{
			/* @var AreaField $areaFieldModel */
			$row = new  AreaBlockRowHelper($areaFieldModel, $ID);
			echo $row->render($index);
		}
		?>
	</div>


	<div>
		<input
			type="button"
			class="adm-btn-save"
			data-add-row-content-block
			data-area-id="<?=$ID;?>"
			value="Добавить"
		>
		<select data-select-type-block>
			<option value="">Выбрать значение</option>
			<?php
			foreach(AreaField::getBlockTypeList() as $type => $label)
			{
				?>
				<option value="<?=$type;?>"><?=$label;?></option>
				<?php
			}
			?>
		</select>
	</div>
	<?php
	$tabControl->EndCustomField("content");
}


$tabControl->Buttons([
	"disabled" => false,
	"back_url" => CRAFT_AREA_ADMIN_URL_LIST_AREA . "?lang=" . LANG,
]);

$tabControl->Show();
?>
	<script>

        const jsParams = <?=json_encode([
			'ajaxUrl' => '/local/modules/craft.area/tool/',
		])?>

        new JediArea(jsParams);
	</script>
<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_admin.php");
