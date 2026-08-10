<?php 
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true){
    die();
}

global $currentCity;

$arResult["CURRENT_CITY"] = $currentCity;
$arResult['CURRENT_CITY_ID'] = $currentCity['EXTERNAL_ID'] ?? '';

foreach ($arResult['ITEMS'] as $item) {
    if ($item['EXTERNAL_ID'] == $arResult['CURRENT_CITY_ID']) {
        $arResult['CURRENT_CITY'] = $item;
        break;
    }
}

if (empty($arResult['CURRENT_CITY']) && !empty($arResult['ITEMS'])) {
    $arResult['CURRENT_CITY'] = $arResult['ITEMS'][0];
    $arResult['CURRENT_CITY_ID'] = $arResult['CURRENT_CITY']['EXTERNAL_ID'];
}

foreach ($arResult['ITEMS'] as &$item) {
    $item['ACTIVE'] = ($item['EXTERNAL_ID'] == $arResult['CURRENT_CITY_ID']);
}

$arResult['JS_DATA'] = [
    'CURRENT_CITY_ID' => $arResult['CURRENT_CITY_ID'],
    'CURRENT_CITY_NAME' => $arResult['CURRENT_CITY']['NAME'],
    'CURRENT_CITY_EXTERNAL_ID' => $arResult['CURRENT_CITY']['EXTERNAL_ID'],
];

unset($item);
?>
