<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

global $currentCity;

$badgeData = ProductBadgeManager::getInstance()->getBadges($arResult);

$currentPrice = $arResult['ITEM_PRICES'][0]['PRICE'];
$discount = (int)$arResult['PROPERTIES']['AKTSIYA_']['VALUE'];
$cardDiscount = (int)$arResult['PROPERTIES']['SKIDKA_PO_KARTE_']['VALUE'];

if ($discount > 0) {
    $cardPrice = $currentPrice - ($discount / 100 * $currentPrice);
    $discountPercent = $discount;
} elseif ($cardDiscount > 0) {
    $cardPrice = $currentPrice - ($cardDiscount / 100 * $currentPrice);
    $discountPercent = $cardDiscount;
} else {
    $cardPrice = $currentPrice;
    $discountPercent = 0;
}

$arResult['PRICES']['BASE'] = $arResult['PRICES'][$currentCity['PRICE_CODE']['VALUE']];
$measure= $arResult["PROPERTIES"]["MEASURE"];
?>
<div data-page="product">
    <? $APPLICATION->IncludeComponent(
        "bitrix:breadcrumb", 
        "znak", 
        [
            "COMPONENT_TEMPLATE" => ".default",
            "START_FROM" => "0",
            "PATH" => "",
            "SITE_ID" => "-",
            "SHOW_TITLE" => "N"
        ], 
        false
    );
    ?>
    
    <section class="product-section">
        <div class="container">
            <div class="product-section-wrapper">
                <div class="product-content">
                    <div class="product-gallety-wrapper">
                        <div id="product-gallery" class="swiper product-gallery">
                            <div class="swiper-wrapper">
                                <?if($arResult["IMAGES"]):?>
                                    <?foreach ($arResult["IMAGES"] as $arImage): ?>
                                        <a href="<?=$arImage["BASE_PATH"]?>" 
                                            data-fancybox="gallery"
                                            data-caption="<?=$arResult["NAME"]?>" 
                                            class="swiper-slide product-content-slide fancybox"
                                        >
                                            <img src="<?= $arImage['src'] ?>" 
                                                alt="<?= $arResult["NAME"] ?>"
                                                width="<?= $arImage['width'] ?>"
                                                height="<?= $arImage['height'] ?>"
                                                loading="lazy">
                                        </a>
                                    <? endforeach;?>
                                <? else: ?>
                                    <div class="swiper-slide product-content-slide">
                                        <div class="plug-banner">Нет фото</div>
                                    </div>
                                <? endif;?>
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                        <div class="product-gallery-thumbs-wrapper">

                            <div thumbsslider="" id="product-gallery-controls"
                                class="swiper product-gallery-thumbs">
                               <div class="swiper-wrapper">
                                    <?php if (!empty($arResult["THUMBS"])): ?>
                                        <?php foreach ($arResult["THUMBS"] as $arThumb): ?>
                                            <div class="swiper-slide product-content-slide">
                                                <img src="<?= $arThumb['src'] ?>" 
                                                    alt="<?= $arResult["NAME"] ?>"
                                                    width="<?= $arThumb['width'] ?>"
                                                    height="<?= $arThumb['height'] ?>"
                                                    loading="lazy">
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <div class="swiper-slide product-content-slide">
                                            <div class="plug-banner">Нет фото</div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?if(count($arResult["IMAGES"]) > 3):?>
                                <button id="product-gallery-prev" class="znak-slider-btn znak-prev-btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M10.8284 12.0007L15.7782 16.9504L14.364 18.3646L8 12.0007L14.364 5.63672L15.7782 7.05093L10.8284 12.0007Z">
                                        </path>
                                    </svg>
                                </button>
                                <button id="product-gallery-next" class="znak-slider-btn znak-next-btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M13.1717 12.0007L8.22192 7.05093L9.63614 5.63672L16.0001 12.0007L9.63614 18.3646L8.22192 16.9504L13.1717 12.0007Z">
                                        </path>
                                    </svg>
                                </button>
                            <?endif;?>
                        </div>
                    </div>

                    <div class="product-info">
                         <? $APPLICATION->IncludeComponent(
                                "intensa.favorite:item", 
                                "", 
                                [
                                    'ELEMENT_ID' => $arResult["ID"], 
                                    'CUSTOM_ID' => 'fdesktop'
                                ],
                                false,
                                []
                        );?>

                        <? if(!empty($badgeData["ALL_BADGES"])):?>
                            <div class="product-badges">
                                <?  if ($badgeData['MAIN_BADGE']): ?>
                                    <div class="badge <?= $badgeData['MAIN_BADGE']['class'] ?>">
                                        <span class="badge-label"><?= $badgeData['MAIN_BADGE']['text'] ?></span>
                                    </div>
                                <? endif; ?>
                                <? foreach ($badgeData['ADDITIONAL_BADGES'] as $badge): ?>
                                    <div class="badge <?= $badge['class'] ?>">
                                        <span class="badge-label"><?= $badge['text'] ?></span>
                                    </div>
                                <? endforeach; ?>
                            </div>
                        <? endif; ?>
                        <h1 class="product-title"><?= $arResult["NAME"]?></h1>
                        <div class="product-info-mobile-action">
                            <? $APPLICATION->IncludeComponent(
                                "intensa.favorite:item", 
                                "", 
                                [
                                    'ELEMENT_ID' => $arResult["ID"],
                                    'HAS_TITLE' => 'Y',
                                    'CUSTOM_ID' => 'fmobile'
                                ],
                                false,
                                []
                            );?>
                        </div>
                        <ul class="price-block">
                            <li class="price-container">
                                <span class="price-container-title">цена без карты</span>
                                <div class="price">
                                    <span class="price-integer"><?= number_format($currentPrice, 2, ',', ' ') ?></span>
                                    <span class="price-unit">&#8381<?= '/' . $measure['SYMBOL']?></span>
                                </div>
                            </li>
                            <li class="price-container">
                                <span class="price-container-title">цена по карте</span>
                                <div class="price price--accent">
                                    <span class="price-integer"><?= number_format($cardPrice, 2, ',', ' ') ?></span>
                                    <span class="price-unit">&#8381<?= '/' . $measure['SYMBOL']?></span>
                                </div>
                            </li>
                        </ul>

                        <div class="product-actions">
                            <button class="btn btn-primary btn-product-card" data-id="<?=$arResult["ID"]?>">В корзину</button>
                        </div>
                        <? if(!empty($measure)): ?>
                        <div class="product-info-terms">
                            <p class="terms-text">
                            <?= $measure['SYMBOL']?> - <?=$measure['MEASURE_TITLE'] ?>
                            </p>
                        </div>
                        <?endif;?>
                    </div>
                    
                    <div class="product-content-block product-navigation">
                        <div class="product-navigation-content">
                            <div class="product-navigation-menubar-wrapper">
                                <nav class="product-navigation-menubar">
                                    <ul role="menubar">
                                        <li><a class="menubar-btn active" href="#description">Описание</a></li>
                                        <li><a class="menubar-btn" href="#characterisics">Характеристики</a>
                                        </li>
                                        <li><a class="menubar-btn" href="#related">Похожие</a></li>
                                        <?if(!empty($arResult["TIPS"]["HAS_TIPS"])):?>
                                            <li><a class="menubar-btn" href="#advice">Советы</a></li>
                                        <?endif?>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>

                    <div data-id="description" class="product-content-block product-description">
                        <h1 class="product-block-title">Описание</h1>
                        <div class="product-description-content">
                            <? if (!empty($arResult["DETAIL_TEXT"])): ?>
                                <p class="product-description-text">
                                    <?= $arResult["DETAIL_TEXT"]?>
                                </p>
                            <? else: ?>
                                <p class="product-description-text">
                                    Описание отсутствует
                                </p>
                            <? endif; ?>
                        </div>
                    </div>

                    <div data-id="characterisics" class="product-content-block product-characteristics">
                        <h1 class="product-block-title">Характеристики</h1>
                        <table class="table-characteristics">
                            <? foreach ($arResult['DISPLAY_PROPERTIES'] as $arProp): ?>
                                <? if (!empty($arProp['VALUE'])): ?>
                                    <tr>
                                        <td><?= $arProp["NAME"]?></td>
                                        <td><?= $arProp["VALUE"]?></td>
                                    </tr>
                                <? endif; ?>
                            <? endforeach;?>
                        </table>
                    </div>

                     <div data-id="related" class="product-content-block product-related">
                        <h1 class="product-block-title">Похожие товары</h1>

                        <div class="swiper-container">
                            <div id="product-card-corusel" class="swiper product-card-corusel">

                                <div class="swiper-wrapper">
                                    <? if ($arResult["PROPERTIES"]["SIMILAR"]["VALUE"]){
                                        $APPLICATION->IncludeComponent(
                                            "znak:catalog.products", 
                                            "",
                                            [
                                                "IBLOCK_ID" => $currentCity['IBLOCK_CATALOG']['VALUE'],
                                                "ELEMENTS_COUNT" => count($arResult["PROPERTIES"]["SIMILAR"]["VALUE"]),
                                                "SORT_ORDER" => "DESC",
                                                "FILTER" =>[
                                                    "ID" => $arResult["PROPERTIES"]["SIMILAR"]["VALUE"]
                                                ],
                                                "ADDITIONAL_CLASSES" => "swiper-slide"
                                            ],
                                            false
                                        );
                                       
                                    }else{
                                        $APPLICATION->IncludeComponent(
                                            "znak:catalog.products", 
                                            "",
                                            [
                                                "IBLOCK_ID" => $currentCity['IBLOCK_CATALOG']['VALUE'],
                                                "ELEMENTS_COUNT" => 4,
                                                "SORT_BY" => "RAND",
                                                "SORT_ORDER" => "DESC",
                                                "FILTER" => [
                                                    "IBLOCK_SECTION_ID" => $arResult['IBLOCK_SECTION_ID'],
                                                    "!ID" => $arResult['ID']
                                                ],
                                                "ADDITIONAL_CLASSES" => "swiper-slide"
                                            ],
                                            false
                                        );
                                    }?>
                                </div>

                            </div>
                            <button id="product-list-prev" class="znak-slider-btn znak-prev-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M10.8284 12.0007L15.7782 16.9504L14.364 18.3646L8 12.0007L14.364 5.63672L15.7782 7.05093L10.8284 12.0007Z">
                                    </path>
                                </svg>
                            </button>
                            <button id="product-list-next" class="znak-slider-btn znak-next-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M13.1717 12.0007L8.22192 7.05093L9.63614 5.63672L16.0001 12.0007L9.63614 18.3646L8.22192 16.9504L13.1717 12.0007Z">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    </div> 
                    <?if(!empty($arResult["TIPS"]["HAS_TIPS"])):?>
                        <div data-id="advice" class="product-content-block product-advice">
                            <h1 class="product-block-title">Советы от компании</h1>
                            <div class="swiper-container">
                                <div id="product-advice-slider" class="swiper product-advice-slider">
                                    <div class="swiper-wrapper">
                                        <?
                                        foreach ($arResult["TIPS"]["ITEMS"] as $arTip):
                                            $APPLICATION->IncludeFile(
                                            "/local/include/card-advice.php",
                                            ["arTip" => $arTip],
                                            ["MODE" => "PHP"]
                                            );
                                        endforeach;
                                        ?>
                                    </div>
                                </div>
                                <button id="product-advice-prev" class="znak-slider-btn znak-prev-btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M10.8284 12.0007L15.7782 16.9504L14.364 18.3646L8 12.0007L14.364 5.63672L15.7782 7.05093L10.8284 12.0007Z">
                                        </path>
                                    </svg>
                                </button>
                                <button id="product-advice-next" class="znak-slider-btn znak-next-btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M13.1717 12.0007L8.22192 7.05093L9.63614 5.63672L16.0001 12.0007L9.63614 18.3646L8.22192 16.9504L13.1717 12.0007Z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    <?endif;?>

                    <div class="mobile-price-banner">
                        <div class="mobile-action-image-wrapper">
                            <?if(!empty($arResult["FIRST_IMAGE"]['src'])):?>
                                <img src="<?=$arResult["FIRST_IMAGE"]['src']?>" alt="<?=$arResult["NAME"]?>" >
                            <?else:?>
                                <div class="plug-banner">Нет фото</div>
                            <?endif;?>
                        </div>
                        <div class="product-action-banner-actions">

                            <ul class="price-block">
                                <li class="price-container">
                                    <span class="price-container-title">цена без карты</span>
                                    <div class="price">
                                        <span class="price-integer"><?= number_format($currentPrice, 2, ',', ' ') ?></span>
                                        <span class="price-unit">&#8381/шт</span>
                                    </div>
                                </li>
                                <li class="price-container">
                                    <span class="price-container-title">цена по карте</span>
                                    <div class="price price--accent">
                                        <span class="price-integer"><?= number_format($cardPrice, 2, ',', ' ') ?></span>
                                        <span class="price-unit">&#8381/шт</span>
                                    </div>
                                </li>
                            </ul>

                            <button class="btn btn-primary btn-sm btn-product-card" data-id="<?=$arResult["ID"]?>">
                                <span>В корзину</span>
                                <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet">
                                    <g fill="none" fill-rule="evenodd">
                                        <path
                                            d="M24 0v24H0V0zM12.593 23.258l-.011.002-.071.035-.02.004-.014-.004-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01-.017.428.005.02.01.013.104.074.015.004.012-.004.104-.074.012-.016.004-.017-.017-.427c-.002-.01-.009-.017-.017-.018m.265-.113-.013.002-.185.093-.01.01-.003.011.018.43.005.012.008.007.201.093c.012.004.023 0 .029-.008l.004-.014-.034-.614c-.003-.012-.01-.02-.02-.022m-.715.002a.023.023 0 0 0-.027.006l-.006.014-.034.614c0 .012.007.02.017.024l.015-.002.201-.093.01-.008.004-.011.017-.43-.003-.012-.01-.01z" />
                                        <path
                                            d="M10.464 3.282a2 2 0 0 1 2.964-.12l.108.12L17.468 8h2.985a1.49 1.49 0 0 1 1.484 1.655l-.092.766-.1.74-.082.554-.095.595-.108.625-.122.648-.136.661c-.072.333-.149.667-.232.999a21.018 21.018 0 0 1-.832 2.583l-.221.54-.214.488-.202.434-.094.194-.249.49c-.32.61-.924.97-1.563 1.022l-.16.006H6.555a1.929 1.929 0 0 1-1.71-1.008l-.232-.45-.18-.37a20.09 20.09 0 0 1-.095-.205l-.2-.449a21.536 21.536 0 0 1-1.108-3.276 32.366 32.366 0 0 1-.156-.654l-.142-.648-.127-.634-.112-.613-.1-.587-.087-.554-.074-.513-.09-.683-.066-.556a39.802 39.802 0 0 1-.017-.153 1.488 1.488 0 0 1 1.348-1.64L3.543 8h2.989zm-.503 9.44a1 1 0 0 0-1.96.326l.013.116.5 3 .025.114a1 1 0 0 0 1.96-.326l-.013-.116-.5-3zm5.203-.708a1 1 0 0 0-1.125.708l-.025.114-.5 3a1 1 0 0 0 1.947.442l.025-.114.5-3a1 1 0 0 0-.822-1.15M12 4.562 9.135 8h5.73z" />
                                    </g>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
<script>

 const sliders = [
    {
        selector: "#product-gallery-controls",
        options: {
            additionalContainer: false,
            slidesPerView: 3,
            spaceBetween: 10,
            direction: 'vertical',
            watchSlidesProgress: true,
            rewind: true,
            navigation: {
                prevEl: '#product-gallery-prev',
                nextEl: '#product-gallery-next',
            },

            breakpoints: {
                0: {
                    navigation: { enabled: false }
                },
                1024: {
                    navigation: { enabled: true }
                }
            }
        },
    },
    {
        selector: "#product-gallery",
        options: {
            slidesPerView: 1,
            centeredSlides: true,
            spaceBetween: 16,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },

            thumbs: {
                swiper: "#product-gallery-controls",
            }
        }
    },
    {
        selector: "#product-card-corusel",
        options: {
            slidesPerView: 2,
            grid: {
                fill: "row",
                rows: 2,
            },
            navigation: {
                prevEl: '#product-list-prev',
                nextEl: '#product-list-next',
            },
            breakpoints: {
                768: {
                    slidesPerView: 3,
                    spaceBetween: 18,
                    grid: false,

                },
                1024: {
                    grid: false,
                    spaceBetween: 20,
                    slidesPerView: 2.5,
                    controls: true,
                   
                },
                1280: {
                    slidesPerView: 3,
                    grid: false,
                  
                }

            }
        }
    },
    {
        selector: "#product-advice-slider",
        options: {
            slidesPerView: 1,
            spaceBetween: 12,
            navigation: {
                prevEl: '#product-advice-prev',
                nextEl: '#product-advice-next',
            },
            breakpoints: {
                480: {
                    slidesPerView: 1.5,
                },
                560: {
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 2.25,
                },
                1024: {
                    slidesPerView: 2,
                }
            }
        },
    }
]
function omit(obj, ...keysToOmit) {
    const entries = Object.entries(obj).filter(([key]) => !keysToOmit.includes(key));
    return Object.fromEntries(entries);
}

function initSlider(selector, options) {

    const container = document.querySelector(selector);
    if (!container) return;
    
    let wrapper = container.parentNode; 

    const inited = new Swiper(selector,
        {
            ...omit(options, ['additionalContainer']),
            
        }
    )
}

document.addEventListener("DOMContentLoaded", () => {

    sliders.forEach(({ selector, options }) => {
        initSlider(selector, options);
        
    })

    if (typeof Fancybox !== 'undefined') {
        Fancybox.bind("[data-fancybox]");
    }

    
})

</script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const sections = {};
        const sectionKeys = [];

        document.querySelectorAll('.product-content-block').forEach(function (el) {
            const dataId = el.getAttribute('data-id');
            if (!dataId) return;

            const top = el.offsetTop;
            sections[top] = dataId;
            sectionKeys.push(top);
        });

        sectionKeys.sort((a, b) => a - b);

        function setHash(scrollY) {
            let hash = "";

            for (let i = 0; i < sectionKeys.length; i++) {
                const key = sectionKeys[i];
                if (key <= scrollY + 200) {
                    const currentHash = sections[key];
                    if (currentHash) {
                        hash = currentHash;
                    }
                }
            }

            if (hash && window.location.hash !== hash) {
                history.replaceState(null, '', hash);
            }
        }

        document.querySelectorAll(".menubar-btn").forEach(function (btn) {
            btn.addEventListener("click", function (e) {
                e.preventDefault();
                e.stopPropagation();

                document.querySelectorAll(".menubar-btn").forEach(b => b.classList.remove("active"));
                this.classList.add("active");

                const href = this.getAttribute("href");
                if (!href || !href.startsWith('#')) return;

                const targetSection = document.querySelector(`[data-id="${href.slice(1)}"]`);
                if (!targetSection) return;

                const targetPosition = targetSection.offsetTop;
                window.scrollTo({
                    top: targetPosition,
                    behavior: "smooth"
                });

                if (href !== window.location.hash) {
                    history.pushState(null, '', href);
                }
            });
        });

        function updateActiveLink(scrollY) {
            let activeId = null;

            for (let i = 0; i < sectionKeys.length; i++) {
                const key = sectionKeys[i];
                const nextKey = sectionKeys[i + 1];

                if (scrollY + 200 >= key && (!nextKey || scrollY + 200 < nextKey)) {
                    activeId = sections[key];
                    break;
                }
            }

            if (!activeId && sectionKeys.length > 0) {
                const lastKey = sectionKeys[sectionKeys.length - 1];
                if (scrollY + 200 >= lastKey) {
                    activeId = sections[lastKey];
                }
            }

            document.querySelectorAll(".menubar-btn").forEach(link => {
                const href = link.getAttribute('href');
                if (href && href.slice(1) === activeId) {
                    link.classList.add("active");
                } else {
                    link.classList.remove("active");
                }
            });

            if (activeId) {
                const hash = `#${activeId}`;
                if (window.location.hash !== hash) {
                    history.replaceState(null, '', hash);
                }
            }
        }

        const pNavigation = document.querySelector(".product-info");
        const mobilePrice = document.querySelector(".mobile-price-banner");
        const headerFixed = document.querySelector(".header-fixed");
        let isSticky = false;

        const handleScroll = () => {
            
            if (!pNavigation ) return;    
            
            const headerFixedHeight = headerFixed?.offsetHeight || 0;
            const scrollY = window.scrollY;
            const isDesktop = window.innerWidth > 1024;
            const navTop = pNavigation.getBoundingClientRect().top;

            const threshold = 10;
            const shouldBeSticky = navTop - headerFixedHeight <= threshold;
        
            if (isDesktop) {
                isSticky = shouldBeSticky;
                if (headerFixedHeight) {
                    pNavigation.style.top = `${headerFixedHeight + threshold}px`;
                }                
            } else {
                isSticky = false;
            }

            if(mobilePrice){
                mobilePrice.classList.toggle("active", shouldBeSticky && !isDesktop);
            }

            updateActiveLink(scrollY);
        };

        let ticking = false;
        window.addEventListener('scroll', () => {
            if (!ticking) {
                window.requestAnimationFrame(() => {
                    handleScroll();
                    ticking = false;
                });
                ticking = true;
            }
        });

        let resizeTimer;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => {
                sectionKeys.length = 0;
                document.querySelectorAll('.product-content-block').forEach(function (el) {
                    const dataId = el.getAttribute('data-id');
                    if (!dataId) return;
                    const top = el.offsetTop;
                    sections[top] = dataId;
                    sectionKeys.push(top);
                });
                sectionKeys.sort((a, b) => a - b);

                handleScroll();
            }, 250);
        });


        handleScroll();


        if (window.location.hash) {
            const hash = window.location.hash.slice(1);
            const target = document.querySelector(`[data-id="${hash}"]`);
            if (target) {
                setTimeout(() => {
                    const navHeight = document.querySelector('.product-navigation')?.offsetHeight || 0;
                    window.scrollTo({
                        top: target.offsetTop - navHeight - 20,
                        behavior: 'smooth'
                    });
                }, 300);
            }
        }
    });
</script>


