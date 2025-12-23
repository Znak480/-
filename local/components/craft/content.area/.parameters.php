<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?php

if(!\Bitrix\Main\Loader::includeModule('craft.area'))
{
	return;
}

$arComponentParameters = [
	"GROUPS"     => [
		"SETTINGS" => [
			"NAME" => 'Настройки',
			"SORT" => 550,
		],
	],
	"PARAMETERS" => [
		"CODE" => [
			"PARENT"            => "SETTINGS",
			"NAME"              => 'Редактируемый блок',
			"TYPE"              => "LIST",
			"ADDITIONAL_VALUES" => "Y",
			"VALUES"            => \Craft\Area\Component\ParametersHelper::getAreaList(),
		],
	],
];