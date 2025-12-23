<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>

<ul class="feautures__list">
    <?foreach ($arResult['ITEMS'] as $arItem){?>
    <li class="feautures__item">
        <div class="feautures__item-ico">
            <?$file = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE']['ID'], array('width'=>50, 'height'=>50), BX_RESIZE_IMAGE_PROPORTIONAL, true); ?>
            <img src="<?=$file['src']?>" alt="">
        </div>
        <p><?=$arItem['PREVIEW_TEXT']?></p>
    </li>
    <?}?>
</ul>
