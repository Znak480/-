<?
namespace Znak\Price;

use Bitrix\Main\Loader;
use Bitrix\Iblock\Iblock;
Loader::includeModule("iblock");
Loader::includeModule("catalog");



class PriceProcessor{

    public static function calcPrice($priceData) {    
        $currentPrice = isset($priceData['PRICE']) 
            ? $priceData['PRICE'] 
            : 0;
        
        $stock = isset($priceData['AKTSIYA']) 
            ? (int)$priceData['AKTSIYA'] 
            : 0;
        
        $discount = isset($priceData['SKIDKA']) 
            ? (int)$priceData['SKIDKA'] 
            : 0;
        
        $stock = min($stock, 100);
        $discount = min($discount, 100);
        $isChanged = true;

        $calcDiscount = fn($procent) => $currentPrice * (1 - $procent / 100);

        if ($discount > 0) {
            $cardPrice = $calcDiscount($discount); 
            $discountPercent = $discount;
        } elseif ($stock > 0) {
            $cardPrice = $calcDiscount($stock);
            $discountPercent = $stock;
        } else {
            $cardPrice = $currentPrice;
            $discountPercent = 0;
            $isChanged = false;
        }
        
        return [
            "CURRENT_PRICE" => $currentPrice,
            "DISCOUNT_PRICE" => $cardPrice,
            "DISCOUNTPERCENT_VALUE" => $discountPercent,
            "PRICE_CHANGED_FLAG" => $isChanged,
            "DISCOUNT_VALUE" => $currentPrice - $cardPrice,
            "DISCOUNT_TYPE" => $discount > 0 ? 'aktsiya' : ($stock > 0 ? 'card' : 'none')
        ];
    }

    /**
     * Основная функция обработки цен
     */
    public static function processPrices(&$arResult, $iblockId = null, $priceId = null) {
        global $currentCity;

        if (empty($arResult)) {
            return;
        }
        
        if ($iblockId === null) {
            $iblockId = (int)($currentCity['IBLOCK_CATALOG']['VALUE']);
        }
         
        if ($iblockId <= 0) {
            return;
        }

        if ($priceId === null) {
            $priceId = $currentCity['PRICE_ID']['VALUE'] ?? null;
        }
        
        if (empty($priceId)) {
            return;
        }

        $productIds = [];
        foreach ($arResult as $item) {
            $productIds[] = (int)$item['PRODUCT_ID'] ?? (int)$item['ID'];
        }

        if (empty($productIds)) {
            return;
        }

        $arSelect = [
            "ID",
            "NAME",
            "IBLOCK_SECTION_ID",
            "DATE_ACTIVE_FROM",
            "PREVIEW_PICTURE",
            "DETAIL_PAGE_URL",
            "CATALOG_GROUP_" . $priceId,
            "PROPERTY_SALE",
            "PROPERTY_DISCOUNT",
            "PROPERTY_HIT",
            "PROPERTY_RAITING_PRODAZH",
            "PROPERTY_AKTSIYA_",
            "PROPERTY_SKIDKA_PO_KARTE_",
        ];

        $res = \CIBlockElement::GetList(
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

            $priceData = [
                "PRICE" => $arFields['CATALOG_PRICE_' . $priceId],
                "AKTSIYA" => $arProps["AKTSIYA_"]["VALUE"],
                "SKIDKA" => $arProps["SKIDKA_PO_KARTE_"]["VALUE"]
            ];
            
            $prices[$arFields["ID"]] = self::calcPrice($priceData);
        }
        
        foreach ($arResult as &$item) {
            
            $item["PRICE_DATA"] = $prices[$item['PRODUCT_ID'] ?? $item["ID"]] ?? null;
        }
        unset($item);
    }   
}
?>