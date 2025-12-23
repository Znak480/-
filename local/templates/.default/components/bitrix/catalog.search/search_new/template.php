<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<?
$arElements = $APPLICATION->IncludeComponent(
	"bitrix:search.page",
	"search-page",
	Array(
		"RESTART" => $arParams["RESTART"],
		"NO_WORD_LOGIC" => $arParams["NO_WORD_LOGIC"],
		"USE_LANGUAGE_GUESS" => $arParams["USE_LANGUAGE_GUESS"],
		"CHECK_DATES" => $arParams["CHECK_DATES"],
		"arrFILTER" => array("iblock_".$arParams["IBLOCK_TYPE"]),
		"arrFILTER_iblock_".$arParams["IBLOCK_TYPE"] => array($arParams["IBLOCK_ID"]),
		"USE_TITLE_RANK" => "N",
		"DEFAULT_SORT" => "rank",
		"FILTER_NAME" => "",
		"SHOW_WHERE" => "N",
		"arrWHERE" => array(),
		"SHOW_WHEN" => "N",
//		"PAGE_RESULT_COUNT" => 4,
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "N",
	),
	$component,
	array('HIDE_ICONS' => 'Y')
);
//debug($arElements);
//echo count($arElements);


// тут можно добавить новые ID товара для результатов поиска

$search_array = explode(' ', $_REQUEST['q'] );

//foreach($search_array as $item_search){
//
//    //echo strlen($item_search);
//    if(strlen($item_search) > 4){
//	    $sub_search =  substr($item_search, 0, strlen($item_search) - 2);
//        debug($sub_search);
//	    $arSelect = Array("ID", "IBLOCK_ID", "NAME", "DATE_ACTIVE_FROM","PROPERTY_*");
//	    $arFilter = Array("IBLOCK_ID"=>IntVal($arParams['IBLOCK_ID']), "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", "!ID" => $arElements, "NAME" => "%".$sub_search."%");
//	    $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
//	    while($ob = $res->GetNextElement()){
//		    $arFields = $ob->GetFields();
//            echo $arFields['NAME'];
//		    $arElements[] = $arFields['ID'];
//	    }
//    }
//}


if (!empty($arElements) && is_array($arElements))
{
	global $searchFilter;


	$searchFilter = array(
		"=ID" => $arElements,
	);
    if($_GET['where']){
        $searchFilter=array_merge($searchFilter,array("SECTION_ID"=>$_GET['where']));
    }
    //debug(count($arElements));
    //debug($arElements);

    // найдем разделы найденых элементов
    $finderSection = [];
    foreach ($arElements as $iElem){
        $res = CIBlockElement::GetByID($iElem);
        if($ar_res = $res->GetNext()){
            if(!isset($finderSection[$ar_res['IBLOCK_SECTION_ID']])){
                $finderSection[$ar_res['IBLOCK_SECTION_ID']]['ID'] = $ar_res['IBLOCK_SECTION_ID'];
                $finderSection[$ar_res['IBLOCK_SECTION_ID']]['COUNT'] = 1;
            }else{
                $finderSection[$ar_res['IBLOCK_SECTION_ID']]['COUNT'] += 1;
            }
        }
    }
    //debug($finderSection);?>

    <div class="lb">
        <div class="catalog-search">
            <div class="title">
                Найдено в разделах
            </div>
            <ul class="parent topCatalog">
                <?foreach ($finderSection as $iFinderSection){
                    $res = CIBlockSection::GetByID($iFinderSection['ID']);
                    if($ar_res = $res->GetNext()){
                        $url = array_merge($_GET, ['where' => $ar_res['ID']]);
                        //debug(http_build_query($url));
                    ?>
                    <li class="parent <?if($_GET['where']==$ar_res['ID']):?>active<?endif;?>">
                        <a href="/search/index.php?<?=http_build_query($url)?>">
                            <?=$ar_res['NAME']?> (<?=$iFinderSection['COUNT']?>)
                        </a>
                    </li>
                    <?}?>
                <?}?>
            </ul>
        </div>
    </div>


    <?
//    if($finderSection){
//        foreach ($finderSection as $iFinderSection){
//            $res = CIBlockSection::GetByID($iFinderSection);
//            if($ar_res = $res->GetNext()){
//                debug($ar_res['SORT'].' '.$ar_res['NAME']);
//            }
//        }
//    }
	?>
<?//debug($arParams["PAGE_ELEMENT_COUNT"])?>
    <div class="rb">
        <div class="content-block regular-block" style="margin: 0">
            <div class="common-content-thin collections-page category-page">
    <?
	$APPLICATION->IncludeComponent(
		"bitrix:catalog.section",
		".default",
		array(
			"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
			"IBLOCK_ID" => $arParams["IBLOCK_ID"],
			"ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
			"ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
			"ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
			"ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
			"PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
			"LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
			"PROPERTY_CODE" => $arParams["PROPERTY_CODE"],
			"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
			"OFFERS_FIELD_CODE" => $arParams["OFFERS_FIELD_CODE"],
			"OFFERS_PROPERTY_CODE" => $arParams["OFFERS_PROPERTY_CODE"],
			"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
			"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
			"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
			"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
			"OFFERS_LIMIT" => $arParams["OFFERS_LIMIT"],
			"SECTION_URL" => $arParams["SECTION_URL"],
			"DETAIL_URL" => $arParams["DETAIL_URL"],
			"BASKET_URL" => $arParams["BASKET_URL"],
			"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
			"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
			"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
			"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
			"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
			"CACHE_TYPE" => $arParams["CACHE_TYPE"],
			"CACHE_TIME" => $arParams["CACHE_TIME"],
			"DISPLAY_COMPARE" => $arParams["DISPLAY_COMPARE"],
			"PRICE_CODE" => $arParams["PRICE_CODE"],
			"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
			"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
			"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
			"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
			"USE_PRODUCT_QUANTITY" => $arParams["USE_PRODUCT_QUANTITY"],
			"CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
			"CURRENCY_ID" => $arParams["CURRENCY_ID"],
			"HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
			"HIDE_NOT_AVAILABLE_OFFERS" => $arParams["HIDE_NOT_AVAILABLE_OFFERS"],
			"DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
			"DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
			"PAGER_TITLE" => $arParams["PAGER_TITLE"],
			"PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
			"PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
			"PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
			"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
			"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
			"FILTER_NAME" => "searchFilter",
			"SECTION_ID" => "",
			"SECTION_CODE" => "",
			"SECTION_USER_FIELDS" => array(),
			"INCLUDE_SUBSECTIONS" => "Y",
			"SHOW_ALL_WO_SECTION" => "Y",
			"META_KEYWORDS" => "",
			"META_DESCRIPTION" => "",
			"BROWSER_TITLE" => "",
			"ADD_SECTIONS_CHAIN" => "N",
			"SET_TITLE" => "N",
			"SET_STATUS_404" => "N",
			"CACHE_FILTER" => "N",
			"CACHE_GROUPS" => "N",
		),
		$arResult["THEME_COMPONENT"],
		array('HIDE_ICONS' => 'Y')
	);
    ?>
            </div>
        </div>
    </div>
    <?
}
elseif (is_array($arElements))
{
	echo GetMessage("CT_BCSE_NOT_FOUND");
}