<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arResult
 * @var array $arParams
 */

$hasTitle = isset($arParams['HAS_TITLE']) ? $arParams['HAS_TITLE'] :"N";
$customId = isset($arParams["CUSTOM_ID"]) ? $arParams["CUSTOM_ID"] : "favorite_" . uniqid();
?>

<?php if (!empty($arParams['ELEMENT_ID'])): ?>
<button
    data-favorite-id = "<?= $customId ?>"
    class="js-intensa-favorite-item btn btn-icon btn-ghost btn-like"
    data-entity="favorite-item"
    data-favorite-status="N"
    data-favorite-element-id="<?= $arParams['ELEMENT_ID'] ?>"
    aria-label="<?= Loc::getMessage('IF_AREA_LABEL') ?>"
>
    <svg class="heart-icon" viewBox="0 0 24 24" width="24" height="24">
        <path
            d="M12,21.35L10.55,20.03C5.4,15.36 2,12.27 2,8.5 2,5.41 4.42,3 7.5,3c1.74,0 3.41.81 4.5,2.08C13.09,3.81 14.76,3 16.5,3 19.58,3 22,5.41 22,8.5c0,3.77-3.4,6.86-8.55,11.54L12,21.35Z" />
    </svg>

    <?if($hasTitle !== 'N'):?>
        <span class="heart-title">
            <?= Loc::getMessage('IF_AREA_LABEL') ?>
        </span>
    <? endif;?>
</button>
<?php endif; ?>