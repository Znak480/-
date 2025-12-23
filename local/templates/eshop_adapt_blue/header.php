<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile($_SERVER["DOCUMENT_ROOT"]."/bitrix/templates/".SITE_TEMPLATE_ID."/header.php");
$wizTemplateId = COption::GetOptionString("main", "wizard_template_id", "eshop_adapt_horizontal", SITE_ID);
CJSCore::Init(array("fx"));
$curPage = $APPLICATION->GetCurPage(true);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=LANGUAGE_ID?>" lang="<?=LANGUAGE_ID?>">
<head>
<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();
   for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
   k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

   ym(86354987, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true
   });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/86354987" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
</head>
<body>
<div id="panel"><?$APPLICATION->ShowPanel();?></div>
<?$APPLICATION->IncludeComponent("bitrix:eshop.banner", "", array());?>
<div class="bx-wrapper" id="bx_eshop_wrap">
	<header class="bx-header" itemscope itemtype="http://schema.org/Organization">
		<div class="bx-header-section container">
			<div class="row">
				<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
					<div class="bx-logo">
						<a class="bx-logo-block hidden-xs" href="<?=SITE_DIR?>">
							<?$APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/company_logo.php"), false);?>
						</a>
						<a class="bx-logo-block hidden-lg hidden-md hidden-sm text-center" href="<?=SITE_DIR?>">
							<?$APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/company_logo_mobile.php"), false);?>
						</a>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
					<div class="bx-inc-orginfo">
						<div>
							<span class="bx-inc-orginfo-phone"><i class="fa fa-phone"></i> <?$APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/telephone.php"), false);?></span>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 hidden-sm hidden-xs">
					<div class="bx-worktime">
						<div class="bx-worktime-prop">
							<?$APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/schedule.php"), false);?>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 hidden-xs">
					<?$APPLICATION->IncludeComponent("bitrix:sale.basket.basket.line", "", array(
							"PATH_TO_BASKET" => SITE_DIR."personal/cart/",
							"PATH_TO_PERSONAL" => SITE_DIR."personal/",
							"SHOW_PERSONAL_LINK" => "N",
							"SHOW_NUM_PRODUCTS" => "Y",
							"SHOW_TOTAL_PRICE" => "Y",
							"SHOW_PRODUCTS" => "N",
							"POSITION_FIXED" =>"N",
							"SHOW_AUTHOR" => "Y",
							"PATH_TO_REGISTER" => SITE_DIR."login/",
							"PATH_TO_PROFILE" => SITE_DIR."personal/"
						),
						false,
						array()
					);?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 hidden-xs">
					<?if ($wizTemplateId == "eshop_adapt_horizontal"):?>
					<?$APPLICATION->IncludeComponent("bitrix:menu", "catalog_horizontal", array(
							"ROOT_MENU_TYPE" => "left",
							"MENU_CACHE_TYPE" => "A",
							"MENU_CACHE_TIME" => "36000000",
							"MENU_CACHE_USE_GROUPS" => "Y",
							"MENU_THEME" => "site",
							"CACHE_SELECTED_ITEMS" => "N",
							"MENU_CACHE_GET_VARS" => array(
							),
							"MAX_LEVEL" => "3",
							"CHILD_MENU_TYPE" => "left",
							"USE_EXT" => "Y",
							"DELAY" => "N",
							"ALLOW_MULTI_SELECT" => "N",
						),
						false
					);?>
					<?endif?>
				</div>
			</div>
			<?if ($curPage != SITE_DIR."index.php"):?>
			<div class="row">
				<div class="col-lg-12">
					<?$APPLICATION->IncludeComponent("bitrix:search.title", "visual", array(
							"NUM_CATEGORIES" => "1",
							"TOP_COUNT" => "5",
							"CHECK_DATES" => "N",
							"SHOW_OTHERS" => "N",
							"PAGE" => SITE_DIR."catalog/",
							"CATEGORY_0_TITLE" => GetMessage("SEARCH_GOODS") ,
							"CATEGORY_0" => array(
								0 => "iblock_catalog",
							),
							"CATEGORY_0_iblock_catalog" => array(
								0 => "all",
							),
							"CATEGORY_OTHERS_TITLE" => GetMessage("SEARCH_OTHER"),
							"SHOW_INPUT" => "Y",
							"INPUT_ID" => "title-search-input",
							"CONTAINER_ID" => "search",
							"PRICE_CODE" => array(
								0 => "BASE",
							),
							"SHOW_PREVIEW" => "Y",
							"PREVIEW_WIDTH" => "75",
							"PREVIEW_HEIGHT" => "75",
							"CONVERT_CURRENCY" => "Y"
						),
						false
					);?>
				</div>
			</div>
			<?endif?>

			<?if ($curPage != SITE_DIR."index.php"):?>
			<div class="row">
				<div class="col-lg-12">
					<?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "", array(
							"START_FROM" => "0",
							"PATH" => "",
							"SITE_ID" => "-"
						),
						false,
						Array('HIDE_ICONS' => 'Y')
					);?>
				</div>
			</div>
			<h1 class="bx-title dbg_title"><?=$APPLICATION->ShowTitle(false);?></h1>
			<?endif?>
		</div>
	</header>

	<div class="workarea">
		<div class="container bx-content-seection">
			<div class="row">
			<?$isCatalogPage = preg_match("~^".SITE_DIR."catalog/~", $curPage);?>
				<div class="bx-content <?=($isCatalogPage ? "col-xs-12" : "col-md-9 col-sm-8")?>">