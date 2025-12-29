<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?
$bDefaultColumns = $arResult["GRID"]["DEFAULT_COLUMNS"];
$colspan = ($bDefaultColumns) ? count($arResult["GRID"]["HEADERS"]) : count($arResult["GRID"]["HEADERS"]) - 1;
$bPropsColumn = false;
$bUseDiscount = false;
$bPriceType = false;
$bShowNameWithPicture = ($bDefaultColumns) ? true : false; // flat to show name and picture column in one column
?>

<? /*$APPLICATION->IncludeComponent("bitrix:sale.basket.basket", "basket_in_order", Array(
	"ACTION_VARIABLE" => "basketAction",	// 
		"ADDITIONAL_PICT_PROP_1" => "-",	// 
		"ADDITIONAL_PICT_PROP_2" => "-",	// 
		"AUTO_CALCULATION" => "Y",	// 
		"BASKET_IMAGES_SCALING" => "adaptive",	// 
		"COLUMNS_LIST_EXT" => array(	// 
			0 => "PREVIEW_PICTURE",
			1 => "DISCOUNT",
			2 => "DELETE",
			3 => "DELAY",
			4 => "TYPE",
			5 => "SUM",
		),
		"COLUMNS_LIST_MOBILE" => array(	// 
			0 => "PREVIEW_PICTURE",
			1 => "DISCOUNT",
			2 => "DELETE",
			3 => "DELAY",
			4 => "TYPE",
			5 => "SUM",
		),
		"COMPATIBLE_MODE" => "Y",	// 
		"CORRECT_RATIO" => "Y",	// 
		"DEFERRED_REFRESH" => "N",	// 
		"DISCOUNT_PERCENT_POSITION" => "bottom-right",	// 
		"DISPLAY_MODE" => "compact",	// 
		"GIFTS_BLOCK_TITLE" => "Подарки ",	// 
		"GIFTS_CONVERT_CURRENCY" => "N",	// 
		"GIFTS_HIDE_BLOCK_TITLE" => "N",	// 
		"GIFTS_HIDE_NOT_AVAILABLE" => "N",	// 
		"GIFTS_MESS_BTN_BUY" => "Подарки",	// 
		"GIFTS_MESS_BTN_DETAIL" => "Подарки",	// 
		"GIFTS_PAGE_ELEMENT_COUNT" => "4",	// 
		"GIFTS_PLACE" => "BOTTOM",	// 
		"GIFTS_PRODUCT_PROPS_VARIABLE" => "prop",	// 
		"GIFTS_PRODUCT_QUANTITY_VARIABLE" => "quantity",	// 
		"GIFTS_SHOW_DISCOUNT_PERCENT" => "Y",	// 
		"GIFTS_SHOW_IMAGE" => "Y",	//
		"GIFTS_SHOW_NAME" => "Y",	// 
		"GIFTS_SHOW_OLD_PRICE" => "N",	// 
		"GIFTS_TEXT_LABEL_GIFT" => "Подарки",	// 
		"HIDE_COUPON" => "N",	// 
		"LABEL_PROP" => "",	// 
		"LABEL_PROP_MOBILE" => "",
		"LABEL_PROP_POSITION" => "",
		"OFFERS_PROPS" => "",	//
		"PATH_TO_ORDER" => "/personal/order/make/",	// 
		"PRICE_DISPLAY_MODE" => "Y",	// 
		"PRICE_VAT_SHOW_VALUE" => "N",	//
		"PRODUCT_BLOCKS_ORDER" => "props,sku,columns",	// 
		"QUANTITY_FLOAT" => "Y",	// 
		"SET_TITLE" => "Y",	// 
		"SHOW_DISCOUNT_PERCENT" => "Y",	// 
		"SHOW_FILTER" => "N",	//
		"SHOW_RESTORE" => "Y",	// 
		"TEMPLATE_THEME" => "blue",	// 
		"TOTAL_BLOCK_DISPLAY" => array(	//
			0 => "bottom",
		),
		"USE_DYNAMIC_SCROLL" => "Y",	// 
		"USE_ENHANCED_ECOMMERCE" => "N",	// 
		"USE_GIFTS" => "Y",	// 
		"USE_PREPAYMENT" => "N",	// 
		"USE_PRICE_ANIMATION" => "Y",	// 
		"COMPONENT_TEMPLATE" => ".default"
	),
	false
);*/ ?>


<div id="basket-root" class="bx-basket bx-blue bx-step-opacity" style="opacity: 1; padding: 0px;">


	<!-- div class="row">
		<div class="col-xs-12" style="width: 100%">
			<div class="alert alert-warning alert-dismissable" id="basket-warning" style="display: none;">
				<span class="close" data-entity="basket-items-warning-notification-close">x</span>
				<div data-entity="basket-general-warnings" style="display: none;"></div>
				<div data-entity="basket-item-warnings" style="display: none;">
					В вашей корзине <a href="javascript:void(0)" data-entity="basket-items-warning-count"></a> требует внимания.					</div>
				</div>
		</div>
	</div -->

	<div class="row" id="orderbasketcontent" style="display:none">
		<div class="col-xs-12" style="width: 100%">
			<h2>Ваша корзина</h2>

			<div class="basket-items-list-wrapper basket-items-list-wrapper-height-fixed basket-items-list-wrapper-light basket-items-list-wrapper-compact"
				 id="basket-items-list-wrapper">
				<div class="basket-items-list-container" id="basket-items-list-container" style="min-height: 347px;">
					<div class="basket-items-list-overlay" id="basket-items-list-overlay" style="display: none;"></div>
					<div class="basket-items-list" id="basket-item-list" style="min-height: 347px;">
						<div class="basket-search-not-found" id="basket-item-list-empty-result" style="display: none;">
							<div class="basket-search-not-found-icon"></div>
							<div class="basket-search-not-found-text">
								По данному запросу товаров не найдено
							</div>
						</div>
						<!-- <table class="basket-items-list-table" id="basket-item-table"></table> -->
						<div id="basket-item-table">

							<? foreach($arResult["GRID"]["ROWS"] as $k => $arData): ?>

								<? if(strlen($arData["data"]["DETAIL_PICTURE_SRC"]) > 0):
									$url = $arData["data"]["DETAIL_PICTURE_SRC"];
								elseif(strlen($arData["data"]["PREVIEW_PICTURE_SRC"]) > 0):
									$url = $arData["data"]["PREVIEW_PICTURE_SRC"];
								else:
									$url = "/img/no-photo.png";
								endif; ?>

								<div class="product-full" id="basket-item-<?=$arData['id']?>" data-entity="basket-item" data-id="<?=$arData['id']?>">
									<a href="<?=$arData['data']['DETAIL_PAGE_URL']?>" class="product-full__img" style="background-image: url(<?=$url?>);"></a>
									<div class="product-full__info">
										<a class="product-full__name" href="<?=$arData['data']['DETAIL_PAGE_URL']?>">
											<?=$arData['data']['NAME']?>
										</a>
									</div>
									<span class="product-full__price" id="basket-item-sum-price-<?=$arData['id']?>">
										<? if(($arData['data']['PRICE'] != $arData['data']['BASE_PRICE'])) { ?>
											<small style='color:#888'><s><?=$arData['data']['BASE_PRICE_FORMATED']?></s> x <?=$arData['data']['QUANTITY']?></small><br>
										<? } ?>
										<?=$arData['data']['PRICE_FORMATED']?>
										<span style="color:#666">x <?=$arData['data']['QUANTITY']?> <!-- ?=$arData['data']['MEASURE_TEXT']? --></span>
									</span>
								</div>
								<!-- ?print_r($arData)? -->
							<? endforeach; ?>


						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12" style="width: 100%" data-entity="basket-total-block">
			<div class="basket-checkout-container" data-entity="basket-checkout-aligner">
				<div class="basket-coupon-section">
					<div class="basket-coupon-block-field">
						<!-- a style="margin-top:25px;" href="javascript:" onClick="$('#orderbasketcontent').toggle()" class="btn btn_size-m btn_outline">Показать корзину</a -->

					</div>
				</div>
				<div class="basket-checkout-section">
					<div class="basket-checkout-section-inner">
						<div class="basket-checkout-block basket-checkout-block-total">
							<div class="basket-checkout-block-total-inner">
								<div class="basket-checkout-block-total-title">Итого:</div>
								<div class="basket-checkout-block-total-description">
								</div>
							</div>
						</div>

						<div class="basket-checkout-block basket-checkout-block-total-price">
							<div class="basket-checkout-block-total-price-inner">
								<? if($arResult['PRICE_WITHOUT_DISCOUNT_VALUE'] > $arResult['ORDER_TOTAL_PRICE']): ?>
									<div class="basket-coupon-block-total-price-old">
										<?=$arResult['PRICE_WITHOUT_DISCOUNT']?>
									</div>
								<? endif; ?>
								<div class="basket-coupon-block-total-price-current" data-entity="basket-total-price">
									<?=$arResult['ORDER_TOTAL_PRICE_FORMATED']?>
								</div>
								<? if($arResult['PRICE_WITHOUT_DISCOUNT_VALUE'] > $arResult['ORDER_TOTAL_PRICE']): ?>
									<div class="basket-coupon-block-total-price-difference">
										Экономия
										<span style="white-space: nowrap;"><?=$arResult['DISCOUNT_PRICE_FORMATED']?></span>
									</div>
								<? endif; ?>

							</div>
						</div>
						<div class="basket-checkout-block basket-checkout-block-btn">
							<input type="hidden" name="confirmorder" id="confirmorder" value="Y">
							<input type="hidden" name="profile_change" id="profile_change" value="N">
							<input type="hidden" name="is_ajax_post" id="is_ajax_post" value="Y">
							<div class="bx_ordercart_order_pay_center">
								<a href="javascript:void();" onclick="submitForm('Y'); return false;" class="btn submit-btn">Оформить заказ</a>
							</div>
						</div>
					</div>
					<div class="basket-checkout-section-inner cart-agree" >
						<input type="checkbox" value="Y" name="agree" data-agree-checkbox>
						<span >Принимаю условия
							<a href="/agreement/" target="_blank">Пользовательского соглашения</a>
							, и соглашаюсь с
							<a href="/personal-data/" target="_blank">Политикой
								обработки и
								использования
								персональных
								данных
							</a></span>
					</div>
				</div>

				<!-- div class="basket-coupon-alert-section">
					<div class="basket-coupon-alert-inner">
					</div>
				</div -->
			</div>
		</div>
	</div>
</div>