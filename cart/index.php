<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Моя корзина | Торговый центр «Знак» – товары для ремонта и строительства");
$APPLICATION->SetPageProperty("keywords", "корзина, торговый, центр, знак, товар, ремонт, строительство, отделочный, строительный, материал");
$APPLICATION->SetPageProperty("description", "Моя корзина. Торговый центр «Знак». Отделочные и строительные материалы, а также инструменты, текстиль, предметы интерьера, хозтовары, товары для дома.");
$APPLICATION->SetTitle("Корзина");
?><?$APPLICATION->IncludeComponent(
	"bitrix:sale.basket.basket", 
	"cart",
	array(
		"COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
		"COLUMNS_LIST" => array(
			0 => "NAME",
			1 => "DELETE",
			2 => "QUANTITY",
            3 => "PRICE",
            4 => "SUM",
		),
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"PATH_TO_ORDER" => "",
		"HIDE_COUPON" => "N",
		"QUANTITY_FLOAT" => "N",
		"PRICE_VAT_SHOW_VALUE" => "N",
		"SET_TITLE" => "Y",
		"AJAX_OPTION_ADDITIONAL" => "",
		"OFFERS_PROPS" => array(
			0 => "ARTNUMBER",
		),
		"COMPONENT_TEMPLATE" => "cart",
		"USE_PREPAYMENT" => "N",
		"ACTION_VARIABLE" => "action"
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>