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

<div class="title-block-full">
    <!-- <div class="path">
        <a href="/">Главная</a> →
    </div> -->
    <h1 class="big-din"><?=$arResult['NAME']?></h1>
</div>
<div class="content-block-full">
    <?
    echo $arResult['PREVIEW_TEXT'];
    ?>
</div>

