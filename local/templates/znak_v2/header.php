<?php 
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die(); 

use Bitrix\Main\Page\Asset;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

Asset::getInstance()->addCss("https://cdn.jsdelivr.net/npm/remixicon@4.6.0/fonts/remixicon.css");
Asset::getInstance()->addCss("https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css");
Asset::getInstance()->addCss('https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css');

Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/assets/css/variables.css");
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/assets/css/normalize.css");
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/assets/css/global.css");
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/assets/css/utilities.css");
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/assets/css/index.css");
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/assets/css/product-card.css");
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/assets/css/main.css");
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/assets/css/account.css");
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/assets/css/product-item.css");
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/assets/css/cart.css");

Asset::getInstance()->addJs("https://code.jquery.com/jquery-3.7.1.min.js");
Asset::getInstance()->addJs("https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js");
Asset::getInstance()->addJs('https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js');
?>

<!DOCTYPE html>
<html lang="<?= LANGUAGE_ID ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php $APPLICATION->ShowTitle() ?></title>

     <?php $APPLICATION->ShowHead(); ?>

    <?php 
    //Предварительная загрузка popup для исправления ошибок с вызовом методов библиотеки
    if (CModule::IncludeModule('main')) CJSCore::Init(array("popup")); 
    ?>

    <!-- Yandex.Metrika counter -->
	<script type="text/javascript">
        (function (m, e, t, r, i, k, a) {
            m[i] = m[i] || function () {
                (m[i].a = m[i].a || []).push(arguments)
            };
            m[i].l = 1 * new Date();
            k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a)
        })
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(86354987, "init", {
            clickmap: true,
            trackLinks: true,
            accurateTrackBounce: true,
            webvisor: true,
            trackHash: true
        });
	</script>
	<noscript>
		<div>
			<img src="https://mc.yandex.ru/watch/269955" style="position:absolute; left:-9999px;" alt=""/>
		</div>
	</noscript>
	<!-- /Yandex.Metrika counter -->

    <!-- Top.Mail.Ru counter -->
    <script type="text/javascript">
        var _tmr = window._tmr || (window._tmr = []);
        _tmr.push({id: "3293216", type: "pageView", start: (new Date()).getTime()});
        (function (d, w, id) {
            if (d.getElementById(id)) return;
            var ts = d.createElement("script");
            ts.type = "text/javascript";
            ts.async = true;
            ts.id = id;
            ts.src = "https://top-fwz1.mail.ru/js/code.js";
            var f = function () {
                var s = d.getElementsByTagName("script")[0];
                s.parentNode.insertBefore(ts, s);
            };
            if (w.opera == "[object Opera]") {
                d.addEventListener("DOMContentLoaded", f, false);
            } else {
                f();
            }
        })(document, window, "tmr-code");
    </script>
    <noscript>
        <div>
            <img src="https://top-fwz1.mail.ru/counter?id=3293216;js=na" style="position:absolute;left:-9999px;" alt="Top.Mail.Ru"/>
        </div>
    </noscript>
    <!-- /Top.Mail.Ru counter -->
     
</head>
<body>
    <?$APPLICATION -> ShowPanel(); ?>
    <div class="app">

        <!-- Header start -->
        <header class="header">
            <div class="header-mobile">
                <div class="container">
                    <div class="header-wrapper">
                        <div class="header-top">
                            <?php 
                            $APPLICATION->IncludeComponent(
                                "bitrix:main.include",
                                "",
                                [
                                    "AREA_FILE_SHOW" => "file",
                                    "PATH" => SITE_TEMPLATE_PATH . "/include/header_logo.php",
                                    "CACHE_TYPE" => "A",
                                    "CACHE_TIME" => "86400",
                                ]
                            )
                            ?>

                            <!-- Region selector start -->
                            <?
                            $APPLICATION->IncludeComponent(
                            "znak:regions",
                            "",
                            [
                                "COMPONENT_TEMPLATE"=> ".default",
                                "IBLOCK_ID"=> 18,
                                "TITLE_HIDDEN"=>"N"
                            ],
                            false); 
                            ?>
                            <!-- Region selector end -->
                        </div>

                        <div class="header-bottom">
                            <button class="btn btn-primary btn-burger btn-burger-with-text" aria-label="Меню" data-menu="mobile-sidebar">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                    <path d="M0 0h24v24H0z" fill="none" />
                                    <path fill="currentColor" d="M3 18v-2h18v2zm0-5v-2h18v2zm0-5V6h18v2z" />
                                </svg>
                            </button>

                            <?php
                            $APPLICATION->IncludeComponent(
                                "bitrix:search.title",
                                "header_search",
                                [
                                    "COMPONENT_TEMPLATE"        => ".default",
                                    "NUM_CATEGORIES"            => "1",
                                    "TOP_COUNT"                 => "10",
                                    "ORDER"                     => "rank",
                                    "USE_LANGUAGE_GUESS"        => "Y",
                                    "CHECK_DATES"               => "N",
                                    "SHOW_OTHERS"               => "N",
                                    "PAGE"                      => "/catalog/",
                                    "SHOW_INPUT"                => "Y",
                                    "INPUT_ID"                  => "title-search-input1",
                                    "CONTAINER_ID"              => "title-search1",
                                    "CATEGORY_0_TITLE"          => "",
                                    "CATEGORY_0"                => [
                                        0 => "iblock_catalog",
                                    ],
                                    "CATEGORY_0_iblock_catalog" => [
                                        0 => "19",
                                    ],
                                ],
                                false
                            );
                            ?>
                        </div>
                    </div>
                </div>
            </div>
             <div class="header-desktop">
                <div class="header-top">
                    <div class="container">
                        <div class="header-top-wrapper">
                            <!-- Region selector start -->
                            <?
                            $APPLICATION->IncludeComponent(
                                "znak:regions",
                                "",
                                [
                                    "COMPONENT_TEMPLATE"=> ".default",
                                    "IBLOCK_ID"=>18,
                                    "TITLE_HIDDEN"=>"Y"
                                ],
                                false
                            ); 
                            ?>
                            <!-- Region selector end -->

                            <?php
                            $APPLICATION->IncludeComponent(
                                "bitrix:menu",
                                "top_menu",
                                [
                                    "ROOT_MENU_TYPE" => "top",
                                    "MAX_LEVEL" => "1",
                                    "CACHE_TYPE" => "A",
                                    "CACHE_TIME" => "86400",
                                ]
                            );
                            ?>

                            <div aria-hidden="true"></div>
                        </div>
                    </div>
                </div>
                <div class="header-bottom">
                    <div class="container">
                        <div class="header-bottom-wrapper">
                            <?php 
                            $APPLICATION->IncludeComponent(
                                "bitrix:main.include",
                                "",
                                [
                                    "AREA_FILE_SHOW" => "file",
                                    "PATH" => SITE_TEMPLATE_PATH . "/include/header_logo.php",
                                    "CACHE_TYPE" => "A",
                                    "CACHE_TIME" => "86400",
                                ]
                            )
                            ?>

                            <div class="header-center">
                                <button class="btn btn-primary btn-burger btn-burger-with-text" aria-label="Каталог" data-menu="catalog">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                        <path d="M0 0h24v24H0z" fill="none" />
                                        <path fill="currentColor" d="M3 18v-2h18v2zm0-5v-2h18v2zm0-5V6h18v2z" />
                                    </svg>
                                    <span>Каталог</span>
                                </button>
                                <?php
                                $APPLICATION->IncludeComponent(
                                    "bitrix:search.title",
                                    "header_search",
                                    [
                                        "COMPONENT_TEMPLATE"        => ".default",
                                        "NUM_CATEGORIES"            => "1",
                                        "TOP_COUNT"                 => "10",
                                        "ORDER"                     => "rank",
                                        "USE_LANGUAGE_GUESS"        => "Y",
                                        "CHECK_DATES"               => "N",
                                        "SHOW_OTHERS"               => "N",
                                        "PAGE"                      => "/catalog/",
                                        "SHOW_INPUT"                => "Y",
                                        "INPUT_ID"                  => "title-search-input3",
                                        "CONTAINER_ID"              => "title-search3",
                                        "CATEGORY_0_TITLE"          => "",
                                        "CATEGORY_0"                => [
                                            0 => "iblock_catalog",
                                        ],
                                        "CATEGORY_0_iblock_catalog" => [
                                            0 => "19",
                                        ],
                                    ],
                                    false
                                );
                                ?>
                            </div>

                            <? include($_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . '/include/header_actions.php'); ?>
                        </div>
                    </div>
                </div>
             </div>
             <div class="header-fixed" aria-disabled="true">
                <div class="container">
                    <div class="header-wrapper">
                        <?php 
                            $APPLICATION->IncludeComponent(
                                "bitrix:main.include",
                                "",
                                [
                                    "AREA_FILE_SHOW" => "file",
                                    "PATH" => SITE_TEMPLATE_PATH . "/include/header_logo.php",
                                    "CACHE_TYPE" => "A",
                                    "CACHE_TIME" => "86400",
                                ]
                            );
                        ?>

                        <div class="header-center">
                            <button class="btn btn-primary btn-burger" aria-label="Меню" data-menu="toggle-action">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                    <path d="M0 0h24v24H0z" fill="none" />
                                    <path fill="currentColor" d="M3 18v-2h18v2zm0-5v-2h18v2zm0-5V6h18v2z" />
                                </svg>
                            </button>

                            <?php
                            $APPLICATION->IncludeComponent(
                                "bitrix:search.title",
                                "header_search",
                                [
                                    "COMPONENT_TEMPLATE"        => ".default",
                                    "NUM_CATEGORIES"            => "1",
                                    "TOP_COUNT"                 => "10",
                                    "ORDER"                     => "rank",
                                    "USE_LANGUAGE_GUESS"        => "Y",
                                    "CHECK_DATES"               => "N",
                                    "SHOW_OTHERS"               => "N",
                                    "PAGE"                      => "/catalog/",
                                    "SHOW_INPUT"                => "Y",
                                    "INPUT_ID"                  => "title-search-input2",
                                    "CONTAINER_ID"              => "title-search2",
                                    "CATEGORY_0_TITLE"          => "",
                                    "CATEGORY_0"                => [
                                        0 => "iblock_catalog",
                                    ],
                                    "CATEGORY_0_iblock_catalog" => [
                                        0 => "19",
                                    ],
                                ],
                                false
                            );
                            ?>
                        </div>

                        <!-- Region selector start -->
                        <?
                        $APPLICATION->IncludeComponent(
                            "znak:regions",
                            "",
                            [
                                "COMPONENT_TEMPLATE"=> ".default",
                                "IBLOCK_ID"=>18,
                                "TITLE_HIDDEN"=>"N"
                            ],
                            false
                        ); 
                        ?>
                        <!-- Region selector end -->

                        <? include($_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . '/include/header_actions.php'); ?>
                    </div>
                </div>
            </div>
        </header>
        <!-- Header end -->

        <!-- Content start -->
        <main class="content">
