<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<ul>
<?foreach ($arResult["ITEMS"] as $arItem):?>	
<?$file = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"]["ID"], array('width'=>150, 'height'=>80), BX_RESIZE_IMAGE_PROPORTIONAL, true);?>     
	<li><img src="<?=$file["src"]?>"></li>
<?endforeach;?>	
</ul>