<?php 
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true){
    die();
}

class RegionsComponent extends CBitrixComponent{
    public function executeComponent(){
        $iblockId = $this->arParams['IBLOCK_ID'] ?? 18;

        $this->arResult['ITEMS'] = $this->getRegions($iblockId);

        if(empty($this->arResult['ITEMS'])){
            $this->arResult['ERROR'] = 'Регионы не найдены';
        }

        $this->includecomponentTemplate();
    }

    private function getRegions($iblockId){
        if (!\CModule::IncludeModule('iblock')) {
            return [];
        }

        $result = [];
        $rsElement = CIBlockElement::GetList(
            $arOrder  = array("SORT" => "ASC"),
            $arFilter = array(
                'IBLOCK_ID'  => $iblockId,
                "ACTIVE"    => "Y"
            ),
            false,
            false,
            $arSelectFields = array("ID", "NAME","XML_ID", "PROPERTY_DOMAIN")
        );
       
        while($arElement = $rsElement->GetNextElement()) {
            $fields = $arElement->GetFields();
            $props = $arElement->GetProperties();

            $result[] = [
                'ID' => $fields['ID'],
                'NAME' => $fields['NAME'],
                'EXTERNAL_ID' => $fields['XML_ID'],
                'PROPERTIES' => [
                    'DOMAIN' => $fields['PROPERTY_DOMAIN_VALUE'] ?? '',
                    'ADDRESS' => $props['ADDRESS']['VALUE'] ?? '',
                    'PHONE' => $props['PHONE']['VALUE'] ?? '',
                    'PHONE_HREF' => $props['PHONE_HREF']['VALUE'] ?? '',
                    'WORKTIME' => $props['WORKTIME']['VALUE'] ?? '',
                ]
            ];
        }
        return $result;
    }
}
?>