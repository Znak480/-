<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die(); ?>  
       </main>

       <aside class="mobile-menu-tab" role="navigation" aria-label="Мобильное меню">
            <div class="container">
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        [
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => SITE_TEMPLATE_PATH . "/include/mobile_action.php",
                            "CACHE_TYPE" => "A",
                            "CACHE_TIME" => "86400",
                        ]
                    );?>
            </div>
       </aside>
       
        <!-- Content end -->
        <footer class="footer">
            <div class="footer-wrapper">
                <div class="container">
                    <div class="footer-content">
                        <?php
                        $APPLICATION->IncludeComponent(
                            "bitrix:menu", 
                            "footer_menu",
                            [
                                "ROOT_MENU_TYPE" => "bottom",
                                "MAX_LEVEL" => 2,
                                "USE_EXT" => "N",
                                "CACHE_TYPE" => "A",
                                "CACHE_TIME" => "3600",
                            ]
                        )
                        ?>
                        <div class="footer-block footer-block--socials">
                            <span class="footer-block-label">Социальные сети</span>
                            <?$APPLICATION->IncludeComponent(
                                "bitrix:highloadblock.list",
                                "",
                                Array(
                                    "BLOCK_ID" => "5", // ID вашего Highload-блока
                                    "CHECK_PERMISSIONS" => "Y",
                                    
                                )
                            );?>
                        </div>

                        <div class="payment-cards">
                            <a href="#"><img src="<?= SITE_TEMPLATE_PATH ?>/assets/icon/payment-cards/visa.svg" alt="Visa"></a>
                            <a href="#"><img src="<?= SITE_TEMPLATE_PATH ?>/assets/icon/payment-cards/mastercard.svg" alt="Mastercard"></a>
                            <a href="#"><img src="<?= SITE_TEMPLATE_PATH ?>/assets/icon/payment-cards/mir.svg" alt="МИР"></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-copyright">
                <div class="container">
                    <?php
                    $APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        [
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => SITE_TEMPLATE_PATH . "/include/copyright.php",
                            "CACHE_TYPE" => "A",
                            "CACHE_TIME" => "86400",
                        ],
                        false
                    );
                    ?>
                </div>
            </div>
        </footer>

        <?$APPLICATION->IncludeComponent(
            "bitrix:menu",
            "mobile",
            [
                "ROOT_MENU_TYPE" => "top",   
                "MENU_CACHE_TYPE" => "N",   
                "MENU_CACHE_TIME" => "3600",
                "MAX_LEVEL" => "1",
                "USE_EXT" => "Y",          
                "DELAY" => "N",
                "ALLOW_MULTI_SELECT" => "N",
                "MENU_ID" => "mobile-menu"
            ]
        );?>
    </div>
    <?php
    use Bitrix\Main\Page\Asset;

    $version = filemtime($_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . '/assets/scripts/index.js');
    Asset::getInstance()->addString(
        '<script type="module" src="' . SITE_TEMPLATE_PATH . '/assets/scripts/index.js?ver=' . $version . '"></script>'
    );
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/scripts/sliders.js');
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/scripts/sliders-init.js');
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/scripts/cart.js');
    ?>  
    
   
</body>
</html>    