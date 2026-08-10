<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<aside class="catalog-filter-sidebar">
	<div class="catalog-filter-sidebar-wrapper smartfilter" >
		<div class="catalog-filter-header">
			<h3 class="filter-title">Фильтры</h3>
			<button class="btn btn-ghost btn-icon filter-close" aria-label="Закрыть фильтры" data-close>
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
					viewBox="0 0 24 24">
					<path d="M0 0h24v24H0z" fill="none" />
					<path fill="currentColor"
						d="M6.4 19L5 17.6l5.6-5.6L5 6.4L6.4 5l5.6 5.6L17.6 5L19 6.4L13.4 12l5.6 5.6l-1.4 1.4l-5.6-5.6z" />
				</svg>
			</button>
		</div>
		<form class="smartfilter"action="<?echo $arResult["FORM_ACTION"]?>" method="get" name="<?echo $arResult["FILTER_NAME"]."_form"?>">
			<div class="catalog-filter">
				<?foreach($arResult["ITEMS"] as $key=>$arItem): ?>
					<?
					$isPrice = isset($arItem["PRICE"]);
					$isExpanded = $arItem["DISPLAY_EXPANDED"] == "Y";
					$key = $arItem["ENCODED_ID"];
					?>
					<div class="filter-group <?= !$isPrice ? "filter-accordion" : "" ?>">
						<?if(!$isPrice):?>
						<button class="filter-group-header" type="button">
							<h4 class="filter-group-title"><?= $arItem["NAME"] ?></h4>
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
								viewBox="0 0 24 24">
								<path d="M0 0h24v24H0z" fill="none" />
								<path fill="currentColor"
									d="M7.41 8.58L12 13.17l4.59-4.59L18 10l-6 6l-6-6z" />
							</svg>
						</button>
						<? else: ?>
							<h4 class="filter-group-title"><?= $arItem["NAME"] ?></h4>
						<? endif;?>
						<?if($isPrice):?>
							<div class="filter-price-range">
								<div class="filter-price-inputs">
									<input  
										type="text"
										name="<?= $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
										id="<?= $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
										value="<?= $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
										size="5"
										onkeyup="smartFilter.keyup(this)"
										placeholder="от <?= $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
									>
									<input 
										type="text" 
										name="<?= $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
										id="<?= $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
										value="<?= $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
										size="5"
										onkeyup="smartFilter.keyup(this)"
										placeholder="до <?= $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
									>
								</div>
							</div>
							<?
							$arJsParams = array(
								"leftSlider" => 'left_slider_'.$key,
								"rightSlider" => 'right_slider_'.$key,
								"tracker" => "drag_tracker_".$key,
								"trackerWrap" => "drag_track_".$key,
								"minInputId" => $arItem["VALUES"]["MIN"]["CONTROL_ID"],
								"maxInputId" => $arItem["VALUES"]["MAX"]["CONTROL_ID"],
								"minPrice" => $arItem["VALUES"]["MIN"]["VALUE"],
								"maxPrice" => $arItem["VALUES"]["MAX"]["VALUE"],
								"curMinPrice" => $arItem["VALUES"]["MIN"]["HTML_VALUE"],
								"curMaxPrice" => $arItem["VALUES"]["MAX"]["HTML_VALUE"],
								"fltMinPrice" => intval($arItem["VALUES"]["MIN"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MIN"]["FILTERED_VALUE"] : $arItem["VALUES"]["MIN"]["VALUE"] ,
								"fltMaxPrice" => intval($arItem["VALUES"]["MAX"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MAX"]["FILTERED_VALUE"] : $arItem["VALUES"]["MAX"]["VALUE"],
								"precision" => 2,
								"colorUnavailableActive" => 'colorUnavailableActive_'.$key,
								"colorAvailableActive" => 'colorAvailableActive_'.$key,
								"colorAvailableInactive" => 'colorAvailableInactive_'.$key,
							);
							?>
							<script type="text/javascript">
								BX.ready(function(){
									window['trackBar<?=$key?>'] = new BX.Iblock.SmartFilter(<?=CUtil::PhpToJSObject($arJsParams)?>);
								});
							</script>
						<?else:?>
							<div class="filter-group-body">
								<div class="filter-checkbox-list">
									<?foreach($arItem["VALUES"] as $val => $ar):?>
										<label 
											data-role="label_<?=$ar["CONTROL_ID"]?>" 
											class="filter-checkbox <?= $ar["DISABLED"] ? 'disabled': '' ?>" 
											for="<? echo $ar["CONTROL_ID"] ?>"
										>
											<input
												type="checkbox"
												value="<? echo $ar["HTML_VALUE"] ?>"
												name="<? echo $ar["CONTROL_NAME"] ?>"
												id="<? echo $ar["CONTROL_ID"] ?>"
												<? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
												onclick="smartFilter.click(this)"
												<?=$ar["DISABLED"] ? 'disabled': '' ?>
											> <?=$ar["VALUE"];?>
										</label>
									<?endforeach;?>
									<div class="filter-divider"></div>
									<button class="btn btn-ghost btn-sm btn-show-more">
										<span class="button-text">Показать еще</span>
									</button>
								</div>
							</div>	
						<?endif;?>
					</div>
				<?endforeach;?>
			</div>
			<div class="filter-actions">
				<input
					class="btn btn-primary btn-md btn-filter-apply"
					type="submit"
					id="set_filter"
					name="set_filter"
					value="<?=GetMessage("CT_BCSF_SET_FILTER")?>"
				/>
				<input
					class="btn btn-md btn-filter-reset"
					type="submit"
					id="del_filter"
					name="del_filter"
					value="<?=GetMessage("CT_BCSF_DEL_FILTER")?>"
				/>
			</div>
		</form>
	</div>
</aside>
<script>
	var smartFilter = new JCSmartFilter('<?echo CUtil::JSEscape($arResult["FORM_ACTION"])?>', '<?=CUtil::JSEscape($arParams["FILTER_VIEW_MODE"])?>', <?=CUtil::PhpToJSObject($arResult["JS_FILTER_PARAMS"])?>);
</script>