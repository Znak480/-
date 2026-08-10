<? if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die(); ?>

<? foreach ($arResult['ITEMS'] as $arItem): ?>
    <? $APPLICATION->IncludeFile(
        "/local/include/card-product.php",
        ["arItem" => $arItem],
        ["MODE" => "PHP"]
    ); ?>
<? endforeach; ?>