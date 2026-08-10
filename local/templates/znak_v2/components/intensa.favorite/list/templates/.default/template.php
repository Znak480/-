<?php
/**
 * @var array $arParams
 * @var array $arResult
 */

use Bitrix\Main\Localization\Loc;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
?>

<?php if ($arParams['SHOW_CLEAR_BUTTON'] === 'Y'): ?>
<a href="javascript:void(0);" class="intensa-favorite-clear js-intensa-favorite-clear">
    <?= Loc::getMessage('CLEAR_TEXT') ?>
</a>
<?php endif; ?>