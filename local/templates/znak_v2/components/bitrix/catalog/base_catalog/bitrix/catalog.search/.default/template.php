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
				
$searchTitle = GetMessage("SEARCH_TITLE") . (!empty($_REQUEST['q']) ? ': ' . htmlspecialchars($_REQUEST['q']) : '');

if (!empty($_REQUEST['q'])) {
    $APPLICATION->AddChainItem($searchTitle );
}else{
	$APPLICATION->AddChainItem(GetMessage("SEARCH_TITLE"));
}

$APPLICATION->SetTitle($searchTitle);

global $searchFilter;
?>
<section class='catalog-products catalog-products--specific'>
	<div class='container'>
		<?
		global $currentCity;

		function searchCatalog($phrase, $iblock) {

			if(strlen($phrase)<3) return null;
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
				$elementIDS = null;
			}

			return $elementIDS;
		}
		$arElements=searchCatalog($_REQUEST['q'], $currentCity["IBLOCK_CATALOG"]["VALUE"]);

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

			$searchFilter = array(
						"=ID" => $arElements,
					);
		?>

		<? if(!empty($arElements) && is_array($arElements)): ?>
		<div class='catalog-products-content catalog-products-content--two-columns'>
			<aside class="search-category">
				<h2 class="search-title">Найдено в категориях:</h2>
				<ul class="category-list">
					<!-- Кнопка "Все" всегда первая -->
					<li class="category-item <?= (!isset($_GET['where']) || empty($_GET['where'])) ? 'active' : '' ?>">
						<a href="/catalog/?<?= http_build_query(array_merge($_GET, ['where' => ''])) ?>" class="category-link">
							<span class="category-name">Все</span>
							<span class="category-count">(<?= array_sum(array_column($finderSection, 'COUNT')) ?>)</span>
						</a>
					</li>

					<?php foreach ($finderSection as $iFinderSection):
						$res = CIBlockSection::GetByID($iFinderSection['ID']);
						if ($ar_res = $res->GetNext()):
							$url = array_merge($_GET, ['where' => $ar_res['ID']]);
							$isActive = (isset($_GET['where']) && $_GET['where'] == $ar_res['ID']);
					?>
						<li class="category-item <?= $isActive ? 'active' : '' ?>">
							<a href="/catalog/?<?= http_build_query($url) ?>" class="category-link">
								<span class="category-name"><?= htmlspecialchars($ar_res['NAME']) ?></span>
								<span class="category-count">(<?= $iFinderSection['COUNT'] ?>)</span>
							</a>
						</li>
					<?php endif; endforeach; ?>
				</ul>
			</aside>
			<div class="catalog-products-wrapper">
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
						"ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
						"PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
						"CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
						"CURRENCY_ID" => $arParams["CURRENCY_ID"],
						"HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
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

						'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
						'ADD_TO_BASKET_ACTION' => (isset($arParams['ADD_TO_BASKET_ACTION']) ? $arParams['ADD_TO_BASKET_ACTION'] : ''),
						'SHOW_CLOSE_POPUP' => (isset($arParams['SHOW_CLOSE_POPUP']) ? $arParams['SHOW_CLOSE_POPUP'] : ''),
						'COMPARE_PATH' => $arParams['COMPARE_PATH']
					),
					$arResult["THEME_COMPONENT"],
					array('HIDE_ICONS' => 'Y')
				);
				?>
			</div>
		</div>
		<? else: ?>
			<div class="search-results-empty">
				<h2 class="search-results-empty-title"><?= GetMessage("CT_BCSE_NOT_FOUND")?></h2>
				<p class="search-results-empty-text">Попробуйте изменить запрос или проверьте правильность написания</p>
			</div>
		<?endif;?>
	</div>
</section>