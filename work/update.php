<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("");
CModule::IncludeModule("iblock");
ini_set ("max_execution_time" , "600");

/*

$arFilter = array('IBLOCK_ID' => 2);
$res = CIBlockSection::GetList(array(), $arFilter);
while($arSect = $res->GetNext())
{
			//var_dump($arSect);
  $el = new CIBlockSection;
  $arLoadProductArray = Array(
	"CODE" => translit2($arSect["CODE"])
  );
  $res1 = $el->Update($arSect["ID"], $arLoadProductArray);
 
 }
*/ 
$arParams = array("replace_space"=>"-","replace_other"=>"-");
$arSelect = Array("ID", "IBLOCK_ID", "CODE");//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
$arFilter = Array("IBLOCK_ID"=>2);
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
while($ob = $res->GetNextElement()){ 
		
		$arFields = $ob->GetFields();  
		
		$el = new CIBlockElement;
		$arLoadProductArray = Array(
		 "CODE" =>  translit2($arFields["CODE"])
		  );

		
		$res1 = $el->Update($arFields["ID"], $arLoadProductArray);	
}
?>