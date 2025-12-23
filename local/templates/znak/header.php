<?
if (isset($_SERVER['REQUEST_URI']) && preg_match('#^/index(/?|\.php.*)?$#', $_SERVER['REQUEST_URI'])) {
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: /");
    exit();
}

use Bitrix\Main\Page\Asset;
global $APPLICATION;
global $USER;
global $currentCity;
?>

<!DOCTYPE html>

<html>
<head>
<meta name="yandex-verification" content="183a1b83dfce47eb" />
	<?$APPLICATION->ShowHead()?>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<title><?$APPLICATION->ShowTitle()?></title>

    <?
    Asset::getInstance()->addCss("/css/common.css");
    Asset::getInstance()->addCss("/css/slick.css");
    Asset::getInstance()->addCss("/css/ion.rangeSlider.min.css");
    Asset::getInstance()->addCss("/css/nice-select.css");
    Asset::getInstance()->addCss("/css/lets.css",true);
    Asset::getInstance()->addCss("/fancybox/jquery.fancybox.css");
    Asset::getInstance()->addCss("/css/custom.css");

    ?>
<!--	<link rel="stylesheet" href="/css/common.css">-->
<!--	<link rel="stylesheet" href="/css/slick.css">-->
<!--    <link rel="stylesheet" href="/css/ion.rangeSlider.min.css">-->
<!--    <link rel="stylesheet" href="/css/nice-select.css">-->
<!--	<link rel="stylesheet" href="/css/lets.css">-->
<!--    <link rel="stylesheet" href="/fancybox/jquery.fancybox.css">-->
	<?php
	    $mobiles = array("iPhone","iPad","iPod","Android","webOS","BlackBerry","IEMobile","PlayBook","BB10","Nokia");
	    global $desktop;
	    $desktop = true;
	    foreach( $mobiles as $mobile ) {
	        if( preg_match( "#".$mobile."#i", $_SERVER['HTTP_USER_AGENT'] ) ) {

	            //echo '<link rel="stylesheet" href="/css/adaptive_.css">';
                Asset::getInstance()->addCss("/css/adaptive_.css",true);
	            $desktop = false;
               // var_dump($desktop);
	        }
	    }

	    if ($desktop == true) {
//	    	echo '<link rel="stylesheet" href="/css/adaptive_.css">';
            Asset::getInstance()->addCss("/css/small-desktop.css",true);
            //echo '<link rel="stylesheet" href="/css/small-desktop.css">';
	    }
	?>

	<link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,800&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Roboto:500&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
<!--	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>-->

	<script src="/js/jquery.jcarousel.min.js"></script>
	<script src="/js/slick.js"></script>
	<script src="/fancybox/jquery.fancybox.js"></script>
    <script src="/js/ion.rangeSlider.min.js"></script>
    <script src="/js/jquery.nice-select.min.js"></script>

<!--	<script src="/js/script.js"></script>-->
    <?

    Asset::getInstance()->addJs('https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js');
    Asset::getInstance()->addJs('/js/script.js');
    ?>

	<script src="/js/jquery.mask.js"></script>
	<script src="/js/ajax.js"></script>
	<!--[if (IE 6) | (IE 7) | (IE 8)]>
		<link rel="stylesheet" href="/css/ie8.css">
	<![endif]-->

    <?/* if (!$USER->IsAdmin()) { ?>
        <!-- Google Tag Manager -->
        <script>(function (w, d, s, l, i) {
                w[l] = w[l] || [];
                w[l].push({
                    'gtm.start': new Date().getTime(), event: 'gtm.js'
                });
                var f = d.getElementsByTagName(s)[0],
                    j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
                j.async = true;
                j.src =
                    'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
                f.parentNode.insertBefore(j, f);
            })(window, document, 'script', 'dataLayer', 'GTM-NS8VP8J');</script>
        <!-- End Google Tag Manager -->

        <!-- Google Tag Manager (noscript) -->
        <noscript>
            <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NS8VP8J"
                    height="0" width="0" style="display:none;visibility:hidden"></iframe>
        </noscript>
        <!-- End Google Tag Manager (noscript) -->

       <!-- Yandex.Metrika counter -->
<script type="text/javascript" >
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

   ym(8635487, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true,
        trackHash:true
   });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/86354987" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

    <? }*/ ?>
<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

   ym(86354987, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true,
        trackHash:true
   });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/269955" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
</head>

<body>
<!-- Top.Mail.Ru counter -->
<script type="text/javascript">
var _tmr = window._tmr || (window._tmr = []);
_tmr.push({id: "3293216", type: "pageView", start: (new Date()).getTime()});
(function (d, w, id) {
  if (d.getElementById(id)) return;
  var ts = d.createElement("script"); ts.type = "text/javascript"; ts.async = true; ts.id = id;
  ts.src = "https://top-fwz1.mail.ru/js/code.js";
  var f = function () {var s = d.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ts, s);};
  if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); }
})(document, window, "tmr-code");
</script>
<noscript><div><img src="https://top-fwz1.mail.ru/counter?id=3293216;js=na" style="position:absolute;left:-9999px;" alt="Top.Mail.Ru" /></div></noscript>
<!-- /Top.Mail.Ru counter -->

	<?$APPLICATION->ShowPanel();?>
<!-- Главная -->
	<div class="top-menu">
		 <?$APPLICATION->IncludeComponent("bitrix:menu", "top_menu", Array(
	"COMPONENT_TEMPLATE" => ".default",
		"ROOT_MENU_TYPE" => "top",	// Тип меню для первого уровня
		"MENU_CACHE_TYPE" => "N",	// Тип кеширования
		"MENU_CACHE_TIME" => "3600",	// Время кеширования (сек.)
		"MENU_CACHE_USE_GROUPS" => "N",	// Учитывать права доступа
		"MENU_CACHE_GET_VARS" => array(	// Значимые переменные запроса
			0 => "",
		),
		"MAX_LEVEL" => "1",	// Уровень вложенности меню
		"CHILD_MENU_TYPE" => "left",	// Тип меню для остальных уровней
		"USE_EXT" => "N",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
		"DELAY" => "N",	// Откладывать выполнение шаблона меню
		"ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
	),
	false
);?>
	<div class="top-menu__user">

        <? if (!$USER->IsAuthorized()) { ?>
            <a href="/login/">Вход</a>
        <? } else { ?>
            <a href="/personal/">Кабинет</a>
<!-- ?=$APPLICATION->GetCurPageParam("logout=yes", array("login", "logout", "register", "forgot_password", "change_password"));?--> 
        <? } ?>
        / <a href="/login/?register=yes">Регистрация</a>
	</div>
	</div>

  <!-- старый хэдер -->
<?/*	<div class="header regular-block">
		<!-- <a href="/catalog/" class="cat-link-header">Каталог товаров</a> -->
		<div class="logo-box">
			<a href="/"><img src="/i/logo.gif" alt="" class="logo"></a>
			<div class="title">Для тех, кто строит и ремонтирует</div>
		</div>


<?$APPLICATION->IncludeComponent("bitrix:news.list", "cities-list", Array(
		"IBLOCK_TYPE" => "news",	// Тип информационного блока (используется только для проверки)
		"IBLOCK_ID" => "18",	// Код информационного блока
		"NEWS_COUNT" => "1000",	// Количество новостей на странице
		"SORT_BY1" => "SORT",	// Поле для первой сортировки новостей
		"SORT_ORDER1" => "ASC",	// Направление для первой сортировки новостей
		"SORT_BY2" => "SORT",	// Поле для второй сортировки новостей
		"SORT_ORDER2" => "ASC",	// Направление для второй сортировки новостей
		"FILTER_NAME" => "",	// Фильтр
		"FIELD_CODE" => array(	// Поля
			0 => "",
			1 => "",
		),
		"PROPERTY_CODE" => array(	// Свойства
			0 => "ADDRESS",
			1 => "PHONE",
			2 => "PHONE_HREF",
			3 => "WORKTIME",
			4 => "DOMAIN"
		),
		"CHECK_DATES" => "Y",	// Показывать только активные на данный момент элементы
		"DETAIL_URL" => "",	// URL страницы детального просмотра (по умолчанию - из настроек инфоблока)
		"AJAX_MODE" => "N",	// Включить режим AJAX
		"AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
		"AJAX_OPTION_STYLE" => "N",	// Включить подгрузку стилей
		"AJAX_OPTION_HISTORY" => "N",	// Включить эмуляцию навигации браузера
		"AJAX_OPTION_ADDITIONAL" => "",	// Дополнительный идентификатор
		"CACHE_TYPE" => "A",	// Тип кеширования
		"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
		"CACHE_FILTER" => "N",	// Кешировать при установленном фильтре
		"CACHE_GROUPS" => "Y",	// Учитывать права доступа
		"PREVIEW_TRUNCATE_LEN" => "",	// Максимальная длина анонса для вывода (только для типа текст)
		"ACTIVE_DATE_FORMAT" => "d.m.Y",	// Формат показа даты
		"SET_TITLE" => "N",	// Устанавливать заголовок страницы
		"SET_BROWSER_TITLE" => "N",	// Устанавливать заголовок окна браузера
		"SET_META_KEYWORDS" => "N",	// Устанавливать ключевые слова страницы
		"SET_META_DESCRIPTION" => "N",	// Устанавливать описание страницы
		"SET_LAST_MODIFIED" => "N",	// Устанавливать в заголовках ответа время модификации страницы
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",	// Включать инфоблок в цепочку навигации
		"ADD_SECTIONS_CHAIN" => "N",	// Включать раздел в цепочку навигации
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",	// Скрывать ссылку, если нет детального описания
		"PARENT_SECTION" => "",	// ID раздела
		"PARENT_SECTION_CODE" => "",	// Код раздела
		"INCLUDE_SUBSECTIONS" => "N",	// Показывать элементы подразделов раздела
		"DISPLAY_DATE" => "N",	// Выводить дату элемента
		"DISPLAY_NAME" => "Y",	// Выводить название элемента
		"DISPLAY_PICTURE" => "Y",	// Выводить изображение для анонса
		"DISPLAY_PREVIEW_TEXT" => "Y",	// Выводить текст анонса
		"PAGER_TEMPLATE" => ".default",	// Шаблон постраничной навигации
		"DISPLAY_TOP_PAGER" => "N",	// Выводить над списком
		"DISPLAY_BOTTOM_PAGER" => "Y",	// Выводить под списком
		"PAGER_TITLE" => "Новости",	// Название категорий
		"PAGER_SHOW_ALWAYS" => "N",	// Выводить всегда
		"PAGER_DESC_NUMBERING" => "N",	// Использовать обратную навигацию
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",	// Время кеширования страниц для обратной навигации
		"PAGER_SHOW_ALL" => "N",	// Показывать ссылку "Все"
		"PAGER_BASE_LINK_ENABLE" => "N",	// Включить обработку ссылок
		"SET_STATUS_404" => "N",	// Устанавливать статус 404
		"SHOW_404" => "N",	// Показ специальной страницы
		"MESSAGE_404" => "",	// Сообщение для показа (по умолчанию из компонента)
	),
	false
);?>


		<div class="consultation">Заказать звонок</div>
		<div class="search">
		<?$APPLICATION->IncludeComponent(
	"bitrix:search.title", 
	".default", 
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"NUM_CATEGORIES" => "1",
		"TOP_COUNT" => "10",
		"ORDER" => "rank",
		"USE_LANGUAGE_GUESS" => "Y",
		"CHECK_DATES" => "N",
		"SHOW_OTHERS" => "N",
		"PAGE" => "#SITE_DIR#search/index.php",
		"SHOW_INPUT" => "Y",
		"INPUT_ID" => "title-search-input",
		"CONTAINER_ID" => "title-search",
		"CATEGORY_0_TITLE" => "",
		"CATEGORY_0" => array(
			0 => "iblock_catalog",
		),
		"CATEGORY_0_iblock_catalog" => array(
			0 => "19",
		)
	),
	false
);?>
		</div>
		<a href="/cart/" class="cart" id="cart">
			<?$APPLICATION->IncludeComponent("bitrix:sale.basket.basket.small", "small", Array(
                "COLUMNS_LIST" => array("PRICE_FORMATED"),
	"COMPONENT_TEMPLATE" => ".default",
		"PATH_TO_BASKET" => "/cart/",	// Страница корзины
		"PATH_TO_ORDER" => "",	// Страница оформления заказа
		"SHOW_DELAY" => "Y",	// Показывать отложенные товары
		"SHOW_NOTAVAIL" => "Y",	// Показывать товары, недоступные для покупки
		"SHOW_SUBSCRIBE" => "Y",	// Показывать товары, на которые подписан покупатель
		"SHOW_PRICE" => "Y",	// Показывать товары, на которые подписан покупатель
	),
	false
);?>
		</a>
	</div> */?>
  <!-- старый хэдер -->

    <!-- HEADER NEW  -->

    <div class="header regular-block header_e1">

<div class="header_e1__wrapper">
  <div class="logo-box">
    <a href="/"><img src="/i/logo.gif" alt="" class="logo"></a>
    <div class="title">Для тех, кто строит и ремонтирует</div>
  </div>
  <div class="header_e1__search-wrapper">
    <div class="header_e1__contacts">
      <?$APPLICATION->IncludeComponent("bitrix:news.list", "cities-list", Array(
        "IBLOCK_TYPE" => "news",	// Тип информационного блока (используется только для проверки)
        "IBLOCK_ID" => "18",	// Код информационного блока
        "NEWS_COUNT" => "1000",	// Количество новостей на странице
        "SORT_BY1" => "SORT",	// Поле для первой сортировки новостей
        "SORT_ORDER1" => "ASC",	// Направление для первой сортировки новостей
        "SORT_BY2" => "SORT",	// Поле для второй сортировки новостей
        "SORT_ORDER2" => "ASC",	// Направление для второй сортировки новостей
        "FILTER_NAME" => "",	// Фильтр
        "FIELD_CODE" => array(	// Поля
          0 => "",
          1 => "",
        ),
        "PROPERTY_CODE" => array(	// Свойства
          0 => "ADDRESS",
          1 => "PHONE",
          2 => "PHONE_HREF",
          3 => "WORKTIME",
          4 => "DOMAIN"
        ),
        "CHECK_DATES" => "Y",	// Показывать только активные на данный момент элементы
        "DETAIL_URL" => "",	// URL страницы детального просмотра (по умолчанию - из настроек инфоблока)
        "AJAX_MODE" => "N",	// Включить режим AJAX
        "AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
        "AJAX_OPTION_STYLE" => "N",	// Включить подгрузку стилей
        "AJAX_OPTION_HISTORY" => "N",	// Включить эмуляцию навигации браузера
        "AJAX_OPTION_ADDITIONAL" => "",	// Дополнительный идентификатор
        "CACHE_TYPE" => "A",	// Тип кеширования
        "CACHE_TIME" => "36000000",	// Время кеширования (сек.)
        "CACHE_FILTER" => "N",	// Кешировать при установленном фильтре
        "CACHE_GROUPS" => "Y",	// Учитывать права доступа
        "PREVIEW_TRUNCATE_LEN" => "",	// Максимальная длина анонса для вывода (только для типа текст)
        "ACTIVE_DATE_FORMAT" => "d.m.Y",	// Формат показа даты
        "SET_TITLE" => "N",	// Устанавливать заголовок страницы
        "SET_BROWSER_TITLE" => "N",	// Устанавливать заголовок окна браузера
        "SET_META_KEYWORDS" => "N",	// Устанавливать ключевые слова страницы
        "SET_META_DESCRIPTION" => "N",	// Устанавливать описание страницы
        "SET_LAST_MODIFIED" => "N",	// Устанавливать в заголовках ответа время модификации страницы
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",	// Включать инфоблок в цепочку навигации
        "ADD_SECTIONS_CHAIN" => "N",	// Включать раздел в цепочку навигации
        "HIDE_LINK_WHEN_NO_DETAIL" => "N",	// Скрывать ссылку, если нет детального описания
        "PARENT_SECTION" => "",	// ID раздела
        "PARENT_SECTION_CODE" => "",	// Код раздела
        "INCLUDE_SUBSECTIONS" => "N",	// Показывать элементы подразделов раздела
        "DISPLAY_DATE" => "N",	// Выводить дату элемента
        "DISPLAY_NAME" => "Y",	// Выводить название элемента
        "DISPLAY_PICTURE" => "Y",	// Выводить изображение для анонса
        "DISPLAY_PREVIEW_TEXT" => "Y",	// Выводить текст анонса
        "PAGER_TEMPLATE" => ".default",	// Шаблон постраничной навигации
        "DISPLAY_TOP_PAGER" => "N",	// Выводить над списком
        "DISPLAY_BOTTOM_PAGER" => "Y",	// Выводить под списком
        "PAGER_TITLE" => "Новости",	// Название категорий
        "PAGER_SHOW_ALWAYS" => "N",	// Выводить всегда
        "PAGER_DESC_NUMBERING" => "N",	// Использовать обратную навигацию
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",	// Время кеширования страниц для обратной навигации
        "PAGER_SHOW_ALL" => "N",	// Показывать ссылку "Все"
        "PAGER_BASE_LINK_ENABLE" => "N",	// Включить обработку ссылок
        "SET_STATUS_404" => "N",	// Устанавливать статус 404
        "SHOW_404" => "N",	// Показ специальной страницы
        "MESSAGE_404" => "",	// Сообщение для показа (по умолчанию из компонента)
      ),
      false
    );?>
    <div class="consultation">Заказать звонок</div>
  </div>


<div class="search">
    <?$APPLICATION->IncludeComponent(
  "bitrix:search.title", 
  ".default", 
  array(
    "COMPONENT_TEMPLATE" => ".default",
    "NUM_CATEGORIES" => "1",
    "TOP_COUNT" => "10",
    "ORDER" => "rank",
    "USE_LANGUAGE_GUESS" => "Y",
    "CHECK_DATES" => "N",
    "SHOW_OTHERS" => "N",
    "PAGE" => "#SITE_DIR#search/index.php",
    "SHOW_INPUT" => "Y",
    "INPUT_ID" => "title-search-input",
    "CONTAINER_ID" => "title-search",
    "CATEGORY_0_TITLE" => "",
    "CATEGORY_0" => array(
      0 => "iblock_catalog",
    ),
    "CATEGORY_0_iblock_catalog" => array(
      0 => "19",
    )
  ),
  false
);?>
    </div>
  </div>
<div class="flex-shrink-0">
  <a href="/cart/" class="cart cart_e1" id="cart">
      <?$APPLICATION->IncludeComponent("bitrix:sale.basket.basket.small", "small", Array(
        "COLUMNS_LIST" => array("PRICE_FORMATED"),
        "COMPONENT_TEMPLATE" => ".default",
          "PATH_TO_BASKET" => "/cart/",	// Страница корзины
          "PATH_TO_ORDER" => "",	// Страница оформления заказа
          "SHOW_DELAY" => "Y",	// Показывать отложенные товары
          "SHOW_NOTAVAIL" => "Y",	// Показывать товары, недоступные для покупки
          "SHOW_SUBSCRIBE" => "Y",	// Показывать товары, на которые подписан покупатель
          "SHOW_PRICE" => "Y",	// Показывать товары, на которые подписан покупатель
        ),
        false
      );?>
  </a>
  <div class="consultation consultation_md">Заказать звонок</div>
</div>
  

</div>

</div>

<!-- HEADER NEW  -->

	<div class="header-fix header-fix_e1">

	</div>

	<script type="text/javascript">
			$('.header-fix').append($('.header').clone());

			$(window).on('scroll', function() {
				var s = $(window).scrollTop();

				if (s >= 200) {
					$('.header-fix').addClass('show');
				} else {
					$('.header-fix').removeClass('show');
				}
			});
	</script>


<div class="wrapper"><!-- desktop only -->
	<?$data=explode('/',$_SERVER["REQUEST_URI"]);?>

	<?if ($APPLICATION->GetCurPage(false) === '/' || $data[1]=="catalog"):?>
	<div class="lb">
        <?CModule::IncludeModule("iblock");?>
        <?

        

        $currPage = $APPLICATION->GetCurPage(false);
        $currUrl = explode('/',$currPage,-1);
        //var_dump();
        if(strstr($APPLICATION->GetCurDir(),'/catalog/') and $APPLICATION->GetCurPage(false) !== '/catalog/' and (count($currUrl) ==4 or count($currUrl) ==5)){


            $arSelect = Array("ID", "NAME");
            $arFilter = Array("IBLOCK_ID"=>$currentCity['IBLOCK_CATALOG']['VALUE'], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y","CODE"=>end($currUrl));
            $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nTopCount"=>1), $arSelect);

            if ($res->result->num_rows==0)
                $catalogHide = 'catalog_hide';
        }
        ?>
        <div class="catalog <?=$catalogHide?>" >
            <div class="title"><a href="/catalog/">Каталог продукции</a></div>

            <ul class="parent topCatalog" >
                <? $arFilter = array('IBLOCK_ID' => $currentCity['IBLOCK_CATALOG']['VALUE'], "ACTIVE" =>"Y", "SECTION_ID" => false);
                $rsSect = CIBlockSection::GetList(array("SORT" => "ASC"),$arFilter);
                while ($arSect = $rsSect->GetNext())
                {?>
                    <li class="parent">
                        <a href="#"><?=$arSect["NAME"]?></a>
                        <?$arFilter2 = array('IBLOCK_ID' => $currentCity['IBLOCK_CATALOG']['VALUE'], "ACTIVE" =>"Y", "SECTION_ID" => $arSect["ID"]);
                        $rsSect2 = CIBlockSection::GetList(array("SORT" => "ASC"),$arFilter2);
                        $i=0;
                        while ($arSec2t = $rsSect2->GetNext())
                        {
                            $i++;
                        }?>
                        <?if ($i):?>
                            <div class="sub-catalog">
                                <div class="sub-catalog__head">
                                    <span><?=$arSect["NAME"]?></span>
                                    <button onclick="location.href = '<?=$arSect["SECTION_PAGE_URL"]?>'" class="sub-catalog__btn">Перейти в раздел</button>
                                    <span class="sub-catalog__close">
							<img src="/images/sub-catalog__close.svg" alt="">
						</span>
                                </div>
                                <div class="sub-catalog__main">
                                    <div class="sub-catalog__block">
                                        <?
                                        $j=0;
                                        $arFilter2 = array('IBLOCK_ID' => $currentCity['IBLOCK_CATALOG']['VALUE'], "ACTIVE" =>"Y", "SECTION_ID" => $arSect["ID"]);
                                        $rsSect2 = CIBlockSection::GetList(array("SORT" => "ASC"),$arFilter2);
                                        while ($arSect2 = $rsSect2->GetNext())
                                        {?>

                                        <ul class="child">
                                            <li class="child-title"><a href="<?=$arSect2["SECTION_PAGE_URL"]?>"><?=$arSect2["NAME"]?></a></li>
                                            <?$arFilter3 = array('IBLOCK_ID' => $currentCity['IBLOCK_CATALOG']['VALUE'], "ACTIVE" =>"Y", "SECTION_ID" => $arSect2["ID"]);
                                            $rsSect3 = CIBlockSection::GetList(array("SORT" => "ASC"),$arFilter3);
                                            while ($arSect3 = $rsSect3->GetNext()){
                                                ?>
                                                <li class="child"><a href="<?=$arSect3["SECTION_PAGE_URL"]?>"><?=$arSect3["NAME"]?></a></li>
                                            <?}?>
                                        </ul>
                                        <?


                                        $j++;
                                        if ($j==round($i/3) or $j==round(2*($i/3))){?>
                                    </div>
                                    <div class="sub-catalog__block">
                                        <?}?>
                                        <?}?>
                                    </div>
                                </div>
                            </div>
                        <?endif;?>
                    </li>
                <?}?>
            </ul>
        </div>

	<div id="sidebar">

		<?
        //section_vertical.php
        $APPLICATION->ShowViewContent("filter")?>
	</div>
<?$APPLICATION->IncludeComponent("bitrix:main.include", "", array(
					"AREA_FILE_SHOW" => "file",
					"PATH" => "/include/left_column.php",
					"EDIT_TEMPLATE" => ""
					),
					false
					);?>
	</div>
<?endif;?>
