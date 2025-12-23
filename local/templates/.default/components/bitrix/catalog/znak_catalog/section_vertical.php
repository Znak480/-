<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;
?>

	<? global $section_list,$isSubsections;
	global $currentCity;
	$section_list=false;
	?>


<div class="rb">

    <div class="common-content-thin collections-page">
        <div class="title-block regular-block">
            <?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "znak", Array(
                "COMPONENT_TEMPLATE" => ".default",
                "START_FROM" => "0",	// Номер пункта, начиная с которого будет построена навигационная цепочка
                "PATH" => "",	// Путь, для которого будет построена навигационная цепочка (по умолчанию, текущий путь)
                "SITE_ID" => "-",	// Cайт (устанавливается в случае многосайтовой версии, когда DOCUMENT_ROOT у сайтов разный)
            ),
                false
            );?>
        </div>
	<?
if (empty($_GET['set_filter']) and $_GET['set_filter']!='y'){
	$APPLICATION->IncludeComponent(
		"bitrix:catalog.section.list",
		"",
		array(
			"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
			"IBLOCK_ID" => $arParams["IBLOCK_ID"],
			"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
			"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
			"CACHE_TYPE" => $arParams["CACHE_TYPE"],
			"CACHE_TIME" => $arParams["CACHE_TIME"],
			"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
			"COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
			"TOP_DEPTH" => $arParams["SECTION_TOP_DEPTH"],
			"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
			"VIEW_MODE" => $arParams["SECTIONS_VIEW_MODE"],
			"SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"],
			"HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
			"ADD_SECTIONS_CHAIN" => "N",//(isset($arParams["ADD_SECTIONS_CHAIN"]) ? $arParams["ADD_SECTIONS_CHAIN"] : ''),
			"CACHE_TYPE" => $arParams["CACHE_TYPE"],
			"CACHE_TIME" => $arParams["CACHE_TIME"]
		),
		$component,
		array("HIDE_ICONS" => "Y")
	);
}
	?>
    </div>
</div>

	<?if (!$section_list):?>
	<div class="rb">
	<div class="common-content-thin collections-page category-page">
		<div class="title-block regular-block" style="display: none">
		 <?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "znak", Array(
	"COMPONENT_TEMPLATE" => ".default",
		"START_FROM" => "0",	// Номер пункта, начиная с которого будет построена навигационная цепочка
		"PATH" => "",	// Путь, для которого будет построена навигационная цепочка (по умолчанию, текущий путь)
		"SITE_ID" => "-",	// Cайт (устанавливается в случае многосайтовой версии, когда DOCUMENT_ROOT у сайтов разный)
	),
	false
);?>


		</div>
		<div class="content-block regular-block">
            <?
            $depthLevelSection = '';
            $res = CIBlockSection::GetByID($arResult['VARIABLES']['SECTION_ID']);
            if($ar_res = $res->GetNext()){
                $depthLevelSection = $ar_res['DEPTH_LEVEL'];
            }
            ?>
            <?if ($depthLevelSection!=1){?>
                <?$this->SetViewTarget("filter");?>
                    <?$APPLICATION->IncludeComponent(
                    "bitrix:catalog.smart.filter",
                    "new",
                    array(
                        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                        "SECTION_ID" => $arCurSection['ID'],
                        "FILTER_NAME" => $arParams["FILTER_NAME"],
                        "PRICE_CODE" => $arParams["PRICE_CODE"],
                        "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                        "CACHE_TIME" => $arParams["CACHE_TIME"],
                        "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                        "SAVE_IN_SESSION" => "N",
                        "FILTER_VIEW_MODE" => $arParams["FILTER_VIEW_MODE"],
                        "XML_EXPORT" => "Y",
                        "SECTION_TITLE" => "NAME",
                        "SECTION_DESCRIPTION" => "DESCRIPTION",
                        'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
                        "TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"],
                        'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
                        'CURRENCY_ID' => $arParams['CURRENCY_ID'],
                        "SEF_MODE" => "N",//$arParams["SEF_MODE"],
                        "SEF_RULE" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["smart_filter"],
                        "SMART_FILTER_PATH" => $arResult["VARIABLES"]["SMART_FILTER_PATH"],
                        "PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
                    ),
                    $component,
                    array('HIDE_ICONS' => 'Y')
                    );?>
                <?$this->EndViewTarget();?>
            <?}?>

	<?
    // $sortf2 = $arParams["ELEMENT_SORT_FIELD2"];
    // $dist2 = $arParams["ELEMENT_SORT_ORDER2"];
	// if ($_GET["sort"]){
	//     if($_GET["sort"]=="popular"){
	//         $sortf="SHOW_COUNTER";
    //         $dist="DESC";
    //         //$sortf2="PROPERTY_HIT";
    //         //$dist2="DESC";
    //     } else {
    //         $sortf="NAME";
    //         $dist=$_GET["sort"];
    //     }
	// } else {
	// 	$sortf="SORT";
	// 	$dist="ASC";	
	// }
	if ($_GET["count"]) {
		$count=$_GET["count"];
	} else {
		$count=$arParams['PAGE_ELEMENT_COUNT'];	
	}

	if ($_COOKIE['setsort'] == 'price') {
        $sortf = "CATALOG_PRICE_" . $currentCity['PRICE_ID']['VALUE'];
    }
    if ($_COOKIE['setsort'] == 'name') {
        $sortf = "NAME";
    }
    if ($_COOKIE['setsort'] == 'popular') {
        $sortf = "SORT";
    }
    if ($_COOKIE['setsort'] == 'skidka_po_karte') {
        $sortf = "PROPERTY_SKIDKA_PO_KARTE_";
    }

    //                //if($_COOKIE['setsort']=='new'){$sortfield="ID";}
    //
    if ($_COOKIE['setdirection'] == 'desc') {
        $dist = "desc";
    }
    if ($_COOKIE['setdirection'] == 'asc') {
        $dist = "asc";
    }

    //echo $_COOKIE['setdirection'].' '.$_COOKIE['setsort'];

    if(!$sortf && !$dist){
        $sortf='SORT'; $dist='desc';
    }
	//echo $numberProducts = $APPLICATION->GetCurPageParam('count='.$count,array('PAGEN_2','count'),false);
	 //debug($currentCity['PRICE_ID']['VALUE']);
    //echo $sortf.' '.$dist;
?>
            
            <div class="products">
                <div class="control">
                    <div class="sort">
                        <select id="sortirovka" name="sort" >
                            <option value="name" <?if($sortf=="NAME" && $dist=='asc'):?>selected<?endif;?>
                                data-href="/ajx/setsort.php?sort=name&direction=asc"
                            >Сортировать по названию А–я</option>
                            <option value="name1" <?if($sortf=="NAME" && $dist=='desc'):?>selected<?endif;?>
                                data-href="/ajx/setsort.php?sort=name&direction=desc"
                            >Сортировать по названию Я–а</option>
                            <option value="popular" <?if($sortf=="SORT"):?>selected<?endif;?>
                                data-href="/ajx/setsort.php?sort=popular&direction=desc"
                            >Сортировать по популярности</option>
                            <option value="price" <?if($sortf=="CATALOG_PRICE_".$currentCity['PRICE_ID']['VALUE'] && $dist=='asc'):?>selected<?endif;?>
                                data-href="/ajx/setsort.php?sort=price&direction=asc"
                            >По возрастанию цены</option>
                            <option value="price1" <?if($sortf=="CATALOG_PRICE_".$currentCity['PRICE_ID']['VALUE'] && $dist=='desc'):?>selected<?endif;?>
                                data-href="/ajx/setsort.php?sort=price&direction=desc"
                            >По убыванию цены</option>
                            <option value="skidka_po_karte" <?if($sortf=="PROPERTY_SKIDKA_PO_KARTE_"):?>selected<?endif;?>
                                data-href="/ajx/setsort.php?sort=skidka_po_karte&direction=desc"
                            >Сначала выгодные</option>
                        </select>
                    </div>
                    <!-- <div class="count">

                        <select name="count" >
                            <option value="12" data-href="<?=$APPLICATION->GetCurPageParam('count=12',array('PAGEN_2','count'),false);?>">Показывать 12 товаров</option>
                            <option value="24" data-href="<?=$APPLICATION->GetCurPageParam('count=24',array('PAGEN_2','count'),false);?>" <?if ($_GET["count"]=="24" ):?>selected<?endif;?>>Показывать 24 товаров</option>
                            <option value="36" data-href="<?=$APPLICATION->GetCurPageParam('count=36',array('PAGEN_2','count'),false);?>" <?if ($_GET["count"]=="36" ):?>selected<?endif;?>>Показывать 36 товаров</option>
                            <option value="120" data-href="<?=$APPLICATION->GetCurPageParam('count=120',array('PAGEN_2','count'),false);?>" <?if ($_GET["count"]=="120" ):?>selected<?endif;?>>Показывать 120 товаров</option>
                            <option value="9999"data-href="<?=$APPLICATION->GetCurPageParam('count=9999',array('PAGEN_2','count'),false);?>" <?if ($_GET["count"]=="9999" ):?>selected<?endif;?>>Показать все</option>
                        </select>

                    </div> -->

                </div>

<?

global $arrFilter;
if(!empty($_GET['arrFilter_stock']) and $_GET['arrFilter_stock']=='Y'){
    //$arrFilter['!PROPERTY_466'] = false;
    //debug($arParams["IBLOCK_ID"]);
    // Барнаул
    if($arParams["IBLOCK_ID"] == 19){
    	$arrFilter['!PROPERTY_2529'] = false;	
    }
    // Майма
    if($arParams["IBLOCK_ID"] == 21){
		$arrFilter['!PROPERTY_3069'] = false;	
    }
    
    //$sortf = "PROPERTY_SKIDKA_PO_KARTE_";
    //$dist = "asc";
}
//echo '<pre>'; print_r($currentCity["IBLOCK_CATALOG"]["VALUE"]); echo '</pre>';

//описание раздела из шаблона раздела
$APPLICATION->ShowViewContent('sectionDiscription');
?>
<?
//echo '<p>'.$sortf.' '.$dist.'</p>';
//echo '<p>'.$sortf2.' '.$dist2.'</p>';
?>
            <?
	$intSectionID = $APPLICATION->IncludeComponent(
		"bitrix:catalog.section",
		"",
		array(
			"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
			"IBLOCK_ID" => $arParams["IBLOCK_ID"],
			"ELEMENT_SORT_FIELD" => $sortf,
			"ELEMENT_SORT_ORDER" => $dist,
			"ELEMENT_SORT_FIELD2" => $sortf2,//$arParams["ELEMENT_SORT_FIELD2"],
			"ELEMENT_SORT_ORDER2" => $dist2,//$arParams["ELEMENT_SORT_ORDER2"],
			"PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
			"META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
			"META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
			"BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
			"SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
			"INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
			"BASKET_URL" => $arParams["BASKET_URL"],
			"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
			"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
			"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
			"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
			"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
			"FILTER_NAME" => $arParams["FILTER_NAME"],
			"CACHE_TYPE" => $arParams["CACHE_TYPE"],
			"CACHE_TIME" => $arParams["CACHE_TIME"],
			"CACHE_FILTER" => $arParams["CACHE_FILTER"],
			"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
			"SET_TITLE" => $arParams["SET_TITLE"],
			"MESSAGE_404" => $arParams["MESSAGE_404"],
			"SET_STATUS_404" => $arParams["SET_STATUS_404"],
			"SHOW_404" => $arParams["SHOW_404"],
			"FILE_404" => $arParams["FILE_404"],
			"DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
			"PAGE_ELEMENT_COUNT" => $count, ///4
			"LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
			"PRICE_CODE" => $arParams["PRICE_CODE"],
			"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
			"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],

			"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
			"USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
			"ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
			"PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
			"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],

			"DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
			"DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
			"PAGER_TITLE" => $arParams["PAGER_TITLE"],
			"PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
			"PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
			"PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
			"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
			"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
			"PAGER_BASE_LINK_ENABLE" => $arParams["PAGER_BASE_LINK_ENABLE"],
			"PAGER_BASE_LINK" => $arParams["PAGER_BASE_LINK"],
			"PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],

			"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
			"OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
			"OFFERS_PROPERTY_CODE" => $arParams["LIST_OFFERS_PROPERTY_CODE"],
			"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
			"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
			"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
			"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
			"OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],

			"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
			"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
			"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
			"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
			"USE_MAIN_ELEMENT_SECTION" => $arParams["USE_MAIN_ELEMENT_SECTION"],
			'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
			'CURRENCY_ID' => $arParams['CURRENCY_ID'],
			'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],

			'LABEL_PROP' => $arParams['LABEL_PROP'],
			'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
			'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],

			'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
			'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
			'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
			'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
			'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
			'MESS_BTN_BUY' => $arParams['MESS_BTN_BUY'],
			'MESS_BTN_ADD_TO_BASKET' => $arParams['MESS_BTN_ADD_TO_BASKET'],
			'MESS_BTN_SUBSCRIBE' => $arParams['MESS_BTN_SUBSCRIBE'],
			'MESS_BTN_DETAIL' => $arParams['MESS_BTN_DETAIL'],
			'MESS_NOT_AVAILABLE' => $arParams['MESS_NOT_AVAILABLE'],

			'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
			"ADD_SECTIONS_CHAIN" => "Y",
			'ADD_TO_BASKET_ACTION' => $basketAction,
			'SHOW_CLOSE_POPUP' => isset($arParams['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['COMMON_SHOW_CLOSE_POPUP'] : '',
			'COMPARE_PATH' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['compare']
		),
		$component
	);?>
            </div>


        </div>


    </div>
    </div>
        <div class="arrowUp" style="opacity: 1; display: none;"></div>


	<?endif;?>
		