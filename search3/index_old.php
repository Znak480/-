<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Поиск");
global $currentCity;
?>
<?  //   ?>
<?if ($USER->IsAdmin() or 1 ){?>

    <div class="common-content-full common-content-thin category-page">
    <div class="title-block regular-block">
        <div class="path">
            <a href="/">Главная</a> &rarr;
        </div>
        <h1 class="big-din">Результаты поиска</h1>
    </div>
    <div class="content-block regular-block">
    <div class="products products-search">
        <?$APPLICATION->IncludeComponent(
	"bitrix:catalog.search", 
	"search", 
	array(
		"AJAX_MODE" => "Y",
		"IBLOCK_TYPE" => "catalog",
		"IBLOCK_ID" => $currentCity["IBLOCK_CATALOG"]["VALUE"],
		"ELEMENT_SORT_FIELD" => "",
		"ELEMENT_SORT_ORDER" => "",
		"ELEMENT_SORT_FIELD2" => "",
		"ELEMENT_SORT_ORDER2" => "",
		"SECTION_URL" => "",
		"DETAIL_URL" => "",
		"BASKET_URL" => "/cart/",
		"ACTION_VARIABLE" => "action",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"DISPLAY_COMPARE" => "Y",
		"PAGE_ELEMENT_COUNT" => "100",
		"LINE_ELEMENT_COUNT" => "4",
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "RAITING_PRODAZH",
			2 => "AKTSIYA_",
			3 => "SKIDKA_PO_KARTE_",
			4 => "",
		),
		"OFFERS_FIELD_CODE" => "",
		"OFFERS_PROPERTY_CODE" => "",
		"OFFERS_SORT_FIELD" => "sort",
		"OFFERS_SORT_ORDER" => "asc",
		"OFFERS_SORT_FIELD2" => "id",
		"OFFERS_SORT_ORDER2" => "desc",
		"OFFERS_LIMIT" => "0",
		"PRICE_CODE" => array(
			0=>$currentCity['PRICE_CODE']['VALUE']
		),
		"USE_PRICE_COUNT" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"PRICE_VAT_INCLUDE" => "Y",
		"USE_PRODUCT_QUANTITY" => "Y",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "1",
		"RESTART" => "Y",
		"NO_WORD_LOGIC" => "Y",
		"USE_LANGUAGE_GUESS" => "Y",
		"CHECK_DATES" => "N",
		"DISPLAY_TOP_PAGER" => "Y",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "Товары",
		"PAGER_SHOW_ALWAYS" => "Y",
		"PAGER_TEMPLATE" => "new",
		"PAGER_DESC_NUMBERING" => "Y",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "1",
		"PAGER_SHOW_ALL" => "Y",
		"HIDE_NOT_AVAILABLE" => "N",
		"CONVERT_CURRENCY" => "Y",
		"CURRENCY_ID" => "RUB",
		"OFFERS_CART_PROPERTIES" => "",
		"AJAX_OPTION_JUMP" => "Y",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "Y",
		"COMPONENT_TEMPLATE" => "search",
		"HIDE_NOT_AVAILABLE_OFFERS" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"PRODUCT_PROPERTIES" => array(
		),
		"USE_TITLE_RANK" => "Y",
		"USE_SEARCH_RESULT_ORDER" => "Y"
	),
	false
);?>
    </div>
    </div>
    </div>
<?} else {?>
    <div class="common-content-full common-content-thin category-page">
        <div class="title-block regular-block">
            <div class="path">
                <a href="/">Главная</a> &rarr;
            </div>
            <h1 class="big-din">Результаты поиска</h1>
        </div>
        <div class="content-block regular-block">
            <div class="products products-search">
				<?$APPLICATION->IncludeComponent (
					"bitrix:catalog.search",
					"search",
					Array(
						"AJAX_MODE" => "Y",
						"IBLOCK_TYPE" => "catalog",
						"IBLOCK_ID" => $currentCity['IBLOCK_CATALOG']['VALUE'],

						"ELEMENT_SORT_FIELD" => "rank",
						"ELEMENT_SORT_ORDER" => "asc",
						"ELEMENT_SORT_FIELD2" => "sort",
						"ELEMENT_SORT_ORDER2" => "desc",
						"SECTION_URL" => "",
						"DETAIL_URL" => "",
						"BASKET_URL" => "/cart/",
						"ACTION_VARIABLE" => "action",
						"PRODUCT_ID_VARIABLE" => "id",
						"PRODUCT_QUANTITY_VARIABLE" => "quantity",
						"PRODUCT_PROPS_VARIABLE" => "prop",
						"SECTION_ID_VARIABLE" => "SECTION_ID",
						"DISPLAY_COMPARE" => "Y",
						"PAGE_ELEMENT_COUNT" => "100",
						"LINE_ELEMENT_COUNT" => "4",
						"PROPERTY_CODE" => array(
							'RAITING_PRODAZH',
							'AKTSIYA_',
							'SKIDKA_PO_KARTE_'
						),
						"OFFERS_FIELD_CODE" => array(),
						"OFFERS_PROPERTY_CODE" => array(),
						"OFFERS_SORT_FIELD" => "sort",
						"OFFERS_SORT_ORDER" => "asc",
						"OFFERS_SORT_FIELD2" => "id",
						"OFFERS_SORT_ORDER2" => "desc",
						"OFFERS_LIMIT" => "5",
						"PRICE_CODE" => array(
							$currentCity['PRICE_CODE']['VALUE']
						),
						"USE_PRICE_COUNT" => "N",
						"SHOW_PRICE_COUNT" => "1",
						"PRICE_VAT_INCLUDE" => "Y",
						"USE_PRODUCT_QUANTITY" => "Y",
						"CACHE_TYPE" => "A",
						"CACHE_TIME" => "1",
						"RESTART" => "Y",
						"NO_WORD_LOGIC" => "Y",
						"USE_LANGUAGE_GUESS" => "Y",
						"CHECK_DATES" => "Y",
						"DISPLAY_TOP_PAGER" => "Y",
						"DISPLAY_BOTTOM_PAGER" => "Y",
						"PAGER_TITLE" => "Товары",
						"PAGER_SHOW_ALWAYS" => "Y",
						"PAGER_TEMPLATE" => "new",
						"PAGER_DESC_NUMBERING" => "Y",
						"PAGER_DESC_NUMBERING_CACHE_TIME" => "1",
						"PAGER_SHOW_ALL" => "Y",
						"HIDE_NOT_AVAILABLE" => "N",
						"CONVERT_CURRENCY" => "Y",
						"CURRENCY_ID" => "RUB",
						"OFFERS_CART_PROPERTIES" => array(),
						"AJAX_OPTION_JUMP" => "Y",
						"AJAX_OPTION_STYLE" => "Y",
						"AJAX_OPTION_HISTORY" => "Y"
					)
				);?>
            </div>
        </div>
    </div>
<?}?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>