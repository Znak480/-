<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if(!array_key_exists ($arParams['PRODUCT_ID'],$arResult)):?>
    К сравнению
<?else:?>
	<a href="/compare/">Перейти к сравнению</a> 
<?endif?>