<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>

	<div class="common-content-full services-page regular-block">
		<div class="title-block-full">
			<div class="path">
				<a href="/">Главная</a> &rarr;
			</div>
			<h1 class="big-din">Услуги</h1>
		</div>
		<div class="content-block-full">
<!-- -->			

<div class="services-box">
	<?foreach ($arResult["ITEMS"] as $arItem):?>
	<div class="services-item">
		<div class="services-image"><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt=""></a></div>
		<div class="services-text"><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a></div>
	</div>
	<?endforeach;?>
	
	<div class="clear"></div>
</div>

<!-- -->
		</div>
	</div>