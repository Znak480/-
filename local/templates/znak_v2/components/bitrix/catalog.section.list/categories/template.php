<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if(!empty($arResult['SECTIONS'])):?>
	<div id="popular-cards-slider" class="swiper popular-card-slider">
        <div class="swiper-wrapper">
			<?foreach($arResult["SECTIONS"] as $arSection):?>
				<a href="<?=$arSection["SECTION_PAGE_URL"]?>" class="swiper-slide popular-card">
					<div class="popular-card-content">
						<h3 class="popular-card-title"><?=$arSection["NAME"]?></h3>
						<div class="popular-card-image-wrapper">
							<?if ($arSection["PICTURE"]):?>	
								<?$file = CFile::ResizeImageGet($arSection["PICTURE"], array('width'=>200, 'height'=>200), BX_RESIZE_IMAGE_PROPORTIONAL, true);  ?>
								<img 
									src="<?=$file["src"]?>" 
									alt="<?=$arSection["NAME"]?>"
									loading="lazy"
								>
							<?endif;?>
						</div>
					</div>
				</a>
			<?endforeach;?>
		</div>	
	</div>
<? endif;?>