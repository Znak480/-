<?require_once($_SERVER['DOCUMENT_ROOT']. "/bitrix/modules/main/include/prolog_before.php");
global $currentCity;


define("IBLOCK_PRODUCTS_ID",$currentCity['IBLOCK_CATALOG']['VALUE']);
//debug($_GET);
//debug($currentCity['IBLOCK_CATALOG']['VALUE']);

if(!CModule::IncludeModule("iblock"))
$res= CIBlockElement::GetByID($_GET["id"]);
$el = $res->GetNext();

$APPLICATION->IncludeComponent("bitrix:catalog.compare.list",
    "ajax_count",
    Array(
        "AJAX_MODE" => "N",
        "IBLOCK_ID" => $currentCity['IBLOCK_CATALOG']['VALUE'],
        "DETAIL_URL" => "#SECTION_CODE#",
        "COMPARE_URL" => "/compare/",
        "NAME" => "CATALOG_COMPARE_LIST",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "ACTION_VARIABLE" => "action",
        "AJAX_OPTION_HISTORY" => "N",
        "PRODUCT_ID" =>$_GET['id'],
        "IBLOCK_TYPE" => "catalog"
	)
);