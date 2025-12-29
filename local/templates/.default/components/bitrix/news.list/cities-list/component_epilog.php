<?php if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>


<div class="address">
	<div class="city">
		<? foreach($arResult['ITEMS'] as $arItem) {
			if($arItem['EXTERNAL_ID'] == CITY_CODE) { ?>
				<a href="#"><?=$arItem['NAME']?></a>
			<? }
		} ?>

		<div class="city-select">
			<? foreach($arResult['ITEMS'] as $arItem)
			{
				?>
				<? if(true/*$arItem['EXTERNAL_ID']!=CITY_CODE*/) { ?>
				<a href="http://<?=$arItem['PROPERTIES']['DOMAIN']['VALUE']?>"><?=$arItem['NAME']?></a><br>
			<? }
			} ?>
		</div>
	</div>
	<? foreach($arResult['ITEMS'] as $arItem)
	{
	if($arItem['EXTERNAL_ID'] == CITY_CODE)
	{
	?>

	<div class="street"><?=$arItem['PROPERTIES']['ADDRESS']['VALUE']?></div>
</div>
	<div class="phone">
		<div class="number">
			<a href="tel:<?=$arItem['PROPERTIES']['PHONE_HREF']['VALUE']?>"><?=$arItem['PROPERTIES']['PHONE']['VALUE']?></a><!-- span>+7 (3852)</span> 36-40-80--></div>
		<div class="opening-times"><?=$arItem['PROPERTIES']['WORKTIME']['VALUE']?></div>
	</div>

<? }
} ?>

<script>
    $(document).ready(function () {
		<?foreach($arResult['ITEMS'] as $arItem){if($arItem['EXTERNAL_ID'] == CITY_CODE){?>
        $('.top-menu').prepend('<div class="super-top"><a class="mobile-change-city"><?=$arItem['NAME']?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="tel:<?=$arItem['PROPERTIES']['PHONE_HREF']['VALUE']?>"><?=$arItem['PROPERTIES']['PHONE']['VALUE']?></a><br>пр-т Строителей, 94<a href="/cart/"><div class="cart"><div class="qty">0</div><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span></div></a></div>');
		<? }}?>
        var str = '<div class="super-top__change-city">';
		<?foreach($arResult['ITEMS'] as $arItem){?>
        str += '<div><a href="http://<?=$arItem['PROPERTIES']['DOMAIN']['VALUE']?>"><?=$arItem['NAME']?></a></div>';
		<?}?>
        str += '<div class="clear"></div></div>'
        $('.top-menu').prepend(str);
        $('.mobile-change-city').click(function () {
            $('.super-top__change-city').slideToggle('fast');
        });
        $('.super-top__change-city').click(function () {
            $(this).slideUp('fast');
        })

    });
</script>

