<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

global $APPLICATION;
/**
 * @global CMain $APPLICATION
 */

$APPLICATION->SetPageProperty("title", "О компании | Торговый центр «Знак» – товары для ремонта и строительства");
$APPLICATION->SetPageProperty("keywords", "торговый, центр, знак, товар, ремонт, строительство, отделочный, строительный, материал");
$APPLICATION->SetPageProperty("description", "О компании. Торговый центр «Знак». Отделочные и строительные материалы, а также инструменты, текстиль, предметы интерьера, хозтовары, товары для дома.");
$APPLICATION->SetTitle("О компании");
?>
<style>

</style>

<div data-page="about">
    <?php $APPLICATION->IncludeComponent(
        "bitrix:breadcrumb", 
        "znak", 
        array(
            "COMPONENT_TEMPLATE" => ".default",
            "START_FROM" => "0",
            "PATH" => "",
            "SITE_ID" => "-",
        ),
        false
    );?>
    <section class="section">
        <div class="about-page">
            
            <div class="about-hero">
                <div class="container">
                    <h1 class="about-title">Знак – ваш надёжный партнер в создании идеального дома</h1>
                    <p class="about-description">
                        Мы помогаем жителям Алтая создавать<br>
                        комфортный, красивый и функциональный дом<br>
                        уже <strong>более 30</strong> лет
                    </p>
                </div>
            </div>

            <div class="about-gallery">
                <div class="about-gallery-image">
                    <img src="<?= SITE_TEMPLATE_PATH .'/assets/image/znak-red-alt.jpg' ?>"  alt="">
                </div>

                <div class="about-gallery-image">
                    <img src="<?= SITE_TEMPLATE_PATH .'/assets/image/znak-blue.jpg' ?>" alt="">
                </div>

                <div class="about-gallery-image">
                    <img src="<?= SITE_TEMPLATE_PATH .'/assets/image/znak-office-alt.jpg' ?>" alt="">
                </div>
            </div>

            <div class="about-text">
                <div class="container">
                    <p>С самого 1994 года мы выбираем лучшее для наших<br>
                    клиентов: качественные материалы, современные тренды<br>
                    и эксклюзивный ассортимент. Наша цель – чтобы каждый<br>
                    ремонт или проект стал радостью, а не стрессом</p>
                </div>
            </div>

            <div class="about-features">
                <div class="container">
                    <div class="about-features-content">
                    
                        <article class="about-features-card">
                            <h3 class="feature-item-title">+20 000 м<sup>2</sup></h3>
                            <p class="feature-item-description">торговых площадей</p>
                        </article>

                        <article class="about-features-card">
                            <h3 class="feature-item-title">+30 000</h3>
                            <p class="feature-item-description">наименований товаров</p>
                        </article>

                        <article class="about-features-card">
                            <h3 class="feature-item-title">+1000</h3>
                            <p class="feature-item-description">брендов</p>
                        </article>
                    
                    </div>
                </div>
            </div>

            <div class="about-partners">
                <div class="container">
                    <div class="about-partners-header">
                        <h2>Надёжные партнёры – наши дилеры</h2>
                        <p class="about-description">
                        Работаем с проверенными дилерами, чтобы <br> 
                        предлагать качественные товары по доступным ценам
                        </p>
                    </div>
                    <?php $APPLICATION->IncludeComponent(
                        "bitrix:news.list",
                        "partners",
                        array(
                            "IBLOCK_TYPE" => "news",
                            "IBLOCK_ID" => "42",
                            "FIELD_CODE" => array(                
                                "NAME",
                                "PREVIEW_PICTURE",
                            ),
                            "DISPLAY_PANEL" => "N",              
                            "SET_TITLE" => "N",   
                            "INCLUDE_IBLOCK_INTO_CHAIN" => "N",                
                            "SET_STATUS_404" => "Y",
                            "DISPLAY_NAME" => "N",                
                            "DETAIL_URL" => "",
                            "CACHE_TYPE" => "A",                  
                            "CACHE_TIME" => "3600",          
                            "CACHE_FILTER" => "Y",                
                            "CACHE_GROUPS" => "Y",       
                        ),
                        false
                    );?>
                </div>
            </div>
            
        </div>
    </section>

</div>

<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>