<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<ul>
<?foreach ($arResult["ITEMS"] as $arItem):?>	
				<li>		
					<div class="name">
						<span><?=$arItem["NAME"]?></span>
						<?=$arItem["PROPERTIES"]["DOLZHNOST"]["VALUE"]?>
					
					</div>
					<?$file = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"]["ID"], array('width'=>278, 'height'=>343), BX_RESIZE_IMAGE_PROPORTIONAL, true);?>   
					<img src="<?=$file["src"]?>">
					<div class="text"><?=$arItem["PREVIEW_TEXT"]?></div>
				</li>
	
<?endforeach;?>	
</ul>