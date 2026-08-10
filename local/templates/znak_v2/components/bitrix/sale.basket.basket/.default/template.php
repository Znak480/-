<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main;
use Bitrix\Main\Localization\Loc;

$documentRoot = Main\Application::getDocumentRoot();

$this->addExternalJs($templateFolder.'/js/action-pool.js');
$this->addExternalJs($templateFolder.'/js/filter.js');
$this->addExternalJs($templateFolder.'/js/component.js');

if (!isset($arParams['TOTAL_BLOCK_DISPLAY']) || !is_array($arParams['TOTAL_BLOCK_DISPLAY']))
{
	$arParams['TOTAL_BLOCK_DISPLAY'] = array('top');
}

Main\UI\Extension::load(['ui.mustache']);
$jsTemplates = new Main\IO\Directory($documentRoot.$templateFolder.'/js-templates');
/** @var Main\IO\File $jsTemplate */
foreach ($jsTemplates->getChildren() as $jsTemplate)
{
	include($jsTemplate->getPath());
}
?>

<?if (empty($arResult['ERROR_MESSAGE'])){?>

<? $APPLICATION->IncludeComponent(
    "bitrix:breadcrumb", 
    "znak", 
    [
        "COMPONENT_TEMPLATE" => ".default",
        "START_FROM" => "0",
        "PATH" => "",
        "SITE_ID" => "-"
    ], 
    false
);
?>
<section class="cart">
    <div class="container">
        <div class="cart-content" id="basket-root">
            <div class="cart-col">
                <div class="cart-row basket-check-all">
                    <label class="checkbox">
                        <input id="check-all" type="checkbox" name="check-all">
                        Выбрать все
                    </label>
                    <button id="delete-all" class="btn btn-error btn-ghost btn-sm">Удалить выбранные</button>
                </div>
                <div class="cart-row basket-product-list" id="basket-item-table"></div>
            </div>
            
            <div class="cart-col">
                <div class="cart-row cart-info" data-content="info" data-entity="basket-total-block"></div>
            </div>
        </div>
    </div>
</section>

<?
if (!empty($arResult['CURRENCIES']) && Main\Loader::includeModule('currency'))
{
    CJSCore::Init('currency');

    ?>
    <script>
        BX.Currency.setCurrencies(<?=CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true)?>);
    </script>
    <?
}

$signer = new \Bitrix\Main\Security\Sign\Signer;
$signedTemplate = $signer->sign($templateName, 'sale.basket.basket');
$signedParams = $signer->sign(base64_encode(serialize($arParams)), 'sale.basket.basket');
$messages = Loc::loadLanguageFile(__FILE__);
?>
<script>
    BX.message(<?=CUtil::PhpToJSObject($messages)?>);
    BX.Sale.BasketComponent.init({
        result: <?=CUtil::PhpToJSObject($arResult, false, false, true)?>,
        params: <?=CUtil::PhpToJSObject($arParams)?>,
        template: '<?=CUtil::JSEscape($signedTemplate)?>',
        signedParamsString: '<?=CUtil::JSEscape($signedParams)?>',
        siteId: '<?=CUtil::JSEscape($component->getSiteId())?>',
        siteTemplateId: '<?=CUtil::JSEscape($component->getSiteTemplateId())?>',
        templateFolder: '<?=CUtil::JSEscape($templateFolder)?>'
    });
</script>

<?}elseif ($arResult['EMPTY_BASKET']){
	include($documentRoot.$templateFolder.'/empty.php');
}
else
{
	ShowError($arResult['ERROR_MESSAGE']);
}
 ?>