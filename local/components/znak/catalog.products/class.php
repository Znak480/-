<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Context;

class ZnakCatalogProductComponent extends CBitrixComponent{
    public function onPrepareComponentParams($arParams){
        $arParams['ELEMENTS_COUNT'] = intval($arParams['ELEMENTS_COUNT']) ?: 4;
        $arParams['IBLOCK_ID'] = intval($arParams['IBLOCK_ID']) ?: 0;
        
        return $arParams;
    }

    public function executeComponent(){
       if (!\CModule::IncludeModule('iblock')) {
            return;
        }
        $this->arResult['ITEMS'] = $this->getProducts();

        foreach ($this->arResult['ITEMS'] as &$item) {
            $badgeData = $this->getItemBadge($item);
            $item['BADGE_DATA'] = $badgeData;
            $item["ADDITIONAL_CLASSES"] = $this->arParams['ADDITIONAL_CLASSES'] ?? "";
        }
       
        global $currentCity;
        $this->arResult['CURRENT_CITY'] = $currentCity;
        $this->arResult['TITLE'] = $this->arParams['TITLE'];
        
        if (Context::getCurrent()->getRequest()->get('ajax') == 'Y') {
            $this->returnAjaxResult();
            return;
        }
        $this->includeComponentTemplate();
    }

    private function getProducts(){
        $products = [];
        $arFilter = [
            "IBLOCK_ID" => $this->arParams["IBLOCK_ID"],
            "ACTIVE_DATE" => "Y",
            "ACTIVE" => "Y",
            '!NAME' => false,
        ];

        if (!empty($this->arParams['FILTER'])) {
            $arFilter = array_merge($arFilter, $this->arParams['FILTER']);
        }

        $arSort = [];
        if ($this->arParams['SORT_BY'] == 'RAND') {
            $arSort = ["RAND" => "RAND"];
        } else {
            $arSort = [
                $this->arParams['SORT_BY'] => $this->arParams['SORT_ORDER']
            ];
        }

        $arSelect = array(
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
        );

        $res = CIBlockElement::GetList(
            $arSort, 
            $arFilter, 
            false, 
            array("nTopCount" => $this->arParams['ELEMENTS_COUNT']), 
            $arSelect
        );
        
        while ($ob = $res->GetNextElement()) {
            $arFields = $ob->GetFields();
            $arProps = $ob->GetProperties();
            
            $priceId = $GLOBALS['currentCity']['PRICE_ID']['VALUE'];
            $priceCode = $GLOBALS['currentCity']['PRICE_CODE']['VALUE'];
            
            $priceValue = $arFields['CATALOG_PRICE_' . $priceId];
            
            $arFields['PRICES'] = array(
                $priceCode => array(
                    "VALUE" => $priceValue,
                    "PRINT_VALUE" => $priceValue . " р."
                )
            );
            
            $arFields['PROPERTIES'] = $arProps;
            
            $arFields['ITEM_PRICES'] = array(
                array(
                    "PRICE" => $priceValue,
                    "PRINT_PRICE" => $priceValue . " р."
                )
            );
            
            if ($arFields['PREVIEW_PICTURE']) {
                $arFields['PREVIEW_PICTURE'] = CFile::GetFileArray($arFields['PREVIEW_PICTURE']);
            }
            
            $products[] = $arFields;
        }

        return $products;
    }

    private function getItemBadge($item){
        $badgeData = ProductBadgeManager::getInstance()->getBadges($item);
        return $badgeData;
    }

    private function returnAjaxResult(){
        global $APPLICATION;
        $APPLICATION->RestartBuffer();
        header('Content-Type: application/json');
        echo json_encode($this->arResult);
        die();
    }
}
?>