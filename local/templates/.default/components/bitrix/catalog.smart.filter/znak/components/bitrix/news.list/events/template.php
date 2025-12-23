<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
		<?foreach ($arResult["ITEMS"] as $arItem):?>	
			<div class="item">
				<span class="date"><?=$arItem["ACTIVE_FROM"]?></span>
				<a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a>
			</div>
		<?endforeach;?>	
