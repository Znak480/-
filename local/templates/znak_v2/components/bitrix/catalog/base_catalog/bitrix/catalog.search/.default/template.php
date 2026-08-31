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

		function searchCatalog($phrase, $iblockId) {
			if (strlen($phrase) < 3) return null;
			
			CModule::IncludeModule("search");
			CModule::IncludeModule("iblock");
			
			// Используем стандартный поиск Bitrix
			$search = new CSearch();
			$search->Search([
				'QUERY' => $phrase,
				'SITE_ID' => SITE_ID,
				'MODULE_ID' => 'iblock',
				'PARAM1' => 'catalog',
				'PARAM2' => $iblockId,
				'CHECK_DATES' => 'N',
			]);
			
			$ids = [];
			while ($ar = $search->Fetch()) {
				$ids[] = $ar['ITEM_ID'];
			}
			
			return $ids;
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

			if($_GET['where']){
				$searchFilter=array_merge($searchFilter,array("SECTION_ID"=>$_GET['where']));
			}
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
						"SEARCH" => $_REQUEST['q'],
        				"USE_SEARCH" => "Y",
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