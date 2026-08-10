<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/** @var array $arItem */
/** @var string $cardClass - дополнительные классы */
/** @var string $cardId - ID для кнопок редактирования */
?>

<div class="card-service <?= $cardClass?>" id="<?= $cardId ?>">
    <div class="card-service-content">
        <div class="card-service-text-wrapper">
            <h1 class="card-service-title"><?= htmlspecialcharsbx($arItem["NAME"])?></h1>
             <?php if (!empty($arItem["PREVIEW_TEXT"])): ?>
                <p class="card-service-description">
                    <?= htmlspecialcharsbx($arItem["PREVIEW_TEXT"]) ?>
                </p>
            <?php endif; ?>
        </div>
        <div class="card-service-image-wrapper">
            <?php if (!empty($arItem["PREVIEW_PICTURE"]["SRC"])): ?>

                <? $file = CFile::ResizeImageGet(
                    $arItem["PREVIEW_PICTURE"]["ID"], 
                    ['width' => '256', 'height' => '256'],
                    BX_RESIZE_IMAGE_PROPORTIONAL,
                    true
                  ); 
                ?>
                <img 
                    src="<?= $file['src']?>" 
                    alt="<?= htmlspecialcharsbx($arItem["NAME"])?>" 
                    loading="lazy"
                >
            <?else: ?>
                <img src="/assets/image/plug-popular.webp" alt="Нет изображения">
            <?endif; ?>
        </div>
    </div>
</div>