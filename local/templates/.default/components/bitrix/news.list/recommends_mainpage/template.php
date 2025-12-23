<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
		<?foreach ($arResult["ITEMS"] as $arItem):?>
		<div class="advice-item">
			<div class="image"><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt=""></a></div>
			<a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
				<div class="advice-content">
					<h4><?=$arItem["NAME"]?></h4>
					<div class="date"><?=$arItem["DISPLAY_ACTIVE_FROM"]?></div>
					<div class="text"><?=$arItem["PREVIEW_TEXT"]?></div>
				</div>
			</a>
		</div>
		<?endforeach;?>