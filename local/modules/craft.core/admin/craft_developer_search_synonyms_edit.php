<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_before.php");
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/iblock/prolog.php');

/**
 * @global CMain $APPLICATION
 */

$APPLICATION->SetTitle("Поисковые синонимы");

use Bitrix\Main\Loader;
use Bitrix\Main\Application;
use Bitrix\Main\Page\Asset;
use Craft\Orm\SearchSynonymTable;

foreach(['craft.core'] as $module)
{
	if(!Loader::includeModule($module))
	{
		$APPLICATION->ThrowException('Не подключен модуль ' . $module);
	}
}

Asset::getInstance()->addJs('/bitrix/js/iblock/iblock_edit.js');


$request = Application::getInstance()->getContext()->getRequest();
$ID = $request->get('ID');
$searchModel = $ID ? SearchSynonymTable::getById($ID)->fetchObject() : SearchSynonymTable::createObject();
$entity = SearchSynonymTable::getEntity();
$error = null;


if($request->isPost())
{
	$postData = $request->getPostList()->toArray();
	foreach($postData as $name => $value)
	{
		if(!$entity->hasField($name) || $name === 'ID')
		{
			continue;
		}

		try
		{
			switch($name)
			{
				case SearchSynonymTable::F_SEARCH_ITEMS:

					$_data = $request->getPost(SearchSynonymTable::F_SEARCH_ITEMS);
					if(!is_array($_data))
					{
						throw new \Exception("Некорректный формат данных");
					}

					$values = array_values($_data);
					$values = array_filter($values);

					$searchModel->setSearchItemsEx($values ?? []);
					break;
				default:
					$searchModel->set($name, $value);
					break;
			}

		} catch(Exception $e)
		{
			$error = $e->getMessage();
		}
	}


	$result = $searchModel->save();

	if(!$result->isSuccess())
	{
		$error = implode("<br>", $result->getErrorMessages());
	}

	if(!$error)
	{
		$_GET['ID'] = $searchModel->getId();
		LocalRedirect($APPLICATION->GetCurPage() . "?" . http_build_query($_GET));
	}
}

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_after.php");
$aTabs = [
	[
		"DIV"   => "edit1",
		"TAB"   => 'Настройки',
		"ICON"  => "iblock_section",
		"TITLE" => $searchModel->getId() ? 'Изменить набор синонимов' : 'Новый набор синонимов',
	],
];


$tabControl = new CAdminForm('craftDeveloperEditTabControl', $aTabs);
if($error)
{
	CAdminMessage::ShowOldStyleError($error);
}
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


if($field = $entity->getField(SearchSynonymTable::F_SEARCH_ITEMS))
{

	$tabControl->BeginCustomField(SearchSynonymTable::F_SEARCH_ITEMS, '');
	$pointsValue = [];

	if($searchModel)
	{
		$pointsValue = array_reduce(
			$searchModel->getSearchItemsEx(),
			function($result, string $item) {
				$result[] = $item;
				return $result;
			}, []
		);
	}

	if($_areaPoints = $request->getPost(SearchSynonymTable::F_SEARCH_ITEMS))
	{
		foreach($_areaPoints as $key => $areaPointData)
		{
			$pointsValue[] = $areaPointData;
		}
	}
	?>


	<tr>
		<td>
			<span class="<?=$field->isRequired() ? 'adm-required-field' : '';?>">Поисковые синонимы</span>
		</td>
		<td>
			<?php
			_ShowStringPropertyField(
				SearchSynonymTable::F_SEARCH_ITEMS,
				[
					'MULTIPLE' => 'Y',
				],
				$pointsValue
			);
			?>
		</td>
	</tr>


	<?php

	$tabControl->EndCustomField(SearchSynonymTable::F_SEARCH_ITEMS);

}


$tabControl->Buttons([
	"disabled" => false,
	"back_url" => CRAFT_DEVELOP_ADMIN_URL_SYNONYMS_LIST . "?lang=" . LANG,
]);


$aMenu = [];
$aMenu[] = [
	"TEXT"  => 'К списку синонимов',
	"TITLE" => 'К списку синонимов',
	"LINK"  => CRAFT_DEVELOP_ADMIN_URL_SYNONYMS_LIST,
	'ICON'  => 'btn_list',
];

$context = new CAdminContextMenu($aMenu);
$context->Show();

$tabControl->Show();

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_admin.php");
?>