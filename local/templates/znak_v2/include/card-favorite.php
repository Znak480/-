<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * Карточка товара для избранного
 * 
 * @var array $item - данные товара из bitrix:catalog.section
 */
$item = $arParams["arItem"] ?? [];

$name = $item['NAME'] ?? 'Товар';
$detailUrl = $item['DETAIL_PAGE_URL'] ?? '#';
$article = $item['ARTICLE'] ?? $item['PROPERTIES']['ARTICLE']['VALUE'] ?? '';
$priceData = $item['PRICE_DATA'];

$image = $item['PREVIEW_PICTURE'];
if (is_array($image)) {
    $imageSrc = $image['SRC'];
} elseif (is_numeric($image)) {
    $imageSrc = CFile::GetPath($image);
}

$productId = $item['ID'] ?? 0;
$randomIndex = rand(1000, 9999);
?>

<article class="product-item product-item--favorite" data-card="favorite" data-product-id="<?= $productId ?>" data-index="<?= $randomIndex ?>">
    <a href="<?= $detailUrl ?>" class="product-item-image">
        <?if(!empty($imageSrc)):?>
            <img src="<?= $imageSrc ?>" alt="<?= htmlspecialcharsbx($name) ?>" loading="lazy">
        <?else:?>
            <div class="plug-banner">Нет фото</div>
        <?endif;?>
    </a>

    <div class="product-item-info">
        <?php if ($article): ?>
            <div class="product-item-article">
                Артикул: <span class="article"><?= htmlspecialcharsbx($article) ?></span>
            </div>
        <?php endif; ?>
        <h4 class="product-item-title">
            <a href="<?= $detailUrl ?>"><?= htmlspecialcharsbx($name) ?></a>
        </h4>
    </div>
    <div class="product-item-price">
        <?php if ($priceData["PRICE_CHANGED_FLAG"] && $priceData['CURRENT_PRICE']): ?>
            <div class="price price--old" data-price="<?=$item['PRICE_DATA']['CURRENT_PRICE']?>">
                <span class="price-integer"> <?=$item['PRICE_DATA']['CURRENT_PRICE']?></span>
                <span class="price-unit">₽</span>
            </div>
        <?php endif; ?>
        <?php if ($priceData['DISCOUNT_PRICE']): ?>
            <div class="price" data-price="<?=$item['PRICE_DATA']['DISCOUNT_PRICE']?>">
                <span class="price-integer"><?= $item['PRICE_DATA']['DISCOUNT_PRICE']?></span>
                <span class="price-unit">₽</span>
            </div>
        <?php endif; ?>
    </div>

    <div class="product-item-actions">
        <div class="product-item-quantity">
            <div class="input-number">
                <button class="decrement" data-index="<?= $randomIndex ?>" aria-label="Уменьшить количество">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 11H5V13H19V11Z" />
                    </svg>
                </button>
                <input type="number" class="quantity" value="1" min="1" data-index="<?= $randomIndex ?>" aria-label="Количество">
                <button class="increment" data-index="<?= $randomIndex ?>" aria-label="Увеличить количество">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M13.0001 10.9999L22.0002 10.9997L22.0002 12.9997L13.0001 12.9999L13.0001 21.9998L11.0001 21.9998L11.0001 12.9999L2.00004 13.0001L2 11.0001L11.0001 10.9999L11 2.00025L13 2.00024L13.0001 10.9999Z" />
                    </svg>
                </button>
            </div>
        </div>
        <button type="button" class="btn btn-primary btn-sm product-item-add-to-cart btn-product-card" data-id="<?= $productId ?>">
            В корзину
        </button>
    </div>

    <button class="product-item-remove js-favorite-delete" data-id="<?= $productId ?>" aria-label="Удалить товар">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 256 256">
            <path d="M0 0h256v256H0z" fill="none" />
            <path fill="currentColor" d="M216 48h-40v-8a24 24 0 0 0-24-24h-48a24 24 0 0 0-24 24v8H40a8 8 0 0 0 0 16h8v144a16 16 0 0 0 16 16h128a16 16 0 0 0 16-16V64h8a8 8 0 0 0 0-16M112 168a8 8 0 0 1-16 0v-64a8 8 0 0 1 16 0Zm48 0a8 8 0 0 1-16 0v-64a8 8 0 0 1 16 0Zm0-120H96v-8a8 8 0 0 1 8-8h48a8 8 0 0 1 8 8Z" />
        </svg>
        <span>Удалить</span>
    </button>
</article>

<script>
</script>