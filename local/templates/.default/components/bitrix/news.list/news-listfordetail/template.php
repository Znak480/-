<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
		<div class="list">
			<?foreach ($arResult["ITEMS"] as $arItem):?>	
				<div class="news-list-item">
					<!-- div class="date"><?=$arItem["DISPLAY_ACTIVE_FROM"]?></div -->
					<?if ($arItem["PROPERTIES"]["LINK"]["VALUE"]):?>
						<div class="link"><a href="<?=$arItem["PROPERTIES"]["LINK"]["VALUE"]?>"><?=$arItem["NAME"]?></a></div>
					<?else:?>
						<div class="link"><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a></div>
					<?endif;?>
				</div>
			<?endforeach;?>	
		</div>