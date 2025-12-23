<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>

<?
/*$_POST:
 * cursection - текущий раздел
 * newpage - новая страница
 * paramfilter - параметры фильтра
 * sortf - параметр сортировки
 * dist - порядок сортировки
 * count - количество на странице
 * id -
 * */
//echo "script";
//exit(123);

if (empty($_POST)){
    echo "error";
    exit();
}
?>

<!--    <div class="product p-product" style="position: relative;width: fit-content;">-->

<?
//echo "<pre>";
//print_r($_POST);
//echo "</pre>";
//exit();

?>
<!--    </div>-->
<?if(!empty($_POST)) {?>
    <?$APPLICATION->IncludeComponent(
        "bitrix:catalog.smart.filter",
        "showmore_filter",
        array(
            "IBLOCK_TYPE" => "catalog",
            "IBLOCK_ID" => $currentCity['IBLOCK_CATALOG']['VALUE'],
            "SECTION_ID" => $_POST['idsection'],//post,
            "FILTER_NAME" => "arrFilter",
            "PRICE_CODE" => array(
			$currentCity['PRICE_CODE']['VALUE']
		),
            "CACHE_TYPE" => "N",
            "CACHE_TIME" =>  "1",
            "CACHE_GROUPS" => "Y",
            "SAVE_IN_SESSION" => "N",
            "FILTER_VIEW_MODE" => "VERTICAL",
            "XML_EXPORT" => "Y",
            "SECTION_TITLE" => "NAME",
            "SECTION_DESCRIPTION" => "DESCRIPTION",
            'HIDE_NOT_AVAILABLE' => "N",
            "TEMPLATE_THEME" =>"site",
            'CONVERT_CURRENCY' => "Y",
            'CURRENCY_ID' => "RUB",
            "SEF_MODE" => "N",//$arParams["SEF_MODE"],
//            "SEF_RULE" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["smart_filter"],
//            "SMART_FILTER_PATH" => $arResult["VARIABLES"]["SMART_FILTER_PATH"],
//            "PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
        ),
        array('HIDE_ICONS' => 'Y')
    );?>
<?
    $APPLICATION->IncludeComponent(
    "bitrix:catalog.section",
    "showmore_cs",
    array(
    "IBLOCK_TYPE" => "catalog",
    "IBLOCK_ID" => $currentCity['IBLOCK_CATALOG']['VALUE'],
    "ELEMENT_SORT_FIELD" => $_POST['sort_field'],//post
    "ELEMENT_SORT_ORDER" => $_POST['sort_order'],//post
    "ELEMENT_SORT_FIELD2" => "sort",
    "ELEMENT_SORT_ORDER2" => "asc",
    "PROPERTY_CODE" => array(
        0 => "",
        1 => "NEWPRODUCT",
        2 => "SALELEADER",
        3 => "SPECIALOFFER",
        4 => "SALE",
        5 => "DISCOUNT",
        6 => "HIT",
    ),
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
    "FILTER_NAME" => "arrFilter",
    "CACHE_TYPE" => "N",
    "CACHE_TIME" => "1",
    "CACHE_FILTER" => "N",
    "CACHE_GROUPS" => "Y",
    "SET_TITLE" => "Y",
    "MESSAGE_404" => "",
    "SET_STATUS_404" => "Y",
    "SHOW_404" => "N",
    "PAGE_ELEMENT_COUNT" => $_POST['elems'],//$count, ///post
    "LINE_ELEMENT_COUNT" => 3,
    "PRICE_CODE" => array(
			$currentCity['PRICE_CODE']['VALUE']
		),
    "USE_PRICE_COUNT" => "N",
    "SHOW_PRICE_COUNT" => "1",

    "PRICE_VAT_INCLUDE" => "Y",
    "USE_PRODUCT_QUANTITY" => "Y",
    "ADD_PROPERTIES_TO_BASKET" => "Y",
    "PARTIAL_PRODUCT_PROPERTIES" => "Y",
    "PRODUCT_PROPERTIES" => array(),
    "DISPLAY_TOP_PAGER" => "Y",
    "DISPLAY_BOTTOM_PAGER" => "Y",
    "PAGER_TITLE" => "Товары",
    "PAGER_SHOW_ALWAYS" => "Y",
    "PAGER_TEMPLATE" => "new",
    "PAGER_DESC_NUMBERING" => "N",
    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000000",
    "PAGER_SHOW_ALL" => "N",
    "PAGER_BASE_LINK_ENABLE" => "N",
   // "PAGER_BASE_LINK" => $arParams["PAGER_BASE_LINK"],
   // "PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],

    "SECTION_ID" => $_POST['idsection'],//post
    //"SECTION_CODE" => $code,//post
    "SECTION_URL" => "",
    "DETAIL_URL" => "",
    "USE_MAIN_ELEMENT_SECTION" => "N",
    'CONVERT_CURRENCY' => "Y",
    'CURRENCY_ID' =>  "RUB",
    'HIDE_NOT_AVAILABLE' => "N",

    'LABEL_PROP' => "-",
    'ADD_PICT_PROP' => "-",
    'PRODUCT_DISPLAY_MODE' => "N",

//    'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
//    'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
//    'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
//    'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
//    'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
//    'MESS_BTN_BUY' => $arParams['MESS_BTN_BUY'],
//    'MESS_BTN_ADD_TO_BASKET' => $arParams['MESS_BTN_ADD_TO_BASKET'],
//    'MESS_BTN_SUBSCRIBE' => $arParams['MESS_BTN_SUBSCRIBE'],
//    'MESS_BTN_DETAIL' => $arParams['MESS_BTN_DETAIL'],
//    'MESS_NOT_AVAILABLE' => $arParams['MESS_NOT_AVAILABLE'],

    //'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
    //"ADD_SECTIONS_CHAIN" => "N",
   // 'ADD_TO_BASKET_ACTION' => $basketAction,
    //'SHOW_CLOSE_POPUP' => isset($arParams['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['COMMON_SHOW_CLOSE_POPUP'] : '',
    //'COMPARE_PATH' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['compare']
    )
    );?>

<?}?>