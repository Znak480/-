<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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

	<div class="search-page">

		<form action="" method="get">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tbody>
				<tr>
					<td style="width: 100%;">
						<input class="search-query" type="text" name="q" value="<?=htmlspecialcharsEx($_REQUEST['q'] ?? '')?>">
					</td>
					<td>
						&nbsp;
					</td>
					<td>
						<input class="search-button" type="submit" value="Найти">
					</td>
				</tr>
				</tbody>
			</table>

		</form>

	</div>

<?
global $currentCity;

function searchCatalog($phrase, $iblock)
{
	if(mb_strlen($phrase) < 3) return [0 => 999999999999];
	
	CModule::IncludeModule("search");
	CModule::IncludeModule("catalog");
	CModule::IncludeModule("iblock");

	global $DB;
	$elementIDS = [];
	$iblock = intval($iblock);
	$synS = \Craft\Factory\SynonymServiceFactory::getService();

	//
	// прочитаем файл замены
	//
	$zamenafrom = [];
	$zamenato = [];
	$zamenaFile = $_SERVER['DOCUMENT_ROOT'] . "/zamena.csv";
	if(file_exists($zamenaFile) && is_readable($zamenaFile))
	{
		$zamena = file($zamenaFile);
		foreach($zamena as $s)
		{
			$pieces = explode(";", iconv("cp1251", "UTF-8", $s));
			if(trim($pieces[0]) && trim($pieces[1]))
			{
				$zamenafrom[] = trim($pieces[0]);
				$zamenato[] = trim($pieces[1]);
			}
		}
		$phrase = str_replace($zamenafrom, $zamenato, $phrase);
	}
	
	//
	// сначала ищем полное вхождение всей строки если несколько слов в запросе
	//
	$arQ = explode(' ', $phrase);
	$arQ = array_map('trim', $arQ);
	$arQ = array_filter($arQ, function($word) {
		return mb_strlen($word) > 0;
	});
	$arQ = array_unique($arQ);
	$arQ = array_values($arQ);
	
	// Фильтрация стоп-слов
	$stopWords = ['для', 'от', 'до', 'по', 'из', 'в', 'на', 'с', 'к', 'о', 'об', 'при', 'над', 'под', 'за', 'перед', 'через', 'между', 'и', 'а', 'но', 'или', 'либо', 'что', 'как', 'чтобы', 'когда', 'где', 'куда', 'откуда', 'потому', 'так', 'если', 'не', 'ни', 'же', 'бы', 'ли', 'ль', 'у', 'со', 'обо'];
	$arQFiltered = [];
	foreach($arQ as $word)
	{
		$wordLower = mb_strtolower(trim($word));
		if(mb_strlen($word) >= 2 && !in_array($wordLower, $stopWords))
		{
			$arQFiltered[] = $word;
		}
	}
	$arQ = !empty($arQFiltered) ? $arQFiltered : $arQ;
	
	// Работа с синонимами: для каждого слова получаем его синонимы
	$wordsWithSynonyms = [];
	foreach($arQ as $word)
	{
		$synonyms = $synS->findSynonyms($word);
		$synonyms = array_filter($synonyms, fn($syn) => mb_strtolower($word) != mb_strtolower($syn));
		$wordVariants = [$word];
		if(!empty($synonyms) && is_array($synonyms))
		{
			$wordVariants = array_merge($wordVariants, $synonyms);
			$wordVariants = array_unique($wordVariants);
		}
		$wordsWithSynonyms[] = $wordVariants;
	}
	
	// ОТЛАДКА
//	\Bitrix\Main\Diag\Debug::dump([
//		'original_phrase' => $phrase,
//		'filtered_words' => $arQ,
//		'words_with_synonyms' => $wordsWithSynonyms,
//		'iblock_id' => $iblock,
//	], 'SEARCH: Исходные данные');
	
	$phraseEscaped = $DB->ForSQL($phrase, 255);
	
	//
	// 1. Полное вхождение всей фразы
	//
	if(count($arQ) > 1 && mb_strlen($phrase) > 5)
	{
		$sql = "SELECT ID from b_iblock_element where ((NAME like '" . $phraseEscaped . "%') or (NAME like '% " . $phraseEscaped . "%') or (NAME like '%-" . $phraseEscaped . "%')) and IBLOCK_ID=" . $iblock . " and ACTIVE='Y'";
//		\Bitrix\Main\Diag\Debug::dump($sql, 'SEARCH: SQL #1 - Полное совпадение фразы');
		$results = $DB->Query($sql);
		while($row = $results->Fetch())
		{
			$id = intval($row['ID']);
			if(!in_array($id, $elementIDS))
			{
				$elementIDS[] = $id;
			}
		}
	}
	
	//
	// 2. Полное вхождение слов в название (слова целиком с пробелом) - с учетом синонимов
	//
	$whereConditions = [];
	foreach($wordsWithSynonyms as $wordVariants)
	{
		$wordConditions = [];
		foreach($wordVariants as $wordVariant)
		{
			if(mb_strlen($wordVariant) < 3) continue;
			$wordEscaped = $DB->ForSQL($wordVariant, 100);
			$wordConditions[] = "(NAME like '" . $wordEscaped . " %') or (NAME like '% " . $wordEscaped . " %') or (NAME like '%-" . $wordEscaped . " %')";
		}
		if(!empty($wordConditions))
		{
			$whereConditions[] = "(" . implode(" or ", $wordConditions) . ")";
		}
	}
	if(!empty($whereConditions))
	{
		$whereStr = implode(" and ", $whereConditions);
		$sql = "SELECT ID from b_iblock_element where " . $whereStr . " and IBLOCK_ID=" . $iblock . " and ACTIVE='Y'";
//		\Bitrix\Main\Diag\Debug::dump(['words' => $arQ, 'words_with_synonyms' => $wordsWithSynonyms, 'sql' => $sql], 'SEARCH: SQL #2 - Слова целиком с пробелами');
		$results = $DB->Query($sql);
		while($row = $results->Fetch())
		{
			$id = intval($row['ID']);
			if(!in_array($id, $elementIDS))
			{
				$elementIDS[] = $id;
			}
		}
	}
	
	//
	// 3. Частичное вхождение слов в название - с учетом синонимов
	//
	$whereConditions = [];
	foreach($wordsWithSynonyms as $wordVariants)
	{
		$wordConditions = [];
		foreach($wordVariants as $wordVariant)
		{
			if(mb_strlen($wordVariant) < 3) continue;
			$wordEscaped = $DB->ForSQL($wordVariant, 100);
			$wordConditions[] = "(NAME like '" . $wordEscaped . "%') or (NAME like '% " . $wordEscaped . "%') or (NAME like '%-" . $wordEscaped . "%')";
		}
		if(!empty($wordConditions))
		{
			$whereConditions[] = "(" . implode(" or ", $wordConditions) . ")";
		}
	}
	if(!empty($whereConditions))
	{
		$whereStr = implode(" and ", $whereConditions);
		$sql = "SELECT ID from b_iblock_element where " . $whereStr . " and IBLOCK_ID=" . $iblock . " and ACTIVE='Y'";
//		\Bitrix\Main\Diag\Debug::dump(['words' => $arQ, 'words_with_synonyms' => $wordsWithSynonyms, 'sql' => $sql], 'SEARCH: SQL #3 - Частичное вхождение слов');
		$results = $DB->Query($sql);
		while($row = $results->Fetch())
		{
			$id = intval($row['ID']);
			if(!in_array($id, $elementIDS))
			{
				$elementIDS[] = $id;
			}
		}
	}
	
	//
	// 4. Поиск по основам слов (стемминг) - с учетом синонимов
	//
	if(mb_strlen($phrase) > 4 && function_exists('stemming'))
	{
		$phraseForStemming = implode(' ', $arQ);
		$arQStemmed = array_keys(stemming($phraseForStemming));
		$arQStemmed = array_map('trim', $arQStemmed);
		$arQStemmed = array_filter($arQStemmed, function($word) {
			return mb_strlen($word) >= 3;
		});
		
		$whereConditions = [];
		foreach($arQStemmed as $strQ)
		{
			$strQEscaped = $DB->ForSQL($strQ, 100);
			$whereConditions[] = "(NAME like '" . $strQEscaped . "%') or (NAME like '% " . $strQEscaped . "%') or (NAME like '%-" . $strQEscaped . "%')";
		}
		if(!empty($whereConditions))
		{
			$whereStr = implode(" and ", $whereConditions);
			$sql = "SELECT ID from b_iblock_element where " . $whereStr . " and IBLOCK_ID=" . $iblock . " and ACTIVE='Y'";
//			\Bitrix\Main\Diag\Debug::dump(['stemmed_words' => $arQStemmed, 'sql' => $sql], 'SEARCH: SQL #4 - Поиск по основам слов');
			$results = $DB->Query($sql);
			while($row = $results->Fetch())
			{
				$id = intval($row['ID']);
				if(!in_array($id, $elementIDS))
				{
					$elementIDS[] = $id;
				}
			}
		}
	}
	
	// ОТЛАДКА: Итоговый результат
//	\Bitrix\Main\Diag\Debug::dump([
//		'found_elements_count' => count($elementIDS),
//		'found_elements_ids' => array_slice($elementIDS, 0, 20),
//	], 'SEARCH: Итоговый результат');
	
	if(count($elementIDS) == 0)
	{
		$elementIDS[0] = 9999999999; // костыль если ничего не нашли
	}
	return $elementIDS;
}

$searchQuery = isset($_REQUEST['q']) ? trim($_REQUEST['q']) : '';
$arElements = searchCatalog($searchQuery, $currentCity["IBLOCK_CATALOG"]["VALUE"]);


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

$search_array = explode(' ', $_REQUEST['q']);

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


if(!empty($arElements) && is_array($arElements))
{
	global $searchFilter;


	$searchFilter = [
		"=ID" => $arElements,
	];
	if(isset($_GET['where']) && intval($_GET['where']) > 0)
	{
		$searchFilter = array_merge($searchFilter, ["SECTION_ID" => intval($_GET['where'])]);
	}
	//debug(count($arElements));
	//debug($arElements);

	// найдем разделы найденых элементов
	// ИСПРАВЛЕНО: N+1 проблема - используем один запрос вместо N запросов
	$finderSection = [];
	if(!empty($arElements))
	{
		// Получаем все элементы одним запросом
		$arSelect = ["ID", "IBLOCK_SECTION_ID"];
		$arFilter = ["ID" => $arElements, "IBLOCK_ID" => $arParams["IBLOCK_ID"]];
		$res = CIBlockElement::GetList([], $arFilter, false, false, $arSelect);
		while($ar_res = $res->Fetch())
		{
			$sectionId = intval($ar_res['IBLOCK_SECTION_ID']);
			if($sectionId > 0)
			{
				if(!isset($finderSection[$sectionId]))
				{
					$finderSection[$sectionId]['ID'] = $sectionId;
					$finderSection[$sectionId]['COUNT'] = 1;
				} else
				{
					$finderSection[$sectionId]['COUNT'] += 1;
				}
			}
		}
	}

	// Получаем данные всех разделов одним запросом (исправление второй N+1 проблемы)
	$sectionsData = [];
	if(!empty($finderSection))
	{
		$sectionIds = array_keys($finderSection);
		$arFilter = ["ID" => $sectionIds, "IBLOCK_ID" => $arParams["IBLOCK_ID"]];
		$res = CIBlockSection::GetList(["SORT" => "ASC", "NAME" => "ASC"], $arFilter, false, ["ID", "NAME", "SORT"]);
		while($ar_res = $res->GetNext())
		{
			$sectionsData[$ar_res['ID']] = $ar_res;
		}
	}
	//debug($finderSection);
	?>

	<div class="lb">
		<div class="catalog-search">
			<div class="title">
				Найдено в разделах
			</div>
			<ul class="parent topCatalog">
				<? foreach($finderSection as $iFinderSection)
				{
					// Используем заранее полученные данные вместо нового запроса
					if(isset($sectionsData[$iFinderSection['ID']]))
					{
						$ar_res = $sectionsData[$iFinderSection['ID']];
						$url = array_merge($_GET, ['where' => $ar_res['ID']]);
						//debug(http_build_query($url));
						?>
						<li class="parent <? if(isset($_GET['where']) && intval($_GET['where']) == $ar_res['ID']): ?>active<? endif; ?>">
							<a href="/search/index.php?<?=http_build_query($url)?>">
								<?=htmlspecialcharsEx($ar_res['NAME'])?> (<?=$iFinderSection['COUNT']?>)
							</a>
						</li>
						<?
					}
				} ?>
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
	<? //debug($arParams["PAGE_ELEMENT_COUNT"])
	?>
	<div class="rb">
		<div class="content-block regular-block" style="margin: 0">
			<div class="common-content-thin collections-page category-page">
				<?
				$APPLICATION->IncludeComponent(
					"bitrix:catalog.section",
					".default",
					[
						"IBLOCK_TYPE"                     => $arParams["IBLOCK_TYPE"],
						"IBLOCK_ID"                       => $arParams["IBLOCK_ID"],
						"ELEMENT_SORT_FIELD"              => "ID",//$arParams["ELEMENT_SORT_FIELD"],
						"ELEMENT_SORT_ORDER"              => $arParams["ELEMENT_SORT_ORDER"],
						"ELEMENT_SORT_FIELD2"             => $arParams["ELEMENT_SORT_FIELD2"],
						"ELEMENT_SORT_ORDER2"             => $arParams["ELEMENT_SORT_ORDER2"],
						"PAGE_ELEMENT_COUNT"              => $arParams["PAGE_ELEMENT_COUNT"],
						"LINE_ELEMENT_COUNT"              => $arParams["LINE_ELEMENT_COUNT"],
						"PROPERTY_CODE"                   => $arParams["PROPERTY_CODE"],
						"OFFERS_CART_PROPERTIES"          => $arParams["OFFERS_CART_PROPERTIES"],
						"OFFERS_FIELD_CODE"               => $arParams["OFFERS_FIELD_CODE"],
						"OFFERS_PROPERTY_CODE"            => $arParams["OFFERS_PROPERTY_CODE"],
						"OFFERS_SORT_FIELD"               => $arParams["OFFERS_SORT_FIELD"],
						"OFFERS_SORT_ORDER"               => $arParams["OFFERS_SORT_ORDER"],
						"OFFERS_SORT_FIELD2"              => $arParams["OFFERS_SORT_FIELD2"],
						"OFFERS_SORT_ORDER2"              => $arParams["OFFERS_SORT_ORDER2"],
						"OFFERS_LIMIT"                    => $arParams["OFFERS_LIMIT"],
						"SECTION_URL"                     => $arParams["SECTION_URL"],
						"DETAIL_URL"                      => $arParams["DETAIL_URL"],
						"BASKET_URL"                      => $arParams["BASKET_URL"],
						"ACTION_VARIABLE"                 => $arParams["ACTION_VARIABLE"],
						"PRODUCT_ID_VARIABLE"             => $arParams["PRODUCT_ID_VARIABLE"],
						"PRODUCT_QUANTITY_VARIABLE"       => $arParams["PRODUCT_QUANTITY_VARIABLE"],
						"PRODUCT_PROPS_VARIABLE"          => $arParams["PRODUCT_PROPS_VARIABLE"],
						"SECTION_ID_VARIABLE"             => $arParams["SECTION_ID_VARIABLE"],
						"CACHE_TYPE"                      => $arParams["CACHE_TYPE"],
						"CACHE_TIME"                      => $arParams["CACHE_TIME"],
						"DISPLAY_COMPARE"                 => $arParams["DISPLAY_COMPARE"],
						"PRICE_CODE"                      => $arParams["PRICE_CODE"],
						"USE_PRICE_COUNT"                 => $arParams["USE_PRICE_COUNT"],
						"SHOW_PRICE_COUNT"                => $arParams["SHOW_PRICE_COUNT"],
						"PRICE_VAT_INCLUDE"               => $arParams["PRICE_VAT_INCLUDE"],
						"PRODUCT_PROPERTIES"              => $arParams["PRODUCT_PROPERTIES"],
						"USE_PRODUCT_QUANTITY"            => $arParams["USE_PRODUCT_QUANTITY"],
						"CONVERT_CURRENCY"                => $arParams["CONVERT_CURRENCY"],
						"CURRENCY_ID"                     => $arParams["CURRENCY_ID"],
						"HIDE_NOT_AVAILABLE"              => $arParams["HIDE_NOT_AVAILABLE"],
						"HIDE_NOT_AVAILABLE_OFFERS"       => $arParams["HIDE_NOT_AVAILABLE_OFFERS"],
						"DISPLAY_TOP_PAGER"               => $arParams["DISPLAY_TOP_PAGER"],
						"DISPLAY_BOTTOM_PAGER"            => $arParams["DISPLAY_BOTTOM_PAGER"],
						"PAGER_TITLE"                     => $arParams["PAGER_TITLE"],
						"PAGER_SHOW_ALWAYS"               => $arParams["PAGER_SHOW_ALWAYS"],
						"PAGER_TEMPLATE"                  => $arParams["PAGER_TEMPLATE"],
						"PAGER_DESC_NUMBERING"            => "N",//$arParams["PAGER_DESC_NUMBERING"],
						"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
						"PAGER_SHOW_ALL"                  => $arParams["PAGER_SHOW_ALL"],
						"FILTER_NAME"                     => "searchFilter",
						"SECTION_ID"                      => "",
						"SECTION_CODE"                    => "",
						"SECTION_USER_FIELDS"             => [],
						"INCLUDE_SUBSECTIONS"             => "Y",
						"SHOW_ALL_WO_SECTION"             => "Y",
						"META_KEYWORDS"                   => "",
						"META_DESCRIPTION"                => "",
						"BROWSER_TITLE"                   => "",
						"ADD_SECTIONS_CHAIN"              => "N",
						"SET_TITLE"                       => "N",
						"SET_STATUS_404"                  => "N",
						"CACHE_FILTER"                    => "N",
						"CACHE_GROUPS"                    => "N",
					],
					$arResult["THEME_COMPONENT"],
					['HIDE_ICONS' => 'Y']
				);
				?>
			</div>
		</div>
	</div>
	<?
} elseif(is_array($arElements))
{
	echo GetMessage("CT_BCSE_NOT_FOUND");
}