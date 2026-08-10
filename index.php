<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Торговый центр «Знак» – товары для ремонта и строительства");
$APPLICATION->SetPageProperty("keywords", "торговый, центр, знак, товар, ремонт, строительство, отделочный, строительный, материал, инструмент");
$APPLICATION->SetPageProperty("description", "Отделочные и строительные материалы, а также инструменты, текстиль, предметы интерьера, хозтовары, товары для дома – в торговом центре «Знак».");
$APPLICATION->SetTitle("Знак");

use Bitrix\Main\Page\Asset;

global $currentCity;
?>

<!--Main banner start-->
<section class="section hero">
    <div class="container resizeble-container">
		<?$APPLICATION->IncludeComponent(
			"bitrix:news.list",
			"banner",
			Array(
				"ACTIVE_DATE_FORMAT" => "d.m.Y",
				"ADD_SECTIONS_CHAIN" => "N",
				"AJAX_MODE" => "N",
				"AJAX_OPTION_ADDITIONAL" => "",
				"AJAX_OPTION_HISTORY" => "N",
				"AJAX_OPTION_JUMP" => "N",
				"AJAX_OPTION_STYLE" => "N",
				"CACHE_FILTER" => "N",
				"CACHE_GROUPS" => "Y",
				"CACHE_TIME" => "36000000",
				"CACHE_TYPE" => "A",
				"CHECK_DATES" => "Y",
				"COMPONENT_TEMPLATE" => "slider",
				"COMPOSITE_FRAME_MODE" => "A",
				"COMPOSITE_FRAME_TYPE" => "AUTO",
				"DETAIL_URL" => "",
				"DISPLAY_BOTTOM_PAGER" => "Y",
				"DISPLAY_DATE" => "N",
				"DISPLAY_NAME" => "Y",
				"DISPLAY_PICTURE" => "Y",
				"DISPLAY_PREVIEW_TEXT" => "Y",
				"DISPLAY_TOP_PAGER" => "N",
				"FIELD_CODE" => array(0=>"",1=>"",),
				"FILTER_NAME" => "",
				"HIDE_LINK_WHEN_NO_DETAIL" => "N",
				"IBLOCK_ID" => $currentCity["IBLOCK_SLIDER"]["VALUE"],
				"IBLOCK_TYPE" => "news",
				"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
				"INCLUDE_SUBSECTIONS" => "N",
				"MESSAGE_404" => "",
				"NEWS_COUNT" => "15",
				"PAGER_BASE_LINK_ENABLE" => "N",
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "N",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_TEMPLATE" => ".default",
				"PAGER_TITLE" => "Новости",
				"PARENT_SECTION" => "",
				"PARENT_SECTION_CODE" => "",
				"PREVIEW_TRUNCATE_LEN" => "",
				"PROPERTY_CODE" => array(0=>"",1=>"LINK",2=>"ZP",3=>"",),
				"SET_BROWSER_TITLE" => "N",
				"SET_LAST_MODIFIED" => "N",
				"SET_META_DESCRIPTION" => "N",
				"SET_META_KEYWORDS" => "N",
				"SET_STATUS_404" => "N",
				"SET_TITLE" => "N",
				"SHOW_404" => "N",
				"SORT_BY1" => "ACTIVE_FROM",
				"SORT_BY2" => "SORT",
				"SORT_ORDER1" => "DESC",
				"SORT_ORDER2" => "ASC",
				"STRICT_SECTION_CHECK" => "N",
				"SLIDER_ID"=>"hero-banner"
			)
		);?>
	</div>
</section>
<!--Main banner end-->

<!--Services section start-->
<section class="section section-services">
	<div class="container">
		<?$APPLICATION->IncludeComponent(
			"bitrix:news.list",
			"services",
			Array(
				"ACTIVE_DATE_FORMAT" => "d.m.Y",
				"ADD_SECTIONS_CHAIN" => "N",
				"AJAX_MODE" => "N",
				"AJAX_OPTION_ADDITIONAL" => "",
				"AJAX_OPTION_HISTORY" => "N",
				"AJAX_OPTION_JUMP" => "N",
				"AJAX_OPTION_STYLE" => "N",
				"CACHE_FILTER" => "N",
				"CACHE_GROUPS" => "N",
				"CACHE_TIME" => "36000000",
				"CACHE_TYPE" => "A",
				"CHECK_DATES" => "Y",
				"COMPONENT_TEMPLATE" => ".default",
				"DETAIL_URL" => "",
				"DISPLAY_BOTTOM_PAGER" => "N",
				"DISPLAY_DATE" => "N",
				"DISPLAY_NAME" => "Y",
				"DISPLAY_PICTURE" => "Y",
				"DISPLAY_PREVIEW_TEXT" => "Y",
				"DISPLAY_TOP_PAGER" => "N",
				"FIELD_CODE" => array(0=>"",1=>"",),
				"FILTER_NAME" => "",
				"HIDE_LINK_WHEN_NO_DETAIL" => "N",
				"IBLOCK_ID" => $currentCity['IBLOCK_SERVICES']['VALUE'],
				"IBLOCK_TYPE" => "news",
				"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
				"INCLUDE_SUBSECTIONS" => "N",
				"MESSAGE_404" => "",
				"NEWS_COUNT" => "200",
				"PAGER_BASE_LINK_ENABLE" => "N",
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "N",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_TEMPLATE" => ".default",
				"PAGER_TITLE" => "Новости",
				"PARENT_SECTION" => "",
				"PARENT_SECTION_CODE" => "",
				"PREVIEW_TRUNCATE_LEN" => "",
				"PROPERTY_CODE" => array(0=>"",1=>"",),
				"SET_BROWSER_TITLE" => "N",
				"SET_LAST_MODIFIED" => "N",
				"SET_META_DESCRIPTION" => "N",
				"SET_META_KEYWORDS" => "N",
				"SET_STATUS_404" => "N",
				"SET_TITLE" => "N",
				"SHOW_404" => "N",
				"SORT_BY1" => "SORT",
				"SORT_BY2" => "SORT",
				"SORT_ORDER1" => "DESC",
				"SORT_ORDER2" => "ASC"
			)
		);?> 
	</div>
</section>
<!-- Services section end -->


<!--Services hit-sales start-->
<section class="section section-hit-sales">
    <div class="container">
    	<h1 class="section-title">Хит продаж</h1>
		 <div class="section-content section-content--grid">
			<?$APPLICATION->IncludeComponent(
				"znak:catalog.products",
				".default",
				[
					"IBLOCK_ID" => $currentCity['IBLOCK_CATALOG']['VALUE'],
					"ELEMENTS_COUNT" => 4,
					"TITLE" => "Хит продаж",
					"SORT_BY" => "RAND",
					"SORT_ORDER" => "DESC",
					"FILTER" => ["!=PROPERTY_RAITING_PRODAZH" => false],
				],
				false
			);?>
		 </div>
	</div>
</section>
<!--Services hit-sales end -->

<!--Popular section start-->
<section class="section section-popular-category">
	<div class="container">
		<h2 class="section-title">Популярные категории</h2>
	</div>
	<div class="section-content">
        <div class="container">
			<?
				global $arSectionFilter;
				$arSectionFilter = [
					'=UF_ISMAIN' => 1
			
			];

			// Для отладки - посмотрим, сколько разделов попадает под фильтр
			$dbSections = CIBlockSection::GetList(
				['SORT' => 'ASC'],
				[
					'IBLOCK_ID' => $currentCity["IBLOCK_CATALOG"]["VALUE"],
					'ACTIVE' => 'Y',
					'DEPTH_LEVEL' => 1,
					'=UF_ISMAIN' => 1,
				],
				false,
				['ID', 'NAME', 'SORT']
			);

			echo "Отладка: разделы с SORT != 1\n";
				while ($arSection = $dbSections->Fetch()) {
				echo " ID: {$arSection['ID']}, NAME: {$arSection['NAME']}, SORT: {$arSection['SORT']}\n";
			}
			$APPLICATION->IncludeComponent(
				"bitrix:catalog.section.list",
				"categories", 
				[
					"IBLOCK_TYPE" => "catalog",
					"IBLOCK_ID" =>  $currentCity["IBLOCK_CATALOG"]["VALUE"],
					"FILTER_NAME" => "arSectionFilter",
					"CACHE_TYPE" => "A",
					"CACHE_TIME" => "3600",
					"CACHE_GROUPS" => "Y",
					"COUNT_ELEMENTS" => "Y",
					"TOP_DEPTH" => 1,                  
					"SECTION_URL" => "/catalog/#SECTION_CODE_PATH#/",
					"VIEW_MODE" => "LIST",
					"SHOW_PARENT_NAME" => "N",
					"HIDE_SECTION_NAME" => "N",
					"ADD_SECTIONS_CHAIN" => "N",
				],
				false
			);?>
		</div>
	</div>
</section>
<!--Popular section end-->

<!--Promo section start-->
<section class="section section-promo">
	<div class="container">
		<h2 class="section-title">Акции</h2>
	</div>
	<div class="section-content">
		<div class="container resizeble-container">
			<?$APPLICATION->IncludeComponent(
				"bitrix:news.list",
				"banner",
				Array(
					"ACTIVE_DATE_FORMAT" => "d.m.Y",
					"ADD_SECTIONS_CHAIN" => "N",
					"AJAX_MODE" => "N",
					"AJAX_OPTION_ADDITIONAL" => "",
					"AJAX_OPTION_HISTORY" => "N",
					"AJAX_OPTION_JUMP" => "N",
					"AJAX_OPTION_STYLE" => "N",
					"CACHE_FILTER" => "N",
					"CACHE_GROUPS" => "Y",
					"CACHE_TIME" => "36000000",
					"CACHE_TYPE" => "A",
					"CHECK_DATES" => "Y",
					"COMPONENT_TEMPLATE" => "slider",
					"COMPOSITE_FRAME_MODE" => "A",
					"COMPOSITE_FRAME_TYPE" => "AUTO",
					"DETAIL_URL" => "",
					"DISPLAY_BOTTOM_PAGER" => "Y",
					"DISPLAY_DATE" => "N",
					"DISPLAY_NAME" => "Y",
					"DISPLAY_PICTURE" => "Y",
					"DISPLAY_PREVIEW_TEXT" => "Y",
					"DISPLAY_TOP_PAGER" => "N",
					"FIELD_CODE" => array(0=>"",1=>"",),
					"FILTER_NAME" => "",
					"HIDE_LINK_WHEN_NO_DETAIL" => "N",
					"IBLOCK_ID" => $currentCity["IBLOCK_ACTIONS"]["VALUE"],
					"IBLOCK_TYPE" => "news",
					"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
					"INCLUDE_SUBSECTIONS" => "N",
					"MESSAGE_404" => "",
					"NEWS_COUNT" => "4",
					"PAGER_BASE_LINK_ENABLE" => "N",
					"PAGER_DESC_NUMBERING" => "N",
					"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
					"PAGER_SHOW_ALL" => "N",
					"PAGER_SHOW_ALWAYS" => "N",
					"PAGER_TEMPLATE" => ".default",
					"PAGER_TITLE" => "Новости",
					"PARENT_SECTION" => "",
					"PARENT_SECTION_CODE" => "",
					"PREVIEW_TRUNCATE_LEN" => "",
					"PROPERTY_CODE" => array(0=>"",1=>"LINK",2=>"ZP",3=>"",),
					"SET_BROWSER_TITLE" => "N",
					"SET_LAST_MODIFIED" => "N",
					"SET_META_DESCRIPTION" => "N",
					"SET_META_KEYWORDS" => "N",
					"SET_STATUS_404" => "N",
					"SET_TITLE" => "N",
					"SHOW_404" => "N",
					"SORT_BY1" => "ACTIVE_FROM",
					"SORT_BY2" => "SORT",
					"SORT_ORDER1" => "DESC",
					"SORT_ORDER2" => "ASC",
					"STRICT_SECTION_CHECK" => "N",
					"SLIDER_ID"=> "promo-banner"
				)
			);?>
		</div>
	</div>
</section>
<!--Promo section end-->

<!--For resident section start-->
<section class="section section-for-resident">
	<div class="container">
		<h1 class="section-title">Сезонные товары</h1>

		<div class="section-content section-content--grid">
			<?$APPLICATION->IncludeComponent(
				"znak:catalog.products",
				".default",
				[
					"IBLOCK_ID" => $currentCity['IBLOCK_CATALOG']['VALUE'],
					"ELEMENTS_COUNT" => 4,
					"TITLE" => "Хит продаж",
					"SORT_BY" => "RAND",
					"SORT_ORDER" => "DESC",
					"FILTER" => [
						"SECTION_ID" => "17906",
						"INCLUDE_SUBSECTIONS" => "Y",
					],
				],
				false
			);?>
		</div>
	</div>
</section>
<!--For resident section end-->

<!--Advice section start-->
<section class="section section-advice">
	<div class="container">
		<h1 class="section-title">Совет от компании знак</h1>
	</div>
		<div class="section-content">
		<div class="container">
			<?$APPLICATION->IncludeComponent(
			"bitrix:news.list",
			"advices",
			Array(
				"ACTIVE_DATE_FORMAT" => "d.m.Y",
				"ADD_SECTIONS_CHAIN" => "N",
				"AJAX_MODE" => "N",
				"AJAX_OPTION_ADDITIONAL" => "",
				"AJAX_OPTION_HISTORY" => "N",
				"AJAX_OPTION_JUMP" => "N",
				"AJAX_OPTION_STYLE" => "N",
				"CACHE_FILTER" => "N",
				"CACHE_GROUPS" => "N",
				"CACHE_TIME" => "36000000",
				"CACHE_TYPE" => "A",
				"CHECK_DATES" => "Y",
				"COMPONENT_TEMPLATE" => ".default",
				"DETAIL_URL" => "",
				"DISPLAY_BOTTOM_PAGER" => "N",
				"DISPLAY_DATE" => "N",
				"DISPLAY_NAME" => "Y",
				"DISPLAY_PICTURE" => "Y",
				"DISPLAY_PREVIEW_TEXT" => "Y",
				"DISPLAY_TOP_PAGER" => "N",
				"FIELD_CODE" => array(0=>"",1=>"",),
				"FILTER_NAME" => "",
				"HIDE_LINK_WHEN_NO_DETAIL" => "N",
				"IBLOCK_ID" => "7",
				"IBLOCK_TYPE" => "news",
				"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
				"INCLUDE_SUBSECTIONS" => "N",
				"MESSAGE_404" => "",
				"NEWS_COUNT" => "5",
				"PAGER_BASE_LINK_ENABLE" => "N",
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "N",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_TEMPLATE" => ".default",
				"PAGER_TITLE" => "Новости",
				"PARENT_SECTION" => "",
				"PARENT_SECTION_CODE" => "",
				"PREVIEW_TRUNCATE_LEN" => "",
				"PROPERTY_CODE" => array(0=>"",1=>"",),
				"SET_BROWSER_TITLE" => "N",
				"SET_LAST_MODIFIED" => "N",
				"SET_META_DESCRIPTION" => "N",
				"SET_META_KEYWORDS" => "N",
				"SET_STATUS_404" => "N",
				"SET_TITLE" => "N",
				"SHOW_404" => "N",
				"SORT_BY1" => "SORT",
				"SORT_BY2" => "SORT",
				"SORT_ORDER1" => "DESC",
				"SORT_ORDER2" => "ASC"
			)
		);?>
		</div>
	</div>
</section>	
<!--Advice section end-->

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>