<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true){
	die();
}

/**
 * @var array $arParams
 * @var array $arResult
 * @var string $templateFolder
 * @var string $templateName
 * @var CMain $APPLICATION
 * @var CBitrixBasketComponent $component
 * @var CBitrixComponentTemplate $this
 */

global $APPLICATION;

use Bitrix\Main;
use Bitrix\Main\Localization\Loc;

$documentRoot = Main\Application::getDocumentRoot();
$this->addExternalJs($templateFolder.'/js/component.js');

Main\UI\Extension::load(['ui.mustache']);
$jsTemplates = new Main\IO\Directory($documentRoot.$templateFolder.'/js-templates');
/** @var Main\IO\File $jsTemplate */
foreach ($jsTemplates->getChildren() as $jsTemplate)
{
	include($jsTemplate->getPath());
}

$messages = Loc::loadLanguageFile(__FILE__);
?>


<?include($documentRoot.$templateFolder.'/empty.php'); ?>


<div data-page="cart">
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
            <div class="cart-content cart-content--empty" style="display: none" data-entity="basket-root-empty"></div>

            <div class="cart-content" data-entity="basket-root">
                <!-- Колонка основной информации -->
                <div class="cart-col">
                    <div class="cart-row basket-check-all">
                        <label class="checkbox">
                            <input id="check-all" type="checkbox" name="check-all" data-entity="select-all">
                            Выбрать все
                        </label>
                        <button id="delete-all" class="btn btn-error btn-ghost btn-sm" data-entity="delete-selected"><?= Loc::getMessage("DELETE_SELECTED_EMPTY")?></button>
                    </div>
                    <div class="cart-row" data-entity="basket-items"></div>
                </div>

                <!-- Колонка общей суммы -->
                <div class="cart-col">
                    <div class="cart-row basket-check-all">
                         <label class="checkbox">
                            <input type="checkbox" id="have-card" name="have_card" value="1" data-entity="have-card-checkbox"  <?= ($_SESSION['USE_CARD'] ?? 'N') === 'Y' ? 'checked' : '' ?>>
                            Есть карта
                         </label>
                    </div>
                    <div class="cart-row cart-info" data-entity="basket-total"></div>
                </div>
            </div>

        </div>
    </section>
</div>

<script>
    BX.message(<?= \Bitrix\Main\Web\Json::encode($messages,  JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>);

    const basket = new ZnakBasketComponent({
        result: <?= Bitrix\Main\Web\Json::encode(
            $arResult,
            JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT
        ) ?>,
        params: <?= Bitrix\Main\Web\Json::encode(
            $arParams,
            JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT
        ) ?>,
        ajaxUrl: <?= \Bitrix\Main\Web\Json::encode(strtok($_SERVER['REQUEST_URI'], '?')) ?>,
        root: "basket-root",
        empty: "basket-root-empty"
    });
    
    basket.init();
</script>
