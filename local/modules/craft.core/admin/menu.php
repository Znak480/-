<?php

if(!\Bitrix\Main\Loader::includeModule('craft.core'))
{
	return;
}

//global_menu_content - раздел "Контент"
//global_menu_marketing - раздел "Маркетинг"
//global_menu_store - раздел "Магазин"
//global_menu_services - раздел "Сервисы"
//global_menu_statistics - раздел "Аналитика"
//global_menu_marketplace - раздел "Marketplace"
//global_menu_settings - раздел "Настройки"

$aMenu = [
	"parent_menu" => "global_menu_content",
	"section"     => "craft.develop",
	"sort"        => 1000,
	"text"        => '[craft] Управление сайтом',
	"title"       => 'Управление сайтом',
	"icon"        => "iblock_menu_icon_settings",
	"page_icon"   => "iblock_menu_icon_settings",
	"items_id"    => "menu_craft_develop",
	"items"       => [
		[
			"text"  => "Поисковые синонимы",
			"url"   => CRAFT_DEVELOP_ADMIN_URL_SYNONYMS_LIST . "?lang=" . LANG,
			"title" => "Поисковые синонимы",
		],
	],

];

return (!empty($aMenu) ? $aMenu : false);