<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "О компании | Торговый центр «Знак» – товары для ремонта и строительства");
$APPLICATION->SetPageProperty("keywords", "торговый, центр, знак, товар, ремонт, строительство, отделочный, строительный, материал");
$APPLICATION->SetPageProperty("description", "О компании. Торговый центр «Знак». Отделочные и строительные материалы, а также инструменты, текстиль, предметы интерьера, хозтовары, товары для дома.");
$APPLICATION->SetTitle("О компании");
DevIncludeFile('index');
?>
<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>