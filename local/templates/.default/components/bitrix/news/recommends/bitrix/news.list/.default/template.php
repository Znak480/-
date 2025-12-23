<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<div class="common-content-full advices-page regular-block">
		<div class="title-block-full">
			<div class="path">
				<a href="/">Главная</a> &rarr;
			</div>
			<h1 class="big-din">Советы от компании «Знак»</h1>
		</div>
		<div class="content-block-full">
		<div class="tags">
			<?foreach ($arResult["ITEMS"] as $arItem):?>	
				<div class="tag"><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a></div>
			<?endforeach;?>	
			</div>
			<div class="items">
				<?foreach ($arResult["ITEMS"] as $arItem):?>	
				<a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
					
					<?$file = CFile::ResizeImageGet($arItem['DETAIL_PICTURE']["ID"], array('width'=>420, 'height'=>210), BX_RESIZE_IMAGE_EXACT, true);?>
					<div class="item" style="background-image: url(<?=$file["src"]?>)">
						<div class="item-shadow"></div>
						<div class="item-bg"></div>
						<div class="item-content">
							<div class="title"><?=$arItem["NAME"]?></div>
							<div class="txt"><?=$arItem["PREVIEW_TEXT"]?></div>
						</div>
					</div>
				</a>
				<?endforeach;?>

			</div>
			<div class="clear"></div>

		</div>
	</div>

<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?>
<?endif;?>

