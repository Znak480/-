<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); 
$visibleCount = intval($arParams['VISIBLE_COUNT'] ?? 5);
?>

<?if (count($arResult["SECTIONS"])>0):?>
	<div class="catalog-list-content">
		<?foreach($arResult["SECTIONS"] as $arSection):?>
			<!-- Catalog card start-->
			<div class="catalog-card">
				<a class="catalog-card-image-wrapper"  href="<?=$arSection["SECTION_PAGE_URL"]?>">
					<?if (!empty($arSection["PICTURE"])):?>
						<? $image = CFile::ResizeImageGet(
								$arSection["PICTURE"], 
								array('width'=>190, 'height'=>190), 
								BX_RESIZE_IMAGE_PROPORTIONAL, 
								true
						); ?>
						<img class="catalog-card-image" src="<?=$image["src"] ?>" alt="<?=$arSection["NAME"]?>">
					<?else:?>
						<div class="no-photo">
							<span>Нет фото</span>
						</div>
					<?endif;?>
				</a>
				<div class="catalog-card-content">
					<a href="<?=$arSection["SECTION_PAGE_URL"]?>" class="catalog-card-title"><?=$arSection["NAME"]?></a>
					<?if(!empty($arSection["CHILDREN"])):?>
						<ul class="catalog-card-links" data-visible="<?= $visibleCount ?>">
							<?foreach($arSection["CHILDREN"] as $child):?>
								<li class="catalog-card-link">
									<a href="<?= $child["SECTION_PAGE_URL"] ?>">
										<?= $child["NAME"] ?>
									</a>
								</li>
							<?endforeach;?>		
						</ul>
					<?endif;?>

					<button class="btn btn-ghost btn-show-more">
						<span>Показать еще</span>
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
							<path
								d="M201.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L224 338.7 54.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z" />
						</svg>
					</button>
				</div>
			</div>
			<!-- Catalog card end-->
		<?endforeach;?>
	</div>
<?endif;?>

