<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
			<div class="tags">
				<div class="tag title">Темы советов</div>
				<?foreach ($arResult["ITEMS"] as $arItem):?>
				<div class="tag"><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a></div>
				<?endforeach;?>
				
			</div>