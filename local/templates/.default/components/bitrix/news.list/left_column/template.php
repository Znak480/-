<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="three-Things">
	<?foreach ($arResult["ITEMS"] as $arItem):?>
        <?if($arItem['ID']!=23291){?>
	<div class="thing" style="background: url(<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>) 20px center no-repeat;">
		<h2><a href="<?=$arItem["PROPERTIES"]["LINK"]["VALUE"]?>"><?=$arItem["NAME"]?></a></h2>
		<div class="description">
			<?=$arItem["PREVIEW_TEXT"]?>
		</div>
	</div>
    <?}else{?>
            <div class="thing thing_banner">
                <?if(!empty($arItem["PROPERTIES"]["LINK"]["VALUE"])){?>
                    <a href="<?=$arItem["PROPERTIES"]["LINK"]["VALUE"]?>">
                <?}?>
                        <? $img = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"]['ID'], array('width'=>300, 'height'=>180), BX_RESIZE_IMAGE_PROPORTIONAL, true);?>
                        <img src="<?=$img['src']?>" alt="">
                <?if(!empty($arItem["PROPERTIES"]["LINK"]["VALUE"])){?>
                    </a>
                <?}?>
            </div>
        <?}?>
	<?endforeach;?>



</div>
<br>
