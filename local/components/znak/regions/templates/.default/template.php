<?php 
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
{
    die();
}

$this->__component->SetResultCacheKeys([
    'ITEMS',
    'CURRENT_CITY_ID',
    'CURRENT_CITY',
    'JS_DATA'
]);

$currentCity = $arResult['CURRENT_CITY'];
$items = $arResult['ITEMS'];
$titleHidden = $arParams["TITLE_HIDDEN"] ?? "N";
?>

<div class="region-block">
    <?php if ($titleHidden !== 'Y'): ?>
        <h4 class="region-label">Город</h4>
    <?php endif; ?>
    <div class="region-selector" data-region-selector>
        <div class="region-active" role="button" tabindex="0">
            <span class="region-sity"><?= htmlspecialchars($currentCity['NAME'] ?? 'Выберите город') ?></span>
            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                viewBox="0 0 24 24">
                <path d="M0 0h24v24H0z" fill="none" />
                <path fill="currentColor" d="M10 17V7l5 5z" />
            </svg>
        </div>
        <ul class="region-dropdown" role="listbox">
            <?php foreach($items as $item) : ?>
                <li role="option" 
                    data-region="<?= htmlspecialchars($item['EXTERNAL_ID']) ?>" 
                    data-domain="<?= htmlspecialchars($item['PROPERTIES']['DOMAIN'])?>"
                    class="<?= $item['ACTIVE'] ? 'active' : '' ?>"
                >
                    <?= htmlspecialchars($item['NAME']) ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<script>
    window.regions = <?= CUtil::PhpToJSObject($arResult['JS_DATA']) ?>;
    window.regionItems = <?= CUtil::PhpToJSObject($arResult['ITEMS']) ?>;
</script>
