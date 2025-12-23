<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$APPLICATION->SetAdditionalCSS("/css/common.css");
$APPLICATION->SetAdditionalCSS("/css/adaptive.css");
?>

<?if (count($arResult["SECTIONS"])>0):?>
<?
	$section_list=true;
	?>

		<div class="content-block regular-block">
			<h1 class="common-din"><?=$arResult["SECTION"]["NAME"]?></h1>
			<?foreach($arResult["SECTIONS"] as $arSection):?>
			
			<div class="collection">
				<div class="image">
					<a href="<?=$arSection["SECTION_PAGE_URL"]?>">
					<?if ($arSection["PICTURE"]):?>	
						<?$file = CFile::ResizeImageGet($arSection["PICTURE"], array('width'=>190, 'height'=>190), BX_RESIZE_IMAGE_PROPORTIONAL, true);  ?>
						<img src="<?=$file["src"]?>" alt="">
					<?else:?>
						<img src="/i/no-photo.jpg" alt="">
					<?endif;?>
					</a>
				</div>
				<div class="title">
					<a href="<?=$arSection["SECTION_PAGE_URL"]?>"><?=$arSection["NAME"]?></a>
				</div>
				<div class="description"></div>
			</div>
			<?endforeach;?>
	
			<div class="clear"></div>
		</div>
<?endif;?>