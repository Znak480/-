<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_before.php");

/**
 * @global CMain $APPLICATION
 */

$APPLICATION->SetTitle("Поисковые синонимы");

use Bitrix\Main\Application;
use Bitrix\Main\Loader;
use Craft\Orm\SearchSynonymTable;

foreach(['craft.core'] as $module)
{
	if(!Loader::includeModule($module))
	{
		$APPLICATION->ThrowException('Не подключен модуль ' . $module);
	}
}

$request = Application::getInstance()->getContext()->getRequest();

if($request->get('action_button') || $request->getPost('action_button'))
{
	$id = $request->get('ID') ?? $request->getPost('ID');
	if(!is_array($id))
	{
		$id = [$id];
	}

	if($id)
	{
		foreach($id as $_id)
		{
			try
			{
				SearchSynonymTable::delete($_id);
			} catch(Exception $e)
			{
			}
		}
	}

}

$res = SearchSynonymTable::getList([
	'order' => [
		SearchSynonymTable::F_ID => 'DESC',
	],
]);

$POST_RIGHT = $APPLICATION->GetGroupRight("craft.develop");
$table_id = SearchSynonymTable::getTableName(); // ид таблицы
$lAdmin = new CAdminList($table_id);

// Какие поля выводить
$lAdmin->AddHeaders([
	['id' => SearchSynonymTable::F_ID, 'content' => 'ID', 'default' => true],
	['id' => SearchSynonymTable::F_SEARCH_ITEMS, 'content' => 'Поисковые синонимы', 'default' => true],
]);

$data = new CAdminResult($res, $table_id);

while($element = $data->NavNext(true, "f_"))
{
	/**
	 * @var int $f_ID
	 * @var string $f_SEARCH_ITEMS
	 */


	$model = SearchSynonymTable::getByPrimary($f_ID)->fetchObject();

	// создание строки (экземпляра класса CAdminListRow)
	$row =& $lAdmin->AddRow($f_ID, $element);

	$row->AddCheckField("ACTIVE");

	$items = [];
	if($f_SEARCH_ITEMS)
	{
		$items = $model->getSearchItemsEx();
	}

	$row->AddViewField(SearchSynonymTable::F_SEARCH_ITEMS, implode(' / ', $items));

	$arActions = [];
	$arActions[] = [
		"ICON"    => "edit",
		"DEFAULT" => true,
		"TEXT"    => 'Изменить',
		"ACTION"  => $lAdmin->ActionRedirect(CRAFT_DEVELOP_ADMIN_URL_SYNONYMS_EDIT . "?ID=" . $f_ID),
	];

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
		"TEXT"  => 'Добавить синонимы',
		"LINK"  => CRAFT_DEVELOP_ADMIN_URL_SYNONYMS_EDIT . "?lang=" . LANG,
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
