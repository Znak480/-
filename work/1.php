<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("");
CModule::IncludeModule("iblock");
ini_set ("max_execution_time" , "600");
phpinfo();
?><?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section.list",
	"tree",
	Array(
		"COMPONENT_TEMPLATE" => "tree",
		"IBLOCK_TYPE" => "catalog",
		"IBLOCK_ID" => "2",
		"SECTION_ID" => $_REQUEST["SECTION_ID"],
		"SECTION_CODE" => "",
		"COUNT_ELEMENTS" => "N",
		"TOP_DEPTH" => "4",
		"SECTION_FIELDS" => array("ID","CODE","XML_ID","NAME","SORT","DESCRIPTION","PICTURE","DETAIL_PICTURE","IBLOCK_TYPE_ID","IBLOCK_ID","IBLOCK_CODE","IBLOCK_EXTERNAL_ID","DATE_CREATE","CREATED_BY","TIMESTAMP_X","MODIFIED_BY",""),
		"SECTION_USER_FIELDS" => array("",""),
		"VIEW_MODE" => "LINE",
		"SHOW_PARENT_NAME" => "Y",
		"SECTION_URL" => "",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_GROUPS" => "Y",
		"ADD_SECTIONS_CHAIN" => "N"
	)
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>