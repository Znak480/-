<?
	//
	define('STOP_STATISTICS', true);
	require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
	CModule::IncludeModule("iblock");
	//
	$arSelect = Array();
	$arFilter = Array("IBLOCK_ID"=>$currentCity['IBLOCK_CATALOG']['VALUE'], "XML_ID"=>$_REQUEST['xml_id']);
	$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>50), Array());
	if($ob = $res->GetNextElement()) {
		$arFields = $ob->GetFields();                             
		Header ("Location: ".$arFields['DETAIL_PAGE_URL']);
	} else {
		Header ("Location: /");
	}
	//                                       http://nsk.znakooo.ru/qr/?xmlid=680c323f-1a98-11e8-bbda-002590187ae2
//74c51ec4-9b67-11eb-9f16-002590187ae2
?>