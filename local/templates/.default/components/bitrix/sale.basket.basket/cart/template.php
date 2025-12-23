<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixBasketComponent $component */
$curPage = $APPLICATION->GetCurPage().'?'.$arParams["ACTION_VARIABLE"].'=';
$arUrls = array(
	"delete" => $curPage."delete&id=#ID#",
	"delay" => $curPage."delay&id=#ID#",
	"add" => $curPage."add&id=#ID#",
);
unset($curPage);

$arBasketJSParams = array(
	'SALE_DELETE' => GetMessage("SALE_DELETE"),
	'SALE_DELAY' => GetMessage("SALE_DELAY"),
	'SALE_TYPE' => GetMessage("SALE_TYPE"),
	'TEMPLATE_FOLDER' => $templateFolder,
	'DELETE_URL' => $arUrls["delete"],
	'DELAY_URL' => $arUrls["delay"],
	'ADD_URL' => $arUrls["add"]
);
?>
<script type="text/javascript">
	var basketJSParams = <?=CUtil::PhpToJSObject($arBasketJSParams);?>
</script>
<?
$APPLICATION->AddHeadScript($templateFolder."/script.js");

if (strlen($arResult["ERROR_MESSAGE"]) <= 0)
{
	?>

	<?

	$normalCount = count($arResult["ITEMS"]["AnDelCanBuy"]);
	$normalHidden = ($normalCount == 0) ? 'style="display:none;"' : '';

	$delayCount = count($arResult["ITEMS"]["DelDelCanBuy"]);
	$delayHidden = ($delayCount == 0) ? 'style="display:none;"' : '';

	$subscribeCount = count($arResult["ITEMS"]["ProdSubscribe"]);
	$subscribeHidden = ($subscribeCount == 0) ? 'style="display:none;"' : '';

	$naCount = count($arResult["ITEMS"]["nAnCanBuy"]);
	$naHidden = ($naCount == 0) ? 'style="display:none;"' : '';

	?>
	<div class="common-content-full contacts-page regular-block">
		<div class="title-block-full">
			<div class="path">
				<a href="/">Главная</a> &rarr;
			</div>
			<h1 class="big-din">Корзина</h1>
		</div>
		<div class="content-block-full">
		
		<form method="post" action="<?=POST_FORM_ACTION_URI?>" name="basket_form" id="basket_form">
			<div id="basket_form_container">
				<div class="bx_ordercart">
				
					<?
					include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_items.php");
					?>
				</div>
			</div>
			<input type="hidden" name="BasketOrder" value="BasketOrder" />
			<!-- <input type="hidden" name="ajax_post" id="ajax_post" value="Y"> -->
		</form>

            <a href="order/" class="btn checkout" >К оформлению →</a>

      <?/*
<div class="form-table" id="basket">
	
	<div class="line">
		<div class="label">Ф. И. О. *</div>
		<div class="input"><input type="text" value="" name="fio"></div>
		<div class="clear"></div>
	</div>
	<div class="line">
		<div class="label">Телефон *</div>
		<div class="input"><input type="text" value="" name="phone"></div>
		<div class="clear"></div>
	</div>
	<div class="line">
		<div class="label">E-mail *</div>
		<div class="input"><input type="text" value="" name="email"></div>
		<div class="clear"></div>
	</div>
	<div class="line">
		<div class="label"></div>
		<div class="input"><input type="submit" value="Оформить заказ"></div>
		<div class="clear"></div>
	</div>	
	<div class="line">
		<h2 id="succ" style="display:none;">Ваша заявка отправлена! В ближайшее время с Вами свяжется менеджер.</h2>
	</div>
</div>*/?>
        </div>
			
	</div>
	<?
}
else
{
	ShowError($arResult["ERROR_MESSAGE"]);
	echo "<div style='height: 324px'></div>";
}
?>