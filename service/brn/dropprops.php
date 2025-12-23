<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
$IBLOCK_ID = 19;
$properties = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>$IBLOCK_ID));
while ($prop_fields = $properties->GetNext())
{
	echo $prop_fields["ID"]." - ".$prop_fields["NAME"]."<br>";
	CIBlockProperty::Delete($prop_fields["ID"]);
}
?>