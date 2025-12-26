                <div class="search-page">
		
<form action="" method="get">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tbody><tr>
				<td style="width: 100%;">
											<input class="search-query" type="text" name="q" value="<?=$_REQUEST['q']?>">
									</td>
				<td>
					&nbsp;
				</td>
				<td>
					<input class="search-button" type="submit" value="Найти">
				</td>
			</tr>
		</tbody></table>

	</form>

</div>




                <!--form>
                    <div class="form-group ">
                        <div class="input-group">
                            <span>Поиск по товару:</span>
                            <input type="text" class="form-control" name="q" value="<?=($_GET['q'])?:''?>">
                            <span class="input-group-addon search-field">
				<span class="close"></span>
                      		<button type="submit"><i class="material-icons">search</i></button>
                    		</span>
                        </div>
                    </div>
                </form> <br><br -->


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
global $currentCity;

	function searchCatalog($phrase, $iblock) {
		if(strlen($phrase)<3) return [0=>999999999999];
		CModule::IncludeModule("search");
		CModule::IncludeModule("catalog");
		CModule::IncludeModule("iblock");

		$arElements=array();
		global $arRankedElements;
		global $_REQUEST;
		$arrFilter=array('IBLOCK_ID'=>$iblock, 'ACTIVE'=>'Y');
		$elementIDS=array();
		global $DB;
		$sortArray=array();
		$synS=\Craft\Factory\SynonymServiceFactory::getService();

		$s=   $synS->findSynonyms($phrase);
		$s = array_filter($s,fn($syn)=> mb_strtolower($phrase) != $syn);

		$phrase .= ' '.implode(' ', $s);


		//
		// прочитаем файл замены
		//
		$zamenafrom=array();
		$zamenato=array();
		$zamena=file($_SERVER['DOCUMENT_ROOT']."/zamena.csv");
		foreach($zamena as $s) {
			$pieces=explode(";",iconv("cp1251","UTF-8",$s));
			if(trim($pieces[0])&&trim($pieces[1])){
				$zamenafrom[]=trim($pieces[0]);
				$zamenato[]=trim($pieces[1]);
			}
		}
		$phrase=str_replace($zamenafrom, $zamenato, $phrase);
		//
		//
		// сначала ищем полное вхождение всей строки если несколько слов в запросе. это будет максимально релевантный результат, например ищут скопированное имя товара
		//
		$arQ=explode(' ',$phrase);

		\Bitrix\Main\Diag\Debug::dump($arQ);
		//
		//
		if(count($arQ)>1&&strlen($phrase)>5) {
			$results = $DB->Query("SELECT ID from b_iblock_element where ((NAME like '$phrase%') or (NAME like '% $phrase%') or (NAME like '%-$phrase%')) and IBLOCK_ID=$iblock and ACTIVE='Y'");
			$cnt=0;
			while($row = $results->Fetch()){
				if(!in_array($row['ID'],$elementIDS)){
					$elementIDS[]=$row['ID'];
				}
			}
		}
		//
		// теперь ищем полное вхождение слов в название  -- именно слова целиком с пробелом
		//
		$whereStr="";
		foreach($arQ as $strQ) {
			$strQ=trim($strQ);
			$synQ=array(); // заглушка для синонимов
			$synQ[]=$strQ;
			$wherePart="";	
			foreach($synQ as $s) {
				if(mb_strlen(trim($s))>=3){
					$wherePart.="(NAME like '$s %') or (NAME like '% $s %') or (NAME like '%-$s %') or ";
				}
			}
			if($wherePart) {
				$wherePart.="1<0";
				$whereStr.="(".$wherePart.") and ";
			}
		}
		\Bitrix\Main\Diag\Debug::dump("SELECT ID from b_iblock_element where $whereStr IBLOCK_ID=$iblock and ACTIVE='Y'");
		$results = $DB->Query("SELECT ID from b_iblock_element where $whereStr IBLOCK_ID=$iblock and ACTIVE='Y'");
		$cnt=0;
		while($row = $results->Fetch()){
			if(!in_array($row['ID'],$elementIDS)){
				$elementIDS[]=$row['ID'];
			}
		}
	
		//
		// теперь ищем полное вхождение слов в название
		//
		$whereStr="";
		foreach($arQ as $strQ) {
			$strQ=trim($strQ);
			$synQ=array(); // заглушка для синонимов
			$synQ[]=$strQ;
			$wherePart="";	
			foreach($synQ as $s) {
				if(mb_strlen(trim($s))>=3){
					$wherePart.="(NAME like '$s%') or (NAME like '% $s%') or (NAME like '%-$s%') or ";
				}
			}
			if($wherePart) {
				$wherePart.="1<0";
				$whereStr.="(".$wherePart.") and ";
			}
		}
		$results = $DB->Query("SELECT ID from b_iblock_element where $whereStr IBLOCK_ID=$iblock and ACTIVE='Y'");
		$cnt=0;
		while($row = $results->Fetch()){
			if(!in_array($row['ID'],$elementIDS)){
				$elementIDS[]=$row['ID'];
			}
		}
		//
		// потом берем основы слов и еще раз ищем, это нужно для ранжирования
		//
		if(strlen($phrase)>4) {
		$arQ=array_keys(stemming($phrase));
		$whereStr="";
		foreach($arQ as $strQ) {
			$synQ=array();
			$strQ=trim($strQ);
			$synQ[]=$strQ;
			$wherePart="";	
			foreach($synQ as $s) {
				if(mb_strlen(trim($s))>=3){
					$wherePart.="(NAME like '$s%') or (NAME like '% $s%') or (NAME like '%-$s%') or ";
				}
			}
			if($wherePart) {
				$wherePart.="1<0";
				$whereStr.="(".$wherePart.") and ";
			}
		}
		//
		$results = $DB->Query("SELECT ID from b_iblock_element where $whereStr IBLOCK_ID=$iblock and ACTIVE='Y'");
		$cnt=0;
		while($row = $results->Fetch()){
			if(!in_array($row['ID'],$elementIDS)){
				$elementIDS[]=$row['ID'];
			}
		}
		}
		//
		// теперь ищем полное вхождение слов в описание
		//
		if(strlen($phrase)>4) {
		$whereStr="";
		foreach($arQ as $strQ) {
			$strQ=trim($strQ);
			$synQ=array(); // заглушка для синонимов
			$synQ[]=$strQ;
			$wherePart="";	
			foreach($synQ as $s) {
				if(mb_strlen(trim($s))>=3){
					$wherePart.="(BODY like '$s%') or (BODY like '% $s%') or (BODY like '%-$s%') or ";
				}
			}
			if($wherePart) {
				$wherePart.="1<0";
				$whereStr.="(".$wherePart.") and ";
			}
		}
		$results = $DB->Query("SELECT ITEM_ID from b_search_content where $whereStr PARAM2=$iblock and PARAM1='catalog'");
		$cnt=0;
		while($row = $results->Fetch()){
			if(!in_array($row['ITEM_ID'],$elementIDS)){
				$elementIDS[]=$row['ITEM_ID'];
			}
		}
		}
		//
		// потом берем основы слов и еще раз ищем в описании
		//
		if(strlen($phrase)>4) {
		$arQ=array_keys(stemming($phrase));
		$whereStr="";
		foreach($arQ as $strQ) {
			$synQ=array();
			$strQ=trim($strQ);
			$synQ[]=$strQ;
			$wherePart="";	
			foreach($synQ as $s) {
				if(mb_strlen(trim($s))>=3){
					$wherePart.="(BODY like '$s%') or (BODY like '% $s%') or (BODY like '%-$s%') or ";
				}
			}
			if($wherePart) {
				$wherePart.="1<0";
				$whereStr.="(".$wherePart.") and ";
			}
		}
		//
		$results = $DB->Query("SELECT ITEM_ID from b_search_content where $whereStr PARAM2=$iblock and PARAM1='catalog'");
		$cnt=0;
		while($row = $results->Fetch()){
			if(!in_array($row['ITEM_ID'],$elementIDS)){
				$elementIDS[]=$row['ITEM_ID'];
			}
		}
                }
		if(count($elementIDS)==0) $elementIDS[0]=9999999999; // костыль если ничего не нашли 
		return $elementIDS;
	}
	$arElements=searchCatalog($_REQUEST['q'], $currentCity["IBLOCK_CATALOG"]["VALUE"]);


/*
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
*/
//debug($arElements);
//print_r($arElements);
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
			"ELEMENT_SORT_FIELD" => "ID",//$arParams["ELEMENT_SORT_FIELD"],
			"ELEMENT_SORT_ORDER" => $arElements, //$arParams["ELEMENT_SORT_ORDER"],
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
			"PAGER_DESC_NUMBERING" => "N",//$arParams["PAGER_DESC_NUMBERING"],
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