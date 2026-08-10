<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?php if (!empty($arResult)):?>
    <?php
    $groups = [];
    $currentGroup = null;
    
    foreach ($arResult as $item):
        if (!empty($item['PARAMS']['IS_TITLE']) && $item['PARAMS']['IS_TITLE'] == 'Y'):
            $currentGroup = [
                'title' => $item['TEXT'],
                'modificator' => $item['PARAMS']['MODIFICATOR'] ?? 'default',
                'items' => []
            ];
            $groups[] = $currentGroup;
        else:
            if (!empty($groups)):
                $groups[count($groups)-1]['items'][] = $item;
            endif;
        endif;
    endforeach;
    ?>

    <?php foreach ($groups as $group): ?>
        <nav class="footer-block footer-block--<?= $group['modificator'] ?>">
            <span class="footer-block-label"><?= $group['title'] ?></span>

            <ul class="footer-block-menu">
                <?php foreach ($group['items'] as $item): ?>
                    <li class="f"><a href="<?= $item['LINK'] ?>"><?= $item['TEXT'] ?></a></li>
                <?php endforeach; ?>
            </ul>
        </nav>
    <?php endforeach; ?>

<?php endif; ?>