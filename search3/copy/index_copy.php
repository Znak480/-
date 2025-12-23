<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Поиск");
global $currentCity;
?>
<?if ($USER->IsAdmin() or 1){?>

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
                "PAGE_ELEMENT_COUNT" => "25",
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
<?} else {?>
    <div class="common-content-full common-content-thin category-page">
		<div class="title-block regular-block">
			<div class="path">
				<a href="/">Главная</a> &rarr;
			</div>
			<h1 class="big-din">Результаты поиска</h1>
		</div>
		<div class="content-block regular-block">
<?$APPLICATION->IncludeComponent("bitrix:search.page", "search-page", Array(
	"RESTART" => "N",	// Искать без учета морфологии (при отсутствии результата поиска)
		"CHECK_DATES" => "N",	// Искать только в активных по дате документах
		"USE_TITLE_RANK" => "N",	// При ранжировании результата учитывать заголовки
		"DEFAULT_SORT" => "rank",	// Сортировка по умолчанию
		"arrFILTER" => array(	// Ограничение области поиска
			0 => "iblock_catalog",
		),
		"arrFILTER_main" => "",
		"arrFILTER_iblock_services" => array(
			0 => "all",
		),
		"arrFILTER_iblock_news" => array(
			0 => "all",
		),
		"arrFILTER_iblock_catalog" => array(	// Искать в информационных блоках типа "iblock_catalog"
			0 => IBLOCK_PRODUCTS_ID,
		),
		"SHOW_WHERE" => "N",	// Показывать выпадающий список "Где искать"
		"SHOW_WHEN" => "N",	// Показывать фильтр по датам
		"PAGE_RESULT_COUNT" => "25",	// Количество результатов на странице
		"AJAX_MODE" => "N",	// Включить режим AJAX
		"AJAX_OPTION_SHADOW" => "Y",
		"AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
		"AJAX_OPTION_STYLE" => "Y",	// Включить подгрузку стилей
		"AJAX_OPTION_HISTORY" => "N",	// Включить эмуляцию навигации браузера
		"CACHE_TYPE" => "A",	// Тип кеширования
		"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
		"DISPLAY_TOP_PAGER" => "N",	// Выводить над результатами
		"DISPLAY_BOTTOM_PAGER" => "Y",	// Выводить под результатами
		"PAGER_TITLE" => "Результаты поиска",	// Название результатов поиска
		"PAGER_SHOW_ALWAYS" => "N",	// Выводить всегда
		"PAGER_TEMPLATE" => "",	// Название шаблона
		"USE_SUGGEST" => "N",	// Показывать подсказку с поисковыми фразами
		"SHOW_ITEM_TAGS" => "N",	// Показывать теги документа
		"SHOW_ITEM_DATE_CHANGE" => "N",	// Показывать дату изменения документа
		"SHOW_ORDER_BY" => "N",	// Показывать сортировку
		"SHOW_TAGS_CLOUD" => "N",	// Показывать облако тегов
		"AJAX_OPTION_ADDITIONAL" => "",	// Дополнительный идентификатор
		"COMPONENT_TEMPLATE" => "clear",
		"NO_WORD_LOGIC" => "N",	// Отключить обработку слов как логических операторов
		"FILTER_NAME" => "",	// Дополнительный фильтр
		"USE_LANGUAGE_GUESS" => "Y",	// Включить автоопределение раскладки клавиатуры
		"SHOW_RATING" => "",	// Включить рейтинг
		"RATING_TYPE" => "",	// Вид кнопок рейтинга
		"PATH_TO_USER_PROFILE" => "",	// Шаблон пути к профилю пользователя
        "DISPLAY_PROPERTIES"=>array('MANUFACTURER')
	),
	false
);?>
</div>
</div>
<?}?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>