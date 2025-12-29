<?php

use Craft\Helper\UrlHelper;

CModule::IncludeModule('iblock');

global $currentCity;

$arSelect = ["ID", "IBLOCK_ID", "NAME", "EXTERNAL_ID", "PROPERTY_*"];//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
$res = CIBlockElement::GetList([], ["IBLOCK_ID" => "18", "ACTIVE" => "Y"], false, ["nPageSize" => 50], $arSelect);


$cnt = 0;
$arFieldsDefault = [];
$arPropsDefault = [];
while($ob = $res->GetNextElement())
{
	$arFields = $ob->GetFields();
	$arProps22 = $ob->GetProperties();
	if($cnt == 0)
	{
		$arFieldsDefault = $arFields;
		$arPropsDefault = $arProps22;
	}
	if($arProps22['DOMAIN']['VALUE'] == UrlHelper::domain())
	{
		$currentCity = array_merge($arFields, $arProps22);
		define("CITY_CODE", $arFields['EXTERNAL_ID']);
		break;
	}
	$cnt++;
}
// если не попали в домен
if(!defined('CITY_CODE'))
{
	$currentCity = array_merge($arFieldsDefault, $arPropsDefault);
	define("CITY_CODE", $arFieldsDefault['EXTERNAL_ID']);
}
define("IBLOCK_PRODUCTS_ID", 19);

?>