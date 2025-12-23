<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
global $currentCity;
//debug($_SESSION["CATALOG_COMPARE_LIST"][$currentCity['IBLOCK_CATALOG']['VALUE']]['ITEMS']);
//debug($arResult);
//debug($arParams['PRODUCT_ID']);
?>
<?if($arResult):?>
    <?if(!isset($_SESSION["CATALOG_COMPARE_LIST"][$currentCity['IBLOCK_CATALOG']['VALUE']]["ITEMS"][$arParams['PRODUCT_ID']])):?>
        К сравнению
    <?else:?>
        <a href="/compare/">Перейти к сравнению</a>
    <?endif?>
<?else:?>
    К сравнению
<?endif;?>
