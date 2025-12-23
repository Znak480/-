<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_before.php");

/**
 * @global CMain $APPLICATION
 */

$APPLICATION->SetTitle("Редактируемый контент");

use Bitrix\Main\Loader;
use Craft\Area\Entity\AreaTable;

foreach(['craft.area'] as $module)
{
	if(!Loader::includeModule($module))
	{
		$APPLICATION->ThrowException('Не подключен модуль ' . $module);
	};
}

$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();

if($request->getPost('action_button'))
{
	$elementIdList = $request->getPost('ID');
	if($elementIdList)
	{
		if(is_array($elementIdList))
		{
			$areaList = AreaTable::getList([
				'filter' => [
					'ID' => $elementIdList,
				],
			])->fetchCollection();

			foreach($areaList as $area)
			{
				try
				{
					$area->delete();
				} catch(\Bitrix\Main\ArgumentException $e)
				{

				} catch(\Bitrix\Main\SystemException $e)
				{

				}
			}
		}
	}
}


$res = AreaTable::getList([
	'order' => [
		AreaTable::FIELD_ID => 'DESC',
	],
]);
$POST_RIGHT = $APPLICATION->GetGroupRight("craft.area");
$table_id = AreaTable::getTableName(); // ид таблицы
$lAdmin = new CAdminList($table_id);

// Какие поля выводить
$lAdmin->AddHeaders([
	['id' => AreaTable::FIELD_ID, 'content' => 'ID', 'default' => true],
	['id' => AreaTable::FIELD_NAME, 'content' => 'Название', 'default' => true],
	['id' => AreaTable::FIELD_CODE, 'content' => 'Символьный код', 'default' => true],
	['id' => AreaTable::FIELD_ACTIVE, 'content' => 'Активность', 'default' => true],
	['id' => AreaTable::FIELD_SORT, 'content' => 'Сортировка', 'default' => true],
]);

$data = new CAdminResult($res, $table_id);

while($element = $data->NavNext(true, "f_"))
{
	/**
	 * @var int $f_ID
	 * @var string $f_NAME
	 */


	$area = AreaTable::getByPrimary($f_ID)->fetchObject();

	// создание строки (экземпляра класса CAdminListRow)
	$row =& $lAdmin->AddRow($f_ID, $element);

	$row->AddCheckField("ACTIVE");

	$arActions = [];
	$arActions[] = [
		"ICON"    => "edit",
		"DEFAULT" => true,
		"TEXT"    => 'Изменить',
		"ACTION"  => $lAdmin->ActionRedirect(CRAFT_AREA_ADMIN_URL_EDIT_AREA . "?ID=" . $f_ID),
	];

	if($area->fillFields()->count() > 0)
	{
		$arActions[] = [
			"ICON"    => "edit",
			"DEFAULT" => true,
			"TEXT"    => 'Контент',
			"ACTION"  => $lAdmin->ActionRedirect(JEDI_AREA_ADMIN_URL_EDIT_CONTENT . "?ID=" . $f_ID),
		];
	}

	if($POST_RIGHT >= "W")
	{
		$arActions[] = [
			"ICON"   => "delete",
			"TEXT"   => 'Удалить',
			"ACTION" => "if(confirm('Точно удалить " . $f_NAME . "?')) " . $lAdmin->ActionDoGroup($f_ID, "delete"),
		];
	}

	$row->AddActions($arActions);

}


$lAdmin->AddFooter(
	[
		["title" => "Количество записей", "value" => $res->getSelectedRowsCount()], // кол-во элементов
		["counter" => true, "title" => 'Выбрано записей', "value" => "0"], // счетчик выбранных элементов
	]
);

$lAdmin->AddGroupActionTable([
	"delete"     => 'Удалить',
	"activate"   => 'Активировать',
	"deactivate" => 'Деактивировать',
]);

$aContext = [
	[
		"TEXT"  => 'Добавить новую область',
		"LINK"  => CRAFT_AREA_ADMIN_URL_EDIT_AREA . "?lang=" . LANG,
		"TITLE" => 'Создать',
		"ICON"  => "btn_new",
	],
];

$lAdmin->AddAdminContextMenu($aContext);

$lAdmin->CheckListMode();

$rsData = new CAdminResult($res, $table_id);
$rsData->NavStart();
$lAdmin->NavText($rsData->GetNavPrint('Элементы'));

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_after.php");

// Вывод данных
$lAdmin->DisplayList();


require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_admin.php");
?>
