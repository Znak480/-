<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Loader;
use Bitrix\Iblock\Iblock;
Loader::includeModule("iblock");
Loader::includeModule("catalog");

function calcPrice($priceData) {
    $currentPrice = isset($priceData['PRICE']) ? (float)$priceData['PRICE'] : 0;
    $aktsiya = isset($priceData['AKTSIYA']) ? (int)$priceData['AKTSIYA'] : 0;
    $skidka = isset($priceData['SKIDKA']) ? (int)$priceData['SKIDKA'] : 0;

    $aktsiya = min($aktsiya, 100);
    $skidka = min($skidka, 100);

    $maxDiscount = max($aktsiya, $skidka);

    $isChanged = false;
    $discountPercent = 0;
    $discountType = 'none';

    if ($maxDiscount > 0) {
        $isChanged = true;
        $discountPercent = $maxDiscount;
        $discountType = ($aktsiya >= $skidka) ? 'aktsiya' : 'card';
    }

    $cardPrice = $currentPrice * (1 - $discountPercent / 100);

    return [
        "CURRENT_PRICE" => $currentPrice,
        "DISCOUNT_PRICE" => $cardPrice,
        "DISCOUNTPERCENT_VALUE" => $discountPercent,
        "PRICE_CHANGED_FLAG" => $isChanged,
        "DISCOUNT_TYPE" => $discountType
    ];
}

if (empty($arResult['ITEMS'])) {
    return;
}

$productIds = [];
foreach ($arResult['ITEMS'] as $item) {
    $productIds[] = (int)$item['ID'];
}

if (empty($productIds)) {
    return;
}

$iblockId = (int)($arParams['IBLOCK_ID'] ?? 0);
if ($iblockId <= 0) {
    return;
}

$arSelect = [
    "ID",
    "NAME",
    "IBLOCK_SECTION_ID",
    "DATE_ACTIVE_FROM",
    "PREVIEW_PICTURE",
    "DETAIL_PAGE_URL",
    "CATALOG_GROUP_" . $GLOBALS['currentCity']['PRICE_ID']['VALUE'],
    "PROPERTY_SALE",
    "PROPERTY_DISCOUNT",
    "PROPERTY_HIT",
    "PROPERTY_RAITING_PRODAZH",
    "PROPERTY_AKTSIYA_",
    "PROPERTY_SKIDKA_PO_KARTE_",
];

$res = CIBlockElement::GetList(
    [],
    [
        "IBLOCK_ID" => $iblockId,
        "ID" => $productIds,
        "ACTIVE_DATE" => "Y",
        "ACTIVE" => "Y",
    ],
    false,
    false,
    $arSelect
);

$prices = [];
while ($ob = $res->GetNextElement()) {
    $arFields = $ob->GetFields();
    $arProps = $ob->GetProperties();
    
    $priceId = $GLOBALS['currentCity']['PRICE_ID']['VALUE'];

    $priceData = [
        "PRICE" => $arFields['CATALOG_PRICE_' . $priceId],
        "AKTSIYA" => $arProps["AKTSIYA_"]["VALUE"],
        "SKIDKA" => $arProps["SKIDKA_PO_KARTE_"]["VALUE"]
    ];
    $result = calcPrice($priceData);
    $prices[$arFields["ID"]] = $result;
}

foreach($arResult["ITEMS"] as &$item){
    $item["PRICE_DATA"] = $prices[$item["ID"]];
}
unset($item);
?>