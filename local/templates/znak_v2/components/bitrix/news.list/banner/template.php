<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true){
    die();
}

$id = $arParams["SLIDER_ID"] ?? "banner";
?>

<div id="<?= $id ?>" class="swiper">
    <div class="swiper-wrapper">
        <?php foreach ($arResult["ITEMS"] as $item): ?>
            <a 
                href="<?= ($item["PROPERTIES"]["LINK"]["VALUE"]) ?: 'javascript:void(0)' ?>" 
                class="swiper-slide banner-swiper"
            >
                <picture>
                    <?php 
                    $mobile = CFile::ResizeImageGet(
                        $item["PROPERTIES"]["IMAGE_MOBILE"]["VALUE"],
                        ['width' => 528, 'height' => 660],
                        BX_RESIZE_IMAGE_EXACT,
                        true,
                    );
                    
                    $tablet = CFile::ResizeImageGet(
                        $item["PROPERTIES"]["IMAGE_TABLET"]["VALUE"],
                        ['width' => 660, 'height' => 264],
                        BX_RESIZE_IMAGE_EXACT,
                        true,
                    );
                    
                    $desktop = CFile::ResizeImageGet(
                        $item["PREVIEW_PICTURE"]["ID"],
                        ['width' => 1180, 'height' => 264],
                        BX_RESIZE_IMAGE_EXACT,
                        true,
                    );
                    
                    if (empty($desktop['src'])) {
                        $desktop['src'] = $item["PREVIEW_PICTURE"]["SRC"];
                    }
                    ?>
                    
                    <?php if (!empty($mobile['src'])): ?>
                        <source media="(max-width: 767px)" srcset="<?= $mobile['src'] ?>">
                    <?php endif; ?>
                    
                    <?php if (!empty($tablet['src'])): ?>
                        <source media="(max-width: 989px)" srcset="<?= $tablet['src'] ?>">
                    <?php endif; ?>
                    
                    <img 
                        src="<?= $desktop['src'] ?>" 
                        alt="Баннер-<?= htmlspecialcharsbx($item['NAME']) ?>"
                        loading="lazy"
                        width="1180"
                        height="264"
                    >
                </picture>
            </a>    
        <?php endforeach; ?>
    </div>
   
</div>