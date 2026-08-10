<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $mobileColumns
 * @var array $arParams
 * @var string $templateFolder
 */
?>
<script id="basket-item-template" type="text/html">
	{{^SHOW_RESTORE}}
	<article class="basket-product-item" id="basket-item-{{ID}}" data-entity="basket-item" data-id="{{ID}}">
		<div class="basket-product-item-checkbox">
			<label class="checkbox">
				<input type="checkbox" data-index="{{ID}}" name="product-{{ID}}" ${item.checked !== false ? 'checked' : ''}>
			</label>
		</div>


		<?
		if (in_array('PREVIEW_PICTURE', $arParams['COLUMNS_LIST']))
		{
			?>
			<div class="basket-product-item-image">
				{{#DETAIL_PAGE_URL}}
				<a href="{{DETAIL_PAGE_URL}}">
				{{/DETAIL_PAGE_URL}}
					<img src="{{{IMAGE_URL}}}{{^IMAGE_URL}}<?=$templateFolder?>/images/no_photo.png{{/IMAGE_URL}}"
					    alt="{{NAME}}" loading="lazy">
				{{#DETAIL_PAGE_URL}}
				</a>
				{{/DETAIL_PAGE_URL}}
			</div>
			<?
		}
		?>

		<div class="basket-product-item-info">
			<a href="{{DETAIL_PAGE_URL}}" class="basket-product-item-title">{{NAME}}</a>
			  <div class="basket-product-item-article">Цена за шт: <span class="article">{{{PRICE_FORMATED}}}</span></div>
		</div>

		<div class="basket-product-item-price">
			<div class="price price--old">
				<span class="price-integer">{{{SUM_PRICE_FORMATED}}}</span>
				
			</div>
			<div class="price">
				<span class="price-integer" id="basket-item-price-{{ID}}">{{{CUSTOM_DISCOUNT_SUM_FORMATED}}}</span>
			</div>
		</div>

		<div class="basket-product-item-quantity">
			<div class="input-number" data-entity="basket-item-quantity-block">
				<button class="decrement" data-index="${index}" aria-label="Уменьшить количество">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
						<path d="M19 11H5V13H19V11Z"></path>
					</svg>
				</button>
				<input 
					type="number" 
					class="quantity" value="{{QUANTITY}}"
					{{#NOT_AVAILABLE}} disabled="disabled"{{/NOT_AVAILABLE}}
					data-value="{{QUANTITY}}"
					data-entity="basket-item-quantity-field"
					id="basket-item-quantity-{{ID}}"
				>
				<button class="increment" aria-label="Увеличить количество">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
						<path d="M13.0001 10.9999L22.0002 10.9997L22.0002 12.9997L13.0001 12.9999L13.0001 21.9998L11.0001 21.9998L11.0001 12.9999L2.00004 13.0001L2 11.0001L11.0001 10.9999L11 2.00025L13 2.00024L13.0001 10.9999Z"></path>
					</svg>
				</button>
			</div>
		</div>

		<button class="btn btn-ghost btn-sm basket-product-item-remove" data-entity="basket-item-delete" aria-label="Удалить товар">
			<svg xmlns="http://www.w3.org/2000/svg" width="256" height="256" viewBox="0 0 256 256">
				<path d="M0 0h256v256H0z" fill="none" />
				<path fill="currentColor" d="M216 48h-40v-8a24 24 0 0 0-24-24h-48a24 24 0 0 0-24 24v8H40a8 8 0 0 0 0 16h8v144a16 16 0 0 0 16 16h128a16 16 0 0 0 16-16V64h8a8 8 0 0 0 0-16M112 168a8 8 0 0 1-16 0v-64a8 8 0 0 1 16 0Zm48 0a8 8 0 0 1-16 0v-64a8 8 0 0 1 16 0Zm0-120H96v-8a8 8 0 0 1 8-8h48a8 8 0 0 1 8 8Z" />
			</svg>
			<span>Удалить</span>
			{{#SHOW_LOADING}}
							<div class="basket-items-list-item-overlay"></div>
						{{/SHOW_LOADING}}
		</button>
	</article>
	{{/SHOW_RESTORE}}


	
</script>