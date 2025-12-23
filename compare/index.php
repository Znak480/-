<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Таблица сравнения"); 
CModule::IncludeModule("iblock");?>
<?
global $currentCity;
define("IBLOCK_PRODUCTS_ID",$currentCity['IBLOCK_CATALOG']['VALUE']);

?>
<?

//debug($_SESSION["CATALOG_COMPARE_LIST"]);

//debug($currentCity['IBLOCK_CATALOG']['VALUE']);
//debug(IBLOCK_PRODUCTS_ID);


$IBLOCK_ID = $currentCity['IBLOCK_CATALOG']['VALUE'];
//echo $IBLOCK_ID;

$properties = CIBlockProperty::GetList(array("sort" => "asc", "name" => "asc"), array("ACTIVE" => "Y", "IBLOCK_ID" => $IBLOCK_ID));
//$arrProp[] = 'NAME';
//$arrProp[] = 'PREVIEW_PICTURE';
while ($prop_fields = $properties->GetNext()) {
    if(!in_array($prop_fields["CODE"], NO_SHOW_PROP)){
        $arrProp[] = $prop_fields["CODE"];
    }
    //echo $prop_fields["ID"]." - ".$prop_fields["CODE"]." - ".$prop_fields["NAME"]."<br>";

}

//debug($arrProp);
?>

<div class="common-content-full vacancies-page regular-block">
	<div class="title-block-full">
		<div class="path">
 <a href="/">Главная</a> →
		</div>
		<h1 class="big-din">Таблица сравнения</h1>
	</div>
	<div class="content-block-full" style="width:auto;">
		<?$APPLICATION->IncludeComponent("bitrix:catalog.compare.result", "compare", Array(
	"COMPONENT_TEMPLATE" => ".default",
		"NAME" => "CATALOG_COMPARE_LIST",	// Уникальное имя для списка сравнения
		"IBLOCK_TYPE" => "catalog",	// Тип инфоблока
		"IBLOCK_ID" => $IBLOCK_ID,	// Инфоблок
		"FIELD_CODE" => array("code"),	// Поля
		"PROPERTY_CODE" => $arrProp,
		"ELEMENT_SORT_FIELD" => "sort",	// По какому полю сортируем элементы
		"ELEMENT_SORT_ORDER" => "asc",	// Порядок сортировки элементов
		"TEMPLATE_THEME" => "blue",	// Цветовая тема
		"AJAX_MODE" => "N",	// Включить режим AJAX
		"AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
		"AJAX_OPTION_STYLE" => "Y",	// Включить подгрузку стилей
		"AJAX_OPTION_HISTORY" => "N",	// Включить эмуляцию навигации браузера
		"AJAX_OPTION_ADDITIONAL" => "",	// Дополнительный идентификатор
		"DETAIL_URL" => "/catalog/#SECTION_CODE#/#ELEMENT_CODE#/",	// URL, ведущий на страницу с содержимым элемента раздела
		"SECTION_ID_VARIABLE" => "SECTION_ID",	// Название переменной, в которой передается код группы
		"DISPLAY_ELEMENT_SELECT_BOX" => "N",	// Выводить список элементов инфоблока
		"ELEMENT_SORT_FIELD_BOX" => "name",	// По какому полю сортируем список элементов
		"ELEMENT_SORT_ORDER_BOX" => "asc",	// Порядок сортировки списка элементов
		"ELEMENT_SORT_FIELD_BOX2" => "id",	// Поле для второй сортировки списка элементов
		"ELEMENT_SORT_ORDER_BOX2" => "desc",	// Порядок второй сортировки списка элементов
		"HIDE_NOT_AVAILABLE" => "N",	// Не отображать в списке товары, которых нет на складах
		"ACTION_VARIABLE" => "action",	// Название переменной, в которой передается действие
		"PRODUCT_ID_VARIABLE" => "id",	// Название переменной, в которой передается код товара для покупки
		"USE_PRICE_COUNT" => "N",	// Использовать вывод цен с диапазонами
		"SHOW_PRICE_COUNT" => "1",	// Выводить цены для количества
		"PRICE_VAT_INCLUDE" => "Y",	// Включать НДС в цену
		"CONVERT_CURRENCY" => "N",	// Показывать цены в одной валюте
		"BASKET_URL" => "",	// URL, ведущий на страницу с корзиной покупателя
		"OFFERS_FIELD_CODE" => array(	// Поля предложений
			0 => "",
			1 => "",
		),
		"OFFERS_PROPERTY_CODE" => array(	// Свойства предложений
			0 => "",
			1 => "",
		)
	),
	false
);?>
	
	</div>
		<div class="clear">
		</div>

</div>
 <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>