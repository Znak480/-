<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
	<div class="services services_e1 regular-block">
		<h2 class="din" style="cursor:pointer;" onclick="location.href='/servicies/'">Услуги</h2>
		<?foreach ($arResult["ITEMS"] as $arItem):?>	
		<div class="service">
			<a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
				<?$file = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"]["ID"], array('width'=>40, 'height'=>40), BX_RESIZE_IMAGE_PROPORTIONAL, true);  ?>
				<img src="<?=$file["src"]?>" alt="<?=$arItem["NAME"]?>">
				<div class="title"><?=$arItem["NAME"]?></div>
			</a>
		</div>
		<?endforeach;?>
		<div class="clear"></div>
	</div>