<?php

if(!\Bitrix\Main\Loader::includeModule('craft.area'))
{
	return;
}

$aMenu = [
	"parent_menu" => "global_menu_content",
	"section"     => "craft.area",
	"sort"        => 1000,
	"url"         => CRAFT_AREA_ADMIN_URL_LIST_AREA . "?lang=" . LANG,
	"text"        => '[craft] Редактируемые блоки',
	"title"       => 'Редактируемые блоки',
	"icon"        => "iblock_menu_icon_settings",
	"page_icon"   => "iblock_menu_icon_settings",
	"items_id"    => "menu_craft_area",
	"items"       => [
	],

];

return (!empty($aMenu) ? $aMenu : false);