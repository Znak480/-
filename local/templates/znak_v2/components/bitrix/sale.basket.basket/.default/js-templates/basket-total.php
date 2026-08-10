<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arParams
 */
?>
<script id="basket-total-template" type="text/html">
	<div class="cart-info-content" data-entity="basket-checkout-aligner">
		<div class="cart-info-description">
			<div class="info-description-row" data-price="base-price">
				<span class="description-row-label">Товары (<span data-product-count
						class="count">{{{CUSTOM_TOTAL_ITEMS}}}</span>
					шт.)</span>
				<span class="description-row-value" data-price-value="base-value">{{{PRICE_WITHOUT_DISCOUNT_FORMATED}}}</span>
			</div>
			<div class="info-description-row" data-price="descount-price">
				<span class="description-row-label">Cкидка</span>
				<span class="description-row-value"
					data-price-value="descount-value">{{{CUSTOM_SAVING_FORMATED}}}</span>
			</div>
			<div class="info-description-row " data-price="total-price">
				<span class="description-row-label">Итого</span>
				<span class="description-row-value" data-price-value="total-value">{{{CUSTOM_DISCOUNT_SUM_FORMATED}}}</span>
			</div>
			<div class="info-description-row" data-price="unselected-price">
				<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
					viewBox="0 0 24 24">
					<path d="M0 0h24v24H0z" fill="none" />
					<path fill="currentColor"
						d="M11 17h2v-6h-2zm1.713-8.287Q13 8.425 13 8t-.288-.712T12 7t-.712.288T11 8t.288.713T12 9t.713-.288M12 22q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22m0-2q3.35 0 5.675-2.325T20 12t-2.325-5.675T12 4T6.325 6.325T4 12t2.325 5.675T12 20m0-8" />
				</svg>
				<span>Выберети товары, чтобы перейти к оформлению заказа</span>
			</div>
		</div>

		<div class="cart-info-actions">
			<button 
				type="button" 
				class="btn btn-primary btn-sm cart-place-order {{#DISABLE_CHECKOUT}} disabled{{/DISABLE_CHECKOUT}}"
				data-entity="basket-checkout-button"
			>
				<?=Loc::getMessage('SBB_ORDER')?>
			</button>
		</div>
	</div>
</script>