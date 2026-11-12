<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Распиловка ЛДСП | Торговый центр «Знак» – товары для ремонта и строительства");
$APPLICATION->SetPageProperty("keywords", "Распиловка ЛДСП, торговый, центр, знак, товар, ремонт, строительство, отделочный, строительный, материал");
$APPLICATION->SetPageProperty("description", "Распиловка ЛДСП торгового центра «Знак». Отделочные и строительные материалы, а также инструменты, текстиль, предметы интерьера, хозтовары, товары для дома.");

$APPLICATION->SetTitle("Распиловка ЛДСП");
?>

<div data-page="raspilovka-ldsp" no-title>
    <?$APPLICATION->IncludeComponent(
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
    
    <section class="section raspilovka-ldsp">
        <!-- Hero блок -->
        <div class="raspilovka-hero">
            <div class="container">
                <div class="raspilovka-hero-content">
                    <div class="raspilovka-hero-banner">
                        <div class="raspilovka-hero-text-block">
                            <h1 class="raspilovka-hero-title">Распиловка ЛДСП</h1>
                            <p class="raspilovka-hero-description">
                                Услуга распила ЛДСП позволяет подготовить детали любой сложности 
                                с идеальной геометрией и чистым срезом. Это гарантирует не только 
                                аккуратный внешний вид изделия, но и его долговечность.
                            </p>
                        </div>
                        <img 
                            src="<?= SITE_TEMPLATE_PATH ?>/assets/image/services/banners/service-raspil.jpg" 
                            alt="Услуга распил баннер" 
                            loading="lazy" 
                        />
                    </div>
                    <div class="raspilovka-hero-actions">
                        <button class="btn btn-primary" data-entity="btn-raspilovka">Записаться на услугу</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Блок преимуществ -->
        <div class="section-advantages">
            <div class="container">
                <div class="section-advantages-inner">
                    <div class="section-advantages-content">
                        <h3>Услуги по распилу ДСП:</h3>
                        <p>
                            Это точная и аккуратная обработка плит по заданным размерам. 
                            Мы выполняем распил на профессиональном оборудовании, 
                            обеспечивая ровный рез без сколов и идеальную геометрию деталей.
                        </p>
                    </div>
                    <div class="section-advantages-list">
                        <ul class="advantages-list">
                            <li class="advantages-item">
                                <span class="advantages-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
                                        <path d="M0 0h16v16H0z" fill="none" />
                                        <path fill="#244082" d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638l-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89l-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622l-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01l.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637l.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89l.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622l.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01zm.287 5.984l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708.708" />
                                    </svg>
                                </span>
                                <span class="advantages-text">Изготовление прямолинейных деталей;</span>
                            </li>
                            <li class="advantages-item">
                                <span class="advantages-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
                                        <path d="M0 0h16v16H0z" fill="none" />
                                        <path fill="#244082" d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638l-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89l-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622l-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01l.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637l.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89l.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622l.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01zm.287 5.984l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708.708" />
                                    </svg>
                                </span>
                                <span class="advantages-text">Вырез отверстия под мойку;</span>
                            </li>
                            <li class="advantages-item">
                                <span class="advantages-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
                                        <path d="M0 0h16v16H0z" fill="none" />
                                        <path fill="#244082" d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638l-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89l-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622l-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01l.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637l.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89l.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622l.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01zm.287 5.984l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708.708" />
                                    </svg>
                                </span>
                                <span class="advantages-text">Снятие фаски с ЛДСП;</span>
                            </li>
                            <li class="advantages-item">
                                <span class="advantages-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
                                        <path d="M0 0h16v16H0z" fill="none" />
                                        <path fill="#244082" d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638l-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89l-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622l-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01l.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637l.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89l.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622l.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01zm.287 5.984l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708.708" />
                                    </svg>
                                </span>
                                <span class="advantages-text">Кромление распиленной ДСП ПВХ кромкой.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Блок особенностей -->
        <div class="design-features">
            <div class="container">
                <div class="design-features-content">
                    <article class="design-feature-card" tabindex="0">
                        <h3 class="feature-item-title">Высокая точность распила</h3>
                        <p class="feature-item-description">идеальная геометрия деталей</p>
                    </article>

                    <article class="design-feature-card" tabindex="0">
                        <h3 class="feature-item-title">Быстрое выполнение заказов</h3>
                        <p class="feature-item-description">полный цикл обработки</p>
                    </article>

                    <article class="design-feature-card" tabindex="0">
                        <h3 class="feature-item-title">Полный цикл обработки</h3>
                        <p class="feature-item-description">от распила до кромления</p>
                    </article>
                </div>
            </div>
        </div>

        <!-- Блок цен -->
        <div class="section-prices">
            <div class="container">
                <h3 class="section-prices-title">Стоимость услуг</h3>
                <div class="section-prices-content">
                    <div class="price-card">
                        <div class="price-row">
                            <span class="name">Распил ЛДСП</span>
                            <span class="line"></span>
                            <span class="price">25,00 руб./<br>погонный метр</span>
                        </div>
                    </div>

                    <div class="price-card">
                        <div class="price-row">
                            <span class="name">Кромкооблицовка ЛДСП:</span>
                            <span class="line"></span>
                            <div class="price-subrow">
                                <div class="sub-item">
                                    <span class="name">0,5 мм</span>
                                    <span class="line"></span>
                                    <span class="price">35,00 руб./<br>погонный метр</span>
                                </div>
                                <div class="sub-item">
                                    <span class="name">2 мм</span>
                                    <span class="line"></span>
                                    <span class="price">60,00 руб./<br>погонный метр</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <p class="price-info">
                        Заказ на распил ЛДСП Вы можете оформить у менеджера по заказам.<br>
                        ТЦ "Красный Знак", 1 этаж.
                    </p>
                </div>
            </div>
        </div>
    </section>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>