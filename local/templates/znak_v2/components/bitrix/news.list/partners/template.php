<?php
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

/**
 * @var array $arResult
 * @var array $arParams
 */
?>

<div class="partners">
    <div id="partners-list" class="swiper">
        <?php if(!empty($arResult["ITEMS"])):?>
        <div class="swiper-wrapper">
            <?php foreach($arResult["ITEMS"] as $arItem): 
                $pictureId = $arItem["PREVIEW_PICTURE"]["ID"] ?? false;
                
                if ($pictureId) {
                        $img = CFile::ResizeImageGet(
                            $pictureId,
                            ["width" => 300, "height" => 200],
                            BX_RESIZE_IMAGE_PROPORTIONAL,
                            true
                        );
                        $imgSrc    = $img["src"];
                    } else {
                        $imgSrc = SITE_TEMPLATE_PATH . "/images/no-image.png";
                    }
                
            ?>
            <!-- partner item start-->
            <div class="swiper-slide">
                <div class="partner-item"> 
                    <img
                        src="<?= htmlspecialcharsbx($imgSrc) ?>"
                        alt="<?= htmlspecialcharsbx($arItem["NAME"]) ?>"
                    >
                </div>
            </div>
            <!-- partner item end-->
            <? endforeach;?>
        </div>
        <?php else:?>
        <div class="empty-state">
            <div class="empty-state-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
            </div>
            <h3 class="empty-state-title">Партнеры не загружены</h3>
            <p class="empty-state-description">Чтобы узнать точный список наших партнеров обратитесь к администратору сайта</p>
        </div>
        <?php endif;?>
    </div>
</div>