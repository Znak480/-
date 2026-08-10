<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
{
    die();
}

use Bitrix\Main\Page\Asset;

Asset::getInstance()->addCss($this->GetFolder() . "/style.css");

if (!empty($arResult['CATEGORIES']) && $arResult['CATEGORIES_ITEMS_EXISTS']):
?>
    <ul class="search-content">
        <li class="search-category-title">Результаты поиска:</li>
        <?php foreach ($arResult['CATEGORIES'] as $category_id => $arCategory):?>
            <!-- Элементы категории -->
            <?php foreach ($arCategory['ITEMS'] as $arItem):?>
                <li class="search-item <?= $category_id === 'all' ? 'search-item-all' : '' ?>">
                    <a href="<?= htmlspecialcharsbx($arItem['URL']) ?>">
                        <span class="search-item-name"><?= $arItem['NAME'] ?></span>
                        <?php if ($category_id === 'all'): ?>
                            <span class="search-item-arrow">→</span>
                        <?php endif; ?>
                    </a>
                </li>
            <?php endforeach; ?>
            
        <?php endforeach; ?>
    </ul>
    <div class="title-search-fader"></div>
<?php endif;