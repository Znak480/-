<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$dataAjax = $arResult['NAV_RESULT']->NavPageCount.",".
            $arResult['ID'].",".
            $arParams['PAGE_ELEMENT_COUNT'].",".
            $arParams['ELEMENT_SORT_FIELD'].",".
            $arParams['ELEMENT_SORT_ORDER'];
?>

<div class="catalog-products-list">
    <? foreach ($arResult["ITEMS"] as $arItem): ?>
        <?$APPLICATION->IncludeFile(
            "/local/include/card-product.php",
            Array(
                "arItem" => $arItem
            ),
            Array("MODE" => "PHP")
        );
        ?>
    <? endforeach; ?>
</div>


<?$APPLICATION->IncludeComponent(
    "bitrix:system.pagenavigation",
    "modern",
    array(
        "NAV_RESULT" => $arResult["NAV_RESULT"],
        "NAV_PARAMS" => $arResult["NAV_PARAMS"],
        "PAGER_PARAMS" => $arParams["PAGER_PARAMS_NAME"],
    ),
    $component
);
?>

