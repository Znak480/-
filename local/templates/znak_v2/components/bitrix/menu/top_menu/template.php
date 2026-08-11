<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?php if (!empty($arResult)):?>
    <nav class="header-top-menu" aria-label="Верхнее меню">
        <?php foreach ($arResult as $item): ?>
            <?
                if($item["PARAMS"]["IS_MOBILE"] === "Y") continue;    
            ?>
            <a href="<?= $item['LINK'] ?>" class="header-top-menu-item"><?= $item['TEXT'] ?></a>
        <?php endforeach; ?>
    </nav>
<?php endif; ?>