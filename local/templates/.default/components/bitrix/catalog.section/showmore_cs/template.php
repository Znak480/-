<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();


?>
<!--    <div class="products__list" style="overflow: hidden">-->
<? foreach ($arResult["ITEMS"] as $arItem): ?>
    <?
    $APPLICATION->IncludeFile(
        "/local/include/card-product.php",
        Array(
            "arItem" => $arItem
        ),
        Array("MODE" => "PHP")
    );
    ?>
<? endforeach; ?>
<!--    </div>-->
<div class="clear"></div>
<div class="products_other">
    <? if ($arResult['NAV_RESULT']->PAGEN < $arResult['NAV_RESULT']->NavPageCount) { ?>
        <div class="products__more">
            <button class="btn">Показать еще</button>
        </div>
    <? } ?>
    <div class="control paging">
        <? echo $arResult["NAV_STRING"]; ?>
    </div>
</div>

