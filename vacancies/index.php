<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Вакансии | Торговый центр «Знак» – товары для ремонта и строительства");
$APPLICATION->SetPageProperty("keywords", "Вакансии, торговый, центр, знак, товар, ремонт, строительство, отделочный, строительный, материал");
$APPLICATION->SetPageProperty("description", "Вакансии торгового центра «Знак». Отделочные и строительные материалы, а также инструменты, текстиль, предметы интерьера, хозтовары, товары для дома.");
$APPLICATION->SetTitle("Вакансии");
DevIncludeFile('index');
?>
<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>