<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Context;
use Bitrix\Main\Loader;

global $currentCity, $APPLICATION;

// Проверка AJAX запроса
$isAjax = (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest');

if (!$isAjax) {
    http_response_code(403);
    echo json_encode(['error' => 'Direct access denied. AJAX only.']);
    exit();
}

// Получение параметров
$request = Context::getCurrent()->getRequest();
$sectionId = intval($request->get('section_id'));
$pageElementCount = intval($request->get('page_element_count'));
$filterName = trim($request->get('filter_name'));
$pageNum = intval($request->get('PAGEN_1')); // Номер страницы для пагинации

// Валидация
if ($sectionId <= 0) {
    $sectionId = 0;}

if ($pageElementCount <= 0 || $pageElementCount > 100) {
    $pageElementCount = 12;
}

if (empty($filterName)) {
    $filterName = 'arrFilter';
}

if ($pageNum <= 0) {
    $pageNum = 1;
}

// Проверка конфигурации
if (empty($currentCity['IBLOCK_CATALOG']['VALUE'])) {
    http_response_code(500);
    echo json_encode(['error' => 'Catalog IBlock not configured.']);
    exit();
}

if (empty($currentCity['PRICE_CODE']['VALUE'])) {
    http_response_code(500);
    echo json_encode(['error' => 'Price code not configured.']);
    exit();
}

// Подготовка параметров компонента
$componentParams = array(
    "IBLOCK_TYPE" => "catalog",
    "IBLOCK_ID" => $currentCity['IBLOCK_CATALOG']['VALUE'],
    "PROPERTY_CODE" => array(
        0 => "",
        1 => "NEWPRODUCT",
        2 => "SALELEADER",
        3 => "SPECIALOFFER",
        4 => "SALE",
        5 => "DISCOUNT",
        6 => "HIT",
    ),
    "FILTER_NAME" => $filterName,
    "META_KEYWORDS" => "-",
    "META_DESCRIPTION" => "-",
    "BROWSER_TITLE" => "-",
    "SET_LAST_MODIFIED" => "N",
    "INCLUDE_SUBSECTIONS" => "Y",
    "BASKET_URL" => "/personal/cart/",
    "ACTION_VARIABLE" => "action",
    "PRODUCT_ID_VARIABLE" => "id",
    "SECTION_ID_VARIABLE" => "SECTION_ID",
    "PRODUCT_QUANTITY_VARIABLE" => "quantity",
    "PRODUCT_PROPS_VARIABLE" => "prop",
    "CACHE_TYPE" => "N",
    "CACHE_TIME" => "1",
    "CACHE_FILTER" => "N",
    "CACHE_GROUPS" => "Y",
    "SET_TITLE" => "N",
    "MESSAGE_404" => "",
    "SET_STATUS_404" => "N",
    "SHOW_404" => "N",
    "PAGE_ELEMENT_COUNT" => $pageElementCount,
    "LINE_ELEMENT_COUNT" => 3,
    "PRICE_CODE" => array($currentCity['PRICE_CODE']['VALUE']),
    "USE_PRICE_COUNT" => "N",
    "SHOW_PRICE_COUNT" => "1",
    "PRICE_VAT_INCLUDE" => "Y",
    "USE_PRODUCT_QUANTITY" => "Y",
    "ADD_PROPERTIES_TO_BASKET" => "Y",
    "PARTIAL_PRODUCT_PROPERTIES" => "Y",
    "PRODUCT_PROPERTIES" => array(),
    "DISPLAY_TOP_PAGER" => "N", // Отключаем верхнюю пагинацию
    "DISPLAY_BOTTOM_PAGER" => "Y",
    "PAGER_TITLE" => "Товары",
    "PAGER_SHOW_ALWAYS" => "N",
    "PAGER_TEMPLATE" => "modern", // Используем modern шаблон
    "PAGER_DESC_NUMBERING" => "N",
    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000000",
    "PAGER_SHOW_ALL" => "N",
    "PAGEN_1" => $pageNum,
    "PAGER_BASE_LINK" => "",
    "PAGER_BASE_LINK_ENABLE" => "Y",
    "PAGER_PARAMS_NAME" => "arrPager",
    "SECTION_ID" => $sectionId,
    "SECTION_URL" => "",
    "DETAIL_URL" => "",
    "USE_MAIN_ELEMENT_SECTION" => "N",
    "CONVERT_CURRENCY" => "Y",
    "CURRENCY_ID" => "RUB",
    "HIDE_NOT_AVAILABLE" => "N",
    "LABEL_PROP" => "-",
    "ADD_PICT_PROP" => "-",
    "PRODUCT_DISPLAY_MODE" => "N",
    "PAGEN_1" => $pageNum, // Передаем номер страницы
);

// Инициализация
$componentTemplate = isset($arResult["THEME_COMPONENT"]) ? $arResult["THEME_COMPONENT"] : null;

// Буферизация
ob_start();

try {
    // Вызов компонента
    $APPLICATION->IncludeComponent(
        "bitrix:catalog.section",
        ".default",
        $componentParams,
        $componentTemplate,
        array('HIDE_ICONS' => 'Y')
    );
    
    $html = ob_get_clean();
    
    // Парсим HTML для извлечения карточек товаров
    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML('<?xml encoding="UTF-8">' . $html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    libxml_clear_errors();
    
    // Извлекаем карточки товаров
    $xpath = new DOMXPath($dom);
    $productCards = $xpath->query("//div[contains(@class, 'product-card')]");
    
    // Извлекаем пагинацию
    $pagination = $xpath->query("//ul[contains(@class, 'pagination')]");
    
    // Формируем ответ
    $response = [
        'success' => true,
        'html' => '',
        'pagination' => '',
        'hasMore' => false,
        'currentPage' => $pageNum
    ];
    
    // Собираем карточки
    if ($productCards->length > 0) {
        $cardsHtml = '';
        foreach ($productCards as $card) {
            $cardsHtml .= $dom->saveHTML($card);
        }
        $response['html'] = $cardsHtml;
    }
    
    // Собираем пагинацию
    if ($pagination->length > 0) {
        $response['pagination'] = $dom->saveHTML($pagination->item(0));
    }
    
    // Проверяем, есть ли еще страницы
    $navResult = null;
    if (isset($arResult["NAV_RESULT"]) && is_object($arResult["NAV_RESULT"])) {
        $response['hasMore'] = $arResult["NAV_RESULT"]->NavPageNomer < $arResult["NAV_RESULT"]->nEndPage;
        $response['totalPages'] = $arResult["NAV_RESULT"]->nEndPage;
        $response['totalItems'] = $arResult["NAV_RESULT"]->NavRecordCount;
    }
    
    echo json_encode($response);
    
} catch (Exception $e) {
    ob_end_clean();
    
    if (class_exists('\\Bitrix\\Main\\Diag\\Debug')) {
        \Bitrix\Main\Diag\Debug::writeToFile(
            $e->getMessage(),
            'Error in ajax catalog section: ' . $e->getFile() . ':' . $e->getLine(),
            'ajax_errors.log'
        );
    }
    
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'An error occurred while loading products.'
    ]);
}

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php");
?>