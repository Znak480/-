<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<?global $currentCity;?>
<?$arResult['PRICES']['BASE'] = $arResult['PRICES'][$currentCity['PRICE_CODE']['VALUE']];?>

<script type="text/javascript">
    function compare_tov(id) {
        var thisElem = $('#compareid_' + id);
        var chek = thisElem.data('chosen');
        if (chek) {
            thisElem.data('chosen', 0);
            // Добавить
            var AddedGoodId = id;
            $.get("/ajx/list_compare.php", {
                action: "ADD_TO_COMPARE_LIST",
                id: AddedGoodId
            }, function(data) {
                thisElem.html(data);
                console.log($(this));
            });
        } else {
            // console.log('zero');
            // thisElem.data('chosen',1);
            // Удалить
            // var AddedGoodId = id;
            // $.get("/ajx/list_compare.php", {
            //     action: "DELETE_FROM_COMPARE_LIST",
            //     id: AddedGoodId
            // }, function(data) {
            //     thisElem.html(data);
            // });
        }
    }
    BX.ajax.post(
        '/bitrix/components/bitrix/catalog.element/ajax.php',
        {
            AJAX: 'Y',
            SITE_ID: 's1',
            PRODUCT_ID: <?=$arResult['ID']?>
        }
    );
</script>

<div class="rb">
    <div class="common-content-thin product-page">
        <div class="title-block regular-block">
            <? $APPLICATION->IncludeComponent("bitrix:breadcrumb", "znak", array(
                "COMPONENT_TEMPLATE" => ".default",
                "START_FROM" => "0",
                "PATH" => "",
                "SITE_ID" => "-"
            ), false); 
            ?>
        </div>

        <div class="content-block regular-block product">
            <div class="product-title">
                <?=$arResult["NAME"]?>
            </div>

            <div class="images image">
                <?
                $pictures = array();

                if ($arResult["PREVIEW_PICTURE"]["ID"]) {
                    $pictures[] = $arResult["PREVIEW_PICTURE"]["ID"];
                }

                if (!empty($arResult["PROPERTIES"]["PICTURES"]["VALUE"])) {
                    $pictures = array_merge($pictures, $arResult["PROPERTIES"]["PICTURES"]["VALUE"]);
                }

                if (!empty($arResult["PROPERTIES"]["GALLERY"]["VALUE"])) {
                    $pictures = array_merge($pictures, $arResult["PROPERTIES"]["GALLERY"]["VALUE"]);
                }

                $pictures = array_unique($pictures);
                ?>
                <div style="position: relative">
                    <?
                    if (!empty($arResult['PROPERTIES']['RAITING_PRODAZH']['VALUE']) || !empty($arResult['PROPERTIES']['AKTSIYA_']['VALUE'])) {

                        if (!empty($arResult['PROPERTIES']['AKTSIYA_']['VALUE'])) {
                    ?>
                            <div class="product__label product__label_type5">
                                <span>Акция <?= $arResult['PROPERTIES']['AKTSIYA_']['VALUE']?>%</span>
                            </div>
                    <?
                        } else {
                            switch ($arResult['PROPERTIES']['RAITING_PRODAZH']['VALUE']) {
                                case 'Эксклюзив':
                                    $labelType = 1; // красный
                                    break;
                                case 'Рекомендуем':
                                    $labelType = 2; // фиолетовый
                                    break;
                                case 'Новинка':
                                    $labelType = 3; // жёлтый, текст — чёрный
                                    break;
                                case 'Хит':
                                    $labelType = 4; // синий
                                    break;
                                default:
                                    $labelType = '';
                                    break;
                            }
                    ?>
                        <div class="product__label product__label_type<?= $labelType ?>">
                            <span><?= $arResult['PROPERTIES']['RAITING_PRODAZH']['VALUE'] ?></span>
                        </div>
                    <?
                        }
                    }

                    if (!empty($arResult['PROPERTIES']['POD_ZAKAZ']['VALUE'])) {
                    ?>
                        <div class="product__label product__label_type6">
                            <span>Под заказ</span>
                        </div>
                    <?
                    }

                    if (!empty($arResult['PROPERTIES']['TSENA_CHTO_NADO']['VALUE'])) {
                    ?>
                        <div class="product__label product__label_type5">
                            <span>Лучшая цена</span>
                        </div>
                    <?
                    }
                    ?>
                </div>

                <div class="product-slider">
                    <!-- Основной слайдер -->
                    <div class="slider-for">
                        <? foreach ($pictures as $picId): ?>
                        <?
                            $picPath = CFile::GetPath($picId);
                            $main = CFile::ResizeImageGet($picId, array('width' => 200, 'height' => 200), BX_RESIZE_IMAGE_PROPORTIONAL, true);
                        ?>
                            <div class="main-image">
                                <a href="<?= $picPath ?>" class="fancybox" rel="gal">
                                    <img
                                        src="<?= $main['src'] ?>"
                                        alt="<?= htmlspecialchars($arResult["NAME"]) ?>"
                                        data-fancybox="gallery"
                                    >
                                </a>
                            </div>
                        <? endforeach; ?>
                    </div>

                    <!-- Миниатюры -->
                    <div class="slider-nav">
                        <? foreach ($pictures as $picId): ?>
                            <? $picPath = CFile::GetPath($picId); ?>
                            <div class="gallary-image-wrapper">
                                <img
                                    src="<?= $picPath ?>"
                                    alt="<?= htmlspecialchars($arResult["NAME"]) ?>"
                                >
                            </div>
                        <? endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="product-info">
                <div class="product-info__container">
                    <div class="product-info-questions">
                        <div class="product-info__block">
                            <a href="/dostavka.php" class="product-link">Как забрать товар?</a>
                            <div class="chosen">
                                <div class="chosen__ico">
                                    <img src="/images/delivery.svg" alt="">
                                </div>
                                <span>Курьерская доставка</span>
                            </div>
                        </div>
                        <div class="product-info__block">
                            <a href="/payment/" class="product-link">Как оплатить товар?</a>
                            <div class="chosen">
                                <div class="chosen__ico">
                                    <img src="/images/payment.svg" alt="">
                                </div>
                                <span>Банковской картой</span>
                            </div>
                        </div>
                    </div>

                    <div class="product-chars-new">
                        <div class="product-availability">
                            <?= qtyProduct($arResult['CATALOG_QUANTITY'], $arResult['ITEM_MEASURE']['TITLE']) ?>
                        </div>

                        <span class="p-price">
                            <?=$arResult['ITEM_PRICES'][0]['PRINT_PRICE']?> за <?=$arResult['ITEM_MEASURE']['TITLE']?>
                        </span>**

                        <div class="product-info__price-card">
                            <?
                            $basePrice = $arResult['ITEM_PRICES'][0]['PRICE'];
                            if (!empty($arResult['PROPERTIES']['AKTSIYA_']['VALUE'])): ?>
                                <span class="blue">Цена по акции</span>
                                <span class="p-price p-price_strong">
                                    <?= number_format($basePrice - $arResult['PROPERTIES']['AKTSIYA_']['VALUE'] / 100 * $basePrice, 2, ',', ' ') ?> р.
                                </span>**
                            <? else: ?>
                                <span class="blue">Цена по карте</span>
                                <span class="p-price p-price_strong">
                                    <?= number_format($basePrice - (int) $arResult['PROPERTIES']['SKIDKA_PO_KARTE_']['VALUE'] / 100 * $basePrice, 2, ',', ' ') ?> р.
                                </span>
                                <span style="position: absolute;">**</span>
                            <? endif; ?>
                        </div>

                        <div class="product-actions">
                            <label class="counter">
                                <input
                                    type="number"
                                    class="counter__input quantity"
                                    value="1"
                                    min="1"
                                    id="quant<?=$arResult["ID"]?>"
                                >
                            </label>
                            <button class="btn btn_add add-to-cart" rel="<?=$arResult["ID"]?>">В корзину</button>
                            <button class="btn buy1click" data-prod="<?=$arResult["ID"]?>">Купить в 1 клик</button>
                        </div>

                        <span
                            class="compare-link"
                            id="compareid_<?=$arResult['ID'];?>"
                            onclick="compare_tov(<?=$arResult['ID'];?>)"
                            data-chosen="1"
                        >
                            <? $APPLICATION->IncludeComponent(
                                "bitrix:catalog.compare.list",
                                "ajax_count",
                                array(
                                    "IBLOCK_TYPE" => "catalog",
                                    "IBLOCK_ID" => IBLOCK_PRODUCTS_ID,
                                    "AJAX_MODE" => "N",
                                    "AJAX_OPTION_JUMP" => "N",
                                    "AJAX_OPTION_STYLE" => "Y",
                                    "AJAX_OPTION_HISTORY" => "N",
                                    "DETAIL_URL" => "#SECTION_CODE#",
                                    "COMPARE_URL" => "compare.php",
                                    "NAME" => "CATALOG_COMPARE_LIST",
                                    "AJAX_OPTION_ADDITIONAL" => "",
                                    "PRODUCT_ID" => $arResult['ID']
                                ),
                                false
                            ); ?>
                        </span>

                        <p class="specialLabel">
                            * - Наличие товара уточняйте у сотрудников компании. Тел. 8 (3852) 36‑40‑80<br>
                            ** - Окончательная стоимость рассчитывается в соответствии с действующей дисконтной системой.
                        </p>
                    </div>
                </div>

                <? if (!empty($arResult['PRICES']['BASE']['PRINT_VALUE'])): ?>
                    <div style="font-size: 20px; margin: 50px 0px 0px; display: none;">
                        Цена: <?=$arResult['PRICES']['BASE']['PRINT_VALUE']?>
                    </div>
                <? endif; ?>

                <div class="buttons-block" style="display: none;">
                    <div class="buttons">
                        <input
                            type="number"
                            min="1"
                            class="quantity"
                            id="quant<?=$arResult["ID"]?>"
                            value="1"
                        >
                        <input
                            type="button"
                            value="В корзину"
                            rel="<?=$arResult["ID"]?>"
                            class="add-to-cart"
                        >
                    </div>
                </div>
            </div>

            <div class="product-content">
                <? if (!empty($arResult["DETAIL_TEXT"])): ?>
                    <span class="caption">Описание</span>
                    <p>
                        <?= $arResult["DETAIL_TEXT"]?>
                    </p>
                <? endif; ?>

                <span class="caption">Характеристики</span>
                <ul class="product-characteristics">
                    <?
                    $rejectProps  = array("Реквизиты", "Ставки налогов", "Код товара", "поисковый контент", "Под заказ", "Цена что надо");
                    //Списко кодов свойств, который не должны входить в характеристики (служебные)
                    $rejectPropsCodes = array("CML2_ARTICLE", "GALLERY");
                    ?>
                    <? foreach ($arResult['PROPERTIES'] as $arProp): ?>
                        <?
                        if (
                            in_array($arProp["NAME"], $rejectProps) ||
                            in_array($arProp["CODE"], $rejectPropsCodes)
                        ) {
                            continue;
                        }
                        ?>
                        <? if (!empty($arProp['VALUE'])): ?>
                            <li>
                                <div>
                                    <span><?= $arProp['NAME'] ?> </span>
                                </div>
                                <div>
                                    <span><?= $arProp['VALUE'] ?></span>
                                </div>
                            </li>
                        <? endif; ?>
                    <? endforeach; ?>
                </ul>
            </div>

            <div class="clear"></div>

            <? if ($arResult["PROPERTIES"]["SAME"]["VALUE"]): ?>
                <div class="similars">
                    <h1 class="common-din" style="margin-top: -60px;">С этим товаром покупают</h1>
                    <? foreach ($arResult["PROPERTIES"]["SAME"]["VALUE"] as $k => $same): ?>
                        <? if ($k == 3) break; ?>
                        <?
                        $arFields = getElementById($same);
                        $APPLICATION->IncludeFile(
                            "/local/include/card-product.php",
                            array("arItem" => $arFields),
                            array("MODE" => "PHP")
                        );
                        ?>
                    <? endforeach; ?>
                    <div class="clear"></div>
                </div>
            <? endif; ?>

            <div class="clear"></div>

            <? if ($arResult["PROPERTIES"]["SIMILAR"]["VALUE"]): ?>
                <div class="similars">
                    <h1 class="common-din" style="margin-top: -60px;">Похожие товары</h1>
                    <? foreach ($arResult["PROPERTIES"]["SIMILAR"]["VALUE"] as $k => $same): ?>
                        <? if ($k == 3) break; ?>
                        <?
                        $arFields = getElementById($same);
                        if ($arFields['PREVIEW_PICTURE']) {
                            $file_prev_id = $arFields['PREVIEW_PICTURE'];
                            unset($arFields['PREVIEW_PICTURE']);
                            $arFields['PREVIEW_PICTURE'] = CFile::GetFileArray($file_prev_id);
                        }
                        $APPLICATION->IncludeFile(
                            "/local/include/card-product.php",
                            array("arItem" => $arFields),
                            array("MODE" => "PHP")
                        );
                        ?>
                    <? endforeach; ?>
                    <div class="clear"></div>
                </div>
            <? else: ?>
                <div class="similars">
                    <h1 class="common-din" style="margin-top: -60px;">Похожие товары</h1>
                    <?
                    $arSelect = array(
                        "ID",
                        "NAME",
                        "DATE_ACTIVE_FROM",
                        "PROPERTY_SALE",
                        "PROPERTY_DISCOUNT",
                        "PROPERTY_HIT",
                        "PREVIEW_PICTURE",
                        "DETAIL_PAGE_URL",
                        "CATALOG_GROUP_".$currentCity['PRICE_ID']['VALUE'],
                        "PROPERTY_SKIDKA_PO_KARTE_",
                        "PROPERTY_RAITING_PRODAZH",
                        "PROPERTY_AKTSIYA_"
                    );
                    $arFilter = array(
                        "IBLOCK_ID"          => $currentCity['IBLOCK_CATALOG']['VALUE'],
                        "ACTIVE_DATE"        => "Y",
                        "ACTIVE"             => "Y",
                        "!NAME"              => false
                    );
                    $arFilter[] = array(
                        "IBLOCK_SECTION_ID" => $arResult['IBLOCK_SECTION_ID'],
                        "!ID"               => $arResult['ID']
                    );

                    $res = CIBlockElement::GetList(
                        array("RAND" => "rand"),
                        $arFilter,
                        false,
                        array("nTopCount" => 3),
                        $arSelect
                    );

                    while ($ob = $res->GetNextElement()) {
                        $arFields = $ob->GetFields();
                        $arFields['PRICES'][$currentCity['PRICE_CODE']['VALUE']] = array(
                            "VALUE"       => $arFields['CATALOG_PRICE_'.$currentCity['PRICE_ID']['VALUE']],
                            "PRINT_VALUE" => $arFields['CATALOG_PRICE_'.$currentCity['PRICE_ID']['VALUE']].' р.'
                        );

                        if ($arFields['PREVIEW_PICTURE']) {
                            $file_prev_id = $arFields['PREVIEW_PICTURE'];
                            unset($arFields['PREVIEW_PICTURE']);
                            $arFields['PREVIEW_PICTURE'] = CFile::GetFileArray($file_prev_id);
                        }

                        $arFields['PROPERTIES']['SKIDKA_PO_KARTE_']['VALUE'] = $arFields['PROPERTY_SKIDKA_PO_KARTE__VALUE'];
                        $arFields['ITEM_PRICES'][0]['PRICE']        = $arFields['CATALOG_PRICE_'.$currentCity['PRICE_ID']['VALUE']];
                        $arFields['ITEM_PRICES'][0]['PRINT_PRICE']  = $arFields['CATALOG_PRICE_'.$currentCity['PRICE_ID']['VALUE']].' р.';

                        $APPLICATION->IncludeFile(
                            "/local/include/card-product.php",
                            array("arItem" => $arFields),
                            array("MODE" => "PHP")
                        );
                    }
                    ?>
                    <div class="clear"></div>
                </div>
            <? endif; ?>

            <? include('combo.php'); ?>
        </div>
    </div>
</div>