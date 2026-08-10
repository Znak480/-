<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); ?>

<?if (count($arResult["SECTIONS"]) > 0):?>
	<div class="catalog-section-list-content">
		<?foreach($arResult["SECTIONS"] as $arSection):?>
			<!-- Catalog section card start-->
			<a href="<?=$arSection["SECTION_PAGE_URL"]?>" class="catalog-section-card">
				<div class="catalog-section-card-image-wrapper">
					<?if (!empty($arSection["PICTURE"])):?>
					<? $image = CFile::ResizeImageGet(
							$arSection["PICTURE"], 
							array('width'=>190, 'height'=>190), 
							BX_RESIZE_IMAGE_PROPORTIONAL, 
							true
					); ?>
						<img class="catalog-section-card-image" src="<?=$image["src"] ?>" alt="<?=$arSection["NAME"]?>">
					<?else:?>
						<div class="no-photo">
							<span>Нет фото</span>
						</div>
					<?endif;?>
				</div>

				<p class="catalog-section-card-title"><?=$arSection["NAME"]?></p>
			</a>
			<!-- Catalog section card end-->
		<?endforeach;?>
	</div>
<?endif;?>

