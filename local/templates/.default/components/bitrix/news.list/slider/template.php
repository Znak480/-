<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>

	<ul class="banner__slides">
		<?$i=1;?>
		<?foreach ($arResult["ITEMS"] as $arItem):?>
		<? $file = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"]["ID"], array('width'=>870, 'height'=>333), BX_RESIZE_IMAGE_EXACT, true);  ?>
		<li>
			<a href="<?=($arItem["PROPERTIES"]["LINK"]["VALUE"])?:'javascript:void(0)'?>">
				<img src="<?=$file["src"]?>" alt="">
			</a>
		</li>
			<?$i++;?>
		<?endforeach;?>
	</ul>

	<!-- <div class="jcarousel-wrapper">
        <div class="jcarousel">
		<ul>
			<?$i=1;?>
			<?foreach ($arResult["ITEMS"] as $arItem):?>
			<? $file = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"]["ID"], array('width'=>870, 'height'=>333), BX_RESIZE_IMAGE_EXACT, true);  ?>
				<li class="item-<?=$i?>"><a data-jcarouselcontrol="true" class="logos-list-main-control-next" href="#">‹</a><a href="<?=$arItem["PROPERTIES"]["LINK"]["VALUE"]?>"><img src="<?=$file["src"]?>" alt=""></a></li>

				<?$i++;?>
			<?endforeach;?>
		</ul>
        </div>
		<div class="preview jcarousel-pagination">
			<?$i=1;?>
			<ul>
				<?foreach ($arResult["ITEMS"] as $arItem):?>
					<? $file = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"]["ID"], array('width'=>190, 'height'=>70), BX_RESIZE_IMAGE_PROPORTIONAL, true);  ?>
					<li><a class="jcarousel-control" href="#" data-target-selector=".item-<?=$i?>"><img src="<?=$file["src"]?>" alt=""></a></li>
					<?$i++;?>
				<?endforeach;?>
			</ul>

        </div>
	</div> -->

	<script>

	$('.banner__slides').slick({
		slidesToShow: 1,
		arrows: true,
		dots: true,
		autoplay: true,
        autoplaySpeed: 5000,
	});

	</script>
