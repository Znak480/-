<?

    if (!defined('PRODUCT_CARD_JS_LOADED')) {
        define('PRODUCT_CARD_JS_LOADED', true);
        $APPLICATION->AddHeadScript("/local/js/card-product.js");
    }
    
    global $currentCity;
    $arItem['PRICES']['BASE']=$arItem['PRICES'][$currentCity['PRICE_CODE']['VALUE']];
    $badgeData = $arItem['BADGE_DATA'];
?>

<!-- Product card start -->
<div class="product-card <?=$arItem['ADDITIONAL_CLASSES']?>" data-product-id="<?=$arItem["ID"]?>" data-card="product">
    
    <div class="product-card-image-wrapper">
      <?  if ($badgeData['MAIN_BADGE']): ?>
        <div class="badge <?= $badgeData['MAIN_BADGE']["class"]?>">
            <span class="badge-label"><?= $badgeData['MAIN_BADGE']['text'] ?></span>
        </div>
        <? endif; ?>

        <? if($arItem["PREVIEW_PICTURE"]["ID"]):?>
            <? 
            $image = CFile::ResizeImageGet(
                $arItem["PREVIEW_PICTURE"]["ID"], 
                ['width' => '960', 'height' => '960'],
                BX_RESIZE_IMAGE_EXACT,
                true
            ); 
            ?>
            <img 
                src="<?= $image['src']?>"  
                alt="<?= htmlspecialcharsbx($arItem["NAME"])?>" 
                loading="lazy"
            >
        <? else: ?>
            <div class="product-no-image">
                <span>Нет фото</span>
            </div>
        <? endif;?>

        <? $APPLICATION->IncludeComponent("intensa.favorite:item", "", 
            ['ELEMENT_ID' => $arItem["ID"],],
            false,
            []
        );?>
    </div>
    <a a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="product-card-title">
        <? if (mb_strlen($arItem["NAME"]) > 70): ?>
            <?= mb_substr($arItem["NAME"], 0, 70) ?>...
        <? else: ?>
            <?= $arItem["NAME"] ?>
        <? endif; ?>
    </a>

    <? if (!empty($arItem['ITEM_PRICES'])): ?>
        <ul class="product-card-price">
            <?
                $currentPrice = $arItem['ITEM_PRICES'][0]['PRICE'];
                $discount = (int)$arItem['PROPERTIES']['AKTSIYA_']['VALUE'];
                $cardDiscount = (int)$arItem['PROPERTIES']['SKIDKA_PO_KARTE_']['VALUE'];
                
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
            ?>

            <li>
                <span class="product-card-price-title">цена без карты</span>
                <div class="price">
                    <span class="price-integer"><?= number_format($currentPrice, 2, ',', ' ') ?></span>
                    <span class="price-unit">&#8381</span>
                </div>
            </li>
            <li>
                <span class="product-card-price-title">цена по карте</span>
                <div class="price price--accent">
                    <span class="price-integer"><?= number_format($cardPrice, 2, ',', ' ') ?></span>
                    <span class="price-unit">&#8381</span>
                </div>
            </li>
        </ul>
    <? endif; ?>

    <div class="product-card-actions">
        <div class="input-number card-input-number">
            <button class="decrement">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M19 11H5V13H19V11Z"></path>
                </svg>
            </button>
            <input type="number" class="quantity" value="1" min="1">
            <button class="increment">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path
                        d="M13.0001 10.9999L22.0002 10.9997L22.0002 12.9997L13.0001 12.9999L13.0001 21.9998L11.0001 21.9998L11.0001 12.9999L2.00004 13.0001L2 11.0001L11.0001 10.9999L11 2.00025L13 2.00024L13.0001 10.9999Z">
                    </path>
                </svg>
            </button>
        </div>
        <button class="btn btn-primary btn-product-card" data-id="<?=$arItem["ID"]?>">В корзину</button>
    </div>
</div>
<!-- Product card end -->

