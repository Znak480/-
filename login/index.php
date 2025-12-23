<?
define("NEED_AUTH", true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Авторизация | Торговый центр «Знак» – товары для ремонта и строительства");
$APPLICATION->SetPageProperty("keywords", "Авторизация, торговый, центр, знак, товар, ремонт, строительство, отделочный, строительный, материал");
$APPLICATION->SetPageProperty("description", "Авторизация. Торговый центр «Знак». Отделочные и строительные материалы, а также инструменты, текстиль, предметы интерьера, хозтовары, товары для дома.");

if (isset($_REQUEST["backurl"]) && strlen($_REQUEST["backurl"])>0) 
	LocalRedirect($backurl);

$APPLICATION->SetTitle("Вход на сайт");
?><p class="notetext">
	 Вы зарегистрированы и успешно авторизовались.
</p>
<p>
 <a href="/">Вернуться на главную страницу</a>&nbsp;
</p>
 <br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>