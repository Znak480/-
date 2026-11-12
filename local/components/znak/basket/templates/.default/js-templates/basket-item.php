<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arParams
 * @var string $templateFolder
 */
?>

<script id="basket-item-template" type="text/html">
     <article class="basket-product-item" data-entity="product-item" data-product-id="{{PRODUCT_ID}}">
        <div class="basket-product-item-checkbox">
            <label class="checkbox">
                <input 
                    data-entity="product-checkbox" 
                    data-product-id="{{PRODUCT_ID}}"
                    type="checkbox" 
                    name="product-{{PRODUCT_ID}}" 
                    {{#SELECTED}}checked{{/SELECTED}}
                >
            </label>
        </div>

        <div class="basket-product-item-image">
            <img src="{{PICTURE.SRC}}" alt="{{NAME}}" loading="lazy">
        </div>

        <div class="basket-product-item-info">
            {{#BADGES.HAS_BADGE}}
            <div class="badges">
                <div class="badge {{BADGES.MAIN_BADGE.class}}"><span class="badge-label">{{BADGES.MAIN_BADGE.text}}</span></div>
            </div>
            {{/BADGES.HAS_BADGE}}

			<a href="{{URL}}" class="basket-product-item-title"  data-entity="basket-item-name">{{NAME}}</a>
			<div class="basket-product-item-article">Цена за {{MEASURE.NAME}}: <span class="article">{{BASE_PRICE_FORMATED}}</span></div>
		</div>

        <div class="basket-product-item-price">
            {{#SHOW_OLD_PRICE}}
            <div class="price price--old">
                <span class="price-integer">{{SUM_BASE_PRICE_FORMATED}}</span>
                <span class="price-divider">/</span>
                <span class="price-unit">{{MEASURE.NAME}}</span>
            </div>
           {{/SHOW_OLD_PRICE}}
            <div class="price">
                <span class="price-integer">{{SUM_PRICE_FORMATED}}</span>
                <span class="price-divider">/</span>
                <span class="price-unit">{{MEASURE.NAME}}</span>
            </div>
        </div>

        <div class="basket-product-item-quantity">
            <div class="input-number">
                <button class="decrement" aria-label="Уменьшить количество">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 11H5V13H19V11Z"></path>
                    </svg>
                </button>
                <input 
                    type="number" 
                    class="quantity" 
                    value="{{QUANTITY}}"
                    data-value="{{QUANTITY}}"
                    aria-label="Количество"
					data-entity="basket-item-quantity"
					id="basket-item-quantity-{{PRODUCT_ID}}"
                >
                <button class="increment" aria-label="Увеличить количество">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M13.0001 10.9999L22.0002 10.9997L22.0002 12.9997L13.0001 12.9999L13.0001 21.9998L11.0001 21.9998L11.0001 12.9999L2.00004 13.0001L2 11.0001L11.0001 10.9999L11 2.00025L13 2.00024L13.0001 10.9999Z"></path>
                    </svg>
                </button>
            </div>
        </div>

        <button class="btn btn-ghost btn-sm basket-product-item-remove" aria-label="Удалить товар" data-entity="delete-button">
            <svg xmlns="http://www.w3.org/2000/svg" width="256" height="256" viewBox="0 0 256 256">
                <path d="M0 0h256v256H0z" fill="none" />
                <path fill="currentColor" d="M216 48h-40v-8a24 24 0 0 0-24-24h-48a24 24 0 0 0-24 24v8H40a8 8 0 0 0 0 16h8v144a16 16 0 0 0 16 16h128a16 16 0 0 0 16-16V64h8a8 8 0 0 0 0-16M112 168a8 8 0 0 1-16 0v-64a8 8 0 0 1 16 0Zm48 0a8 8 0 0 1-16 0v-64a8 8 0 0 1 16 0Zm0-120H96v-8a8 8 0 0 1 8-8h48a8 8 0 0 1 8 8Z" />
            </svg>
            <span>Удалить</span>
        </button>
    </article>
</script>