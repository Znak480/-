<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die(); ?>

<?if(!empty($arResult["ITEMS"])):?>
<div class="design-aq-list accordion" data-entity="accordion">
    <? foreach ($arResult['ITEMS'] as $key => &$item):?>
        <? $property = $item["PROPERTIES"]?>
        <!-- Item start -->
        <div class="accordion-item" data-entity="accordion-item" data-control="design-project">
            <button type="button "class="accordion-item-header" data-item="header">
                <span><?= $property["QUESTION"]["VALUE"] ?></span>
                <svg class="accordion-item-chevrone" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M0 0h24v24H0z" fill="none"></path>
                    <path fill="currentColor" d="M7.41 8.58L12 13.17l4.59-4.59L18 10l-6 6l-6-6z"></path>
                </svg>
            </button>
            <div class="accordion-item-body" data-item="body">
                <span>
                    <?= $property["ANSWER"]["VALUE"]?>
                </span>

                <?if(!empty($property["CTA"]["VALUE"])):?>
                    <div class="accordion-item-cta-actions">
                        <?foreach ($property['CTA']['VALUE'] as $key => $title): 
                        $link = $property['CTA']['DESCRIPTION'][$key] ?? '#'; ?>
                            <a href="<?= htmlspecialchars($link) ?>" 
                            class="btn btn-primary btn-sm"
                            target="_blank">
                                <?= htmlspecialchars($title) ?>
                            </a>
                        <?endforeach; ?>
                    </div>
                <?endif;?>
            </div>
        </div>
        <!-- Item end -->
    <?endforeach;?>
</div>
<?else:?>
    <div class="empty-state">
        <div class="empty-state-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="12"></line>
                <line x1="12" y1="16" x2="12.01" y2="16"></line>
            </svg>
        </div>
        <h3 class="empty-state-title">Вопросы скоро появятся</h3>
        <p class="empty-state-description">Мы добавляем новые вопросы и ответы. <br> Загляните позже!</p>
    </div>
<?endif;?>