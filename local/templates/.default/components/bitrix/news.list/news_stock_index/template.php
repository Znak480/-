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

	<?foreach($arResult["ITEMS"] as $arItem):?>
        <div class="n-block">
            <a href="<?=$arItem['DETAIL_PAGE_URL']?>"></a>
            <div class="n-block__img">
                <?$file = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE']['ID'], array('width'=>266, 'height'=>230), BX_RESIZE_IMAGE_PROPORTIONAL, true); ?>
                <img src="<?=$file['src']?>" alt="">
            </div>
            <div class="n-block__info">
                <!-- <span class="n-block__date"><?=$arItem['ACTIVE_FROM']?></span> -->
                <span class="n-block__title"><?=$arItem['NAME']?></span>
            </div>
        </div>
	<?endforeach;?>
