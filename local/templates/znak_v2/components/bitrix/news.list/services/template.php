<?php
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

if (empty($arResult["ITEMS"])) {
    return;
}

function renderServiceCard($item, $class, $template) {
    $template->AddEditAction(
        $item['ID'], 
        $item['EDIT_LINK'], 
        CIBlock::GetArrayByID($item["IBLOCK_ID"], "ELEMENT_EDIT")
    );
    $template->AddDeleteAction(
        $item['ID'], 
        $item['DELETE_LINK'], 
        CIBlock::GetArrayByID($item["IBLOCK_ID"], "ELEMENT_DELETE"),
        ["CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')]
    );
    
    $cardClass = $class;
    $cardId = $template->GetEditAreaId($item['ID']);
    $arItem = $item;
    include __DIR__ . '/card.php';
}

$this->setFrameMode(true);

$firstItem = !empty($arResult["ITEMS"]) ? array_shift($arResult["ITEMS"]) : null;

$sliderItems = $arResult["ITEMS"];
?>

<div class="section-content">
    <? if ($firstItem): ?>
        <?php renderServiceCard($firstItem, 'card-service--detail card-service--outside-slider', $this); ?>
    <? endIf; ?>
    <div id="services-slider2" class="swiper">
        <div class="swiper-wrapper">
            <? if ($firstItem): ?>
                <?php renderServiceCard($firstItem, 'swiper-slide card-service--detail card-service--inside-slider', $this); ?>
            <? endIf; ?>

            <?php foreach ($sliderItems as $item): ?>
                <?php renderServiceCard($item, 'swiper-slide card-service--slider-item', $this); ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>