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

		// прочитаем файл замены
		$synS = \Craft\Factory\SynonymServiceFactory::getService();
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
		$originalPhrase = $phrase;
		$phrase=str_replace($zamenafrom, $zamenato, $phrase);

		// Получаем синонимы для всего запроса
		$allSynonyms = $synS->findSynonyms($phrase);
		$allSynonyms = array_filter($allSynonyms, function($syn) use ($phrase) {
			return mb_strtolower(trim($syn)) != mb_strtolower(trim($phrase));
		});

		// Добавляем оригинальный запрос в начало
		array_unshift($allSynonyms, $phrase);

		// Если есть оригинальная фраза (до замен), тоже добавляем
		if($originalPhrase != $phrase) {
			array_unshift($allSynonyms, $originalPhrase);
		}

		// Уникализируем
		$allSynonyms = array_unique($allSynonyms);

		// Для каждого синонима ищем товары
		foreach($allSynonyms as $searchTerm) {
			$searchTerm = trim($searchTerm);
			if(mb_strlen($searchTerm) < 3) continue;

			// 1. Поиск полного совпадения (если длинная фраза)
			if(mb_strlen($searchTerm) > 5) {
				$safeTerm = $DB->ForSql($searchTerm);
				$results = $DB->Query("
				SELECT ID FROM b_iblock_element 
				WHERE IBLOCK_ID = $iblock 
				AND ACTIVE = 'Y'
				AND (
					NAME LIKE '$safeTerm%' 
					OR NAME LIKE '% $safeTerm%' 
					OR NAME LIKE '%-$safeTerm%'
					OR NAME = '$safeTerm'
				)
			");

				while($row = $results->Fetch()) {
					if(!in_array($row['ID'], $elementIDS)) {
						$elementIDS[] = $row['ID'];
					}
				}
			}

			// 2. Разбиваем на слова и ищем каждое слово
			$words = preg_split('/\s+/', $searchTerm);
			foreach($words as $word) {
				$word = trim($word);
				if(mb_strlen($word) < 3) continue;

				$safeWord = $DB->ForSql($word);

				// Ищем слово целиком (с пробелами вокруг)
				$results = $DB->Query("
				SELECT ID FROM b_iblock_element 
				WHERE IBLOCK_ID = $iblock 
				AND ACTIVE = 'Y'
				AND (
					NAME LIKE '$safeWord %'
					OR NAME LIKE '% $safeWord %'
					OR NAME LIKE '% $safeWord'
					OR NAME LIKE '%-$safeWord %'
					OR NAME LIKE '%-$safeWord'
					OR NAME LIKE '$safeWord-%'
				)
			");

				while($row = $results->Fetch()) {
					if(!in_array($row['ID'], $elementIDS)) {
						$elementIDS[] = $row['ID'];
					}
				}

				// Ищем слово как часть слова (без учета пробелов)
				$results = $DB->Query("
				SELECT ID FROM b_iblock_element 
				WHERE IBLOCK_ID = $iblock 
				AND ACTIVE = 'Y'
				AND (
					NAME LIKE '%$safeWord%'
				)
			");

				while($row = $results->Fetch()) {
					if(!in_array($row['ID'], $elementIDS)) {
						$elementIDS[] = $row['ID'];
					}
				}
			}
		}

		// 3. Если все еще ничего не нашли, используем стемминг
		if(count($elementIDS) == 0 && strlen($phrase) > 4) {
			$stemmedWords = array_keys(stemming($phrase));
			foreach($stemmedWords as $stem) {
				$stem = trim($stem);
				if(mb_strlen($stem) < 3) continue;

				$safeStem = $DB->ForSql($stem);
				$results = $DB->Query("
				SELECT ID FROM b_iblock_element 
				WHERE IBLOCK_ID = $iblock 
				AND ACTIVE = 'Y'
				AND NAME LIKE '%$safeStem%'
			");

				while($row = $results->Fetch()) {
					if(!in_array($row['ID'], $elementIDS)) {
						$elementIDS[] = $row['ID'];
					}
				}
			}
		}

		// 4. Поиск в описании (если все еще не нашли)
		if(count($elementIDS) == 0 && strlen($phrase) > 4) {
			$safePhrase = $DB->ForSql($phrase);
			$results = $DB->Query("
			SELECT ITEM_ID FROM b_search_content 
			WHERE PARAM2 = $iblock 
			AND PARAM1 = 'catalog'
			AND (BODY LIKE '%$safePhrase%' OR TITLE LIKE '%$safePhrase%')
		");

			while($row = $results->Fetch()) {
				if(!in_array($row['ITEM_ID'], $elementIDS)) {
					$elementIDS[] = $row['ITEM_ID'];
				}
			}
		}

		if(count($elementIDS) == 0) {
			$elementIDS[0] = 9999999999;
		}

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