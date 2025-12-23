<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>

<?foreach ($arResult["ITEMS"] as $arItem):?>
	<div class="vacancy">
	<div class="vacancy-title"><?=$arItem["NAME"]?></div>
	<div class="vacancy-body">
		<p class="salary"><?=$arItem["PROPERTIES"]["ZP"]["VALUE"]?></p>
		<?=$arItem["PREVIEW_TEXT"]?>
	</div>
</div>
<?endforeach;?>