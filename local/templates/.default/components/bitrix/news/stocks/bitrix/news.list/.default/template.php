<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<div class="common-content-full news-page regular-block">
		<div class="title-block-full">
			<!-- <div class="path">
				<a href="/">Главная</a> &rarr;
			</div> -->
			<h1 class="big-din">Акции</h1>
		</div>
		<div class="content-block-full">
		<div class="list">
			<?foreach ($arResult["ITEMS"] as $arItem):?>	
				<div class="news-list-item">
					<!-- <div class="date"><?=$arItem["DISPLAY_ACTIVE_FROM"]?></div> -->
					<?if ($arItem["PROPERTIES"]["LINK"]["VALUE"]):?>
					<div class="link"><a href="<?=$arItem["PROPERTIES"]["LINK"]["VALUE"]?>"><?=$arItem["NAME"]?></a></div>
					<?else:?>
					<div class="link"><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a></div>
					<?endif;?>
				</div>
			<?endforeach;?>	

			</div>
			<div class="preview-list">
			<?foreach ($arResult["ITEMS"] as $arItem):?>	
				<div class="news-preview-list-item">
					<div class="image">
						<?if ($arItem["PROPERTIES"]["LINK"]["VALUE"]):?>
						<a href="<?=$arItem["PROPERTIES"]["LINK"]["VALUE"]?>">
							<?$file = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE']["ID"], array('width'=>250, 'height'=>1050), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true);?>
							<img src="<?=$file["src"]?>" alt="">
						</a>
						<?else:?>
						<a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
							<?$file = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE']["ID"], array('width'=>250, 'height'=>1050), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true);?>
							<img src="<?=$file["src"]?>" alt="">
						</a>
						<?endif;?>
					</div>
					<div class="news-preview-content">
						<!-- <div class="date"><?=$arItem["DISPLAY_ACTIVE_FROM"]?></div> -->
						<? if ($arItem["PROPERTIES"]["LINK"]["VALUE"]):?>
						<div class="title"><a href="<?=$arItem["PROPERTIES"]["LINK"]["VALUE"]?>"><?=$arItem["NAME"]?></a></div>
						<?else:?>
						<div class="title"><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a></div>
						<?endif;?>
						<div class="text"><?=$arItem["PREVIEW_TEXT"]?></div>
					</div>
					<div class="clear"></div>
				</div>
			<?endforeach;?>		
			

			

			</div>
			<div class="clear"></div>

		</div>
	</div>

<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?>
<?endif;?>

