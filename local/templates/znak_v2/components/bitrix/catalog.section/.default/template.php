<?php
/** @var array $arParams 
* @var array $arResult 
* @global CMain $APPLICATION 
* @global CUser $USER 
* @global CDatabase $DB 
* @var CBitrixComponentTemplate $this 
* @var string $templateName
* @var string $templateFile 
* @var string $templateFolder 
* @var string $componentPath 
* @var CBitrixComponent $component 
*/
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$bxajaxid = '';
if (isset($component) && isset($component->__template)) {
    $bxajaxid = CAjax::GetComponentID(
        $component->__name, 
        $component->__template->__name, 
        $component->arParams['AJAX_OPTION_ADDITIONAL']
    );
}

$isAjax = (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest');

if ($isAjax) {
    while (ob_get_level()) {
        ob_end_clean();
    }
}

if ($isAjax) {
    if (!empty($arResult["ITEMS"])) {
        foreach ($arResult["ITEMS"] as $arItem) {
            $APPLICATION->IncludeFile(
                "/local/include/card-product.php",
                ["arItem" => $arItem],
                ["MODE" => "PHP"]
            );
        }
    }

    $APPLICATION->IncludeComponent(
        "bitrix:system.pagenavigation",
        "modern",
        [
            "NAV_RESULT" => $arResult["NAV_RESULT"],
            "NAV_PARAMS" => $arResult["NAV_PARAMS"],
            "PAGER_PARAMS" => $arParams["PAGER_PARAMS_NAME"],
        ],
        $component
    );
    return;
}
?>

<div class="catalog-wrapper">
    <div class="catalog-products-list" id="products-list-<?=$bxajaxid?>">
        <?
        $banner = $arResult["BANNER"];
        if(!empty($banner)){
        ?>
            <div class="product-banner">
                <div class="product-banner-image">
                    <img src="<?= $banner["SRC"] ?>" alt="<?= $banner["NAME"] ?>">
                </div>
            </div>
        <?
        }
        ?>

        <?php
        if (!empty($arResult["ITEMS"])) {
            foreach ($arResult["ITEMS"] as $arItem) {
                $APPLICATION->IncludeFile(
                    "/local/include/card-product.php",
                    ["arItem" => $arItem],
                    ["MODE" => "PHP"]
                );
            }
        } else {
            echo '<div class="catalog-empty">Товары не найдены</div>';
        }
        ?>
    </div>
    <? if (isset($arResult["NAV_RESULT"]) && is_object($arResult["NAV_RESULT"])): ?>
        <? if ($arResult["NAV_RESULT"]->nEndPage > 1 && 
            $arResult["NAV_RESULT"]->NavPageNomer < $arResult["NAV_RESULT"]->nEndPage): ?>
        <div class="catalog-pagination-wrapper" id="catalog-pagination-<?=$bxajaxid?>" <?= $isAjax ? 'data-ajax="Y"' : '' ?>>
        
                <?
                $totalItems = (int)$arResult["NAV_RESULT"]->NavRecordCount;
                $currentPage = (int)$arResult["NAV_RESULT"]->NavPageNomer;
                $pageSize = (int)$arResult["NAV_RESULT"]->NavPageSize;
                $shownItems = $currentPage * $pageSize;
                $remainingItems = $totalItems - $shownItems;
                
                if ($remainingItems < 0) $remainingItems = 0;
                ?>
                    <button id="btn_<?=$bxajaxid?>" 
                        class="btn btn-primary btn-sm btn-load-more" 
                        data-ajax-id="<?=$bxajaxid?>" 
                        data-show-more="<?=$arResult["NAV_RESULT"]->NavNum?>" 
                        data-next-page="<?=($arResult["NAV_RESULT"]->NavPageNomer + 1)?>" 
                        data-max-page="<?=$arResult["NAV_RESULT"]->NavPageCount?>"
                        data-current-page="<?=$arResult["NAV_RESULT"]->NavPageNomer?>"
                        data-total-items-count="<?=(int)$totalItems?>"
                    >
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" class="load-more-icon">
                            <path d="M12 4V20M4 12H20" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                        </svg>
                        <span class="load-more-title">Показать еще</span>
                        <span class="load-more-count">(<?= $remainingItems ?>)</span>
                    </button>

                    <span class="pagination-divider">или</span>

            <? $APPLICATION->IncludeComponent(
                "bitrix:system.pagenavigation",
                "modern",
                [
                    "NAV_RESULT" => $arResult["NAV_RESULT"],
                    "NAV_PARAMS" => $arResult["NAV_PARAMS"],
                    "PAGER_PARAMS" => $arParams["PAGER_PARAMS_NAME"],
                ],
                $component
            );
            ?>
        </div>
        <? endif;?>
    <? endif;?>
</div>
