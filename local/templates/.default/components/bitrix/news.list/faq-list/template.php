<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
		<div class="list">
			<?foreach ($arResult["ITEMS"] as $arItem):?>	
				<div class="news-list-item">
					
					<div class="link"><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a></div>
				</div>
			<?endforeach;?>	
		</div>