<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$this->setFrameMode(true);

$INPUT_ID = trim($arParams['~INPUT_ID']) ?: 'title-search-input';
$INPUT_ID = CUtil::JSEscape($INPUT_ID);

$CONTAINER_ID = trim($arParams['~CONTAINER_ID']) ?: 'title-search';
$CONTAINER_ID = CUtil::JSEscape($CONTAINER_ID);
?>

<div id="<?= $CONTAINER_ID ?>" class="header-input" role="search">
    <form action="<?= $arResult['FORM_ACTION'] ?>">
        <button type="submit" class="btn-search" aria-label="Найти">
            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                <path d="M0 0h24v24H0z" fill="none" />
                <path fill="currentColor"
                    d="m19.6 21l-6.3-6.3q-.75.6-1.725.95T9.5 16q-2.725 0-4.612-1.888T3 9.5t1.888-4.612T9.5 3t4.613 1.888T16 9.5q0 1.1-.35 2.075T14.7 13.3l6.3 6.3zM9.5 14q1.875 0 3.188-1.312T14 9.5t-1.312-3.187T9.5 5T6.313 6.313T5 9.5t1.313 3.188T9.5 14" />
            </svg>
        </button>
        <input 
            id="<?= $INPUT_ID ?>"
            type="text" 
            name="q" 
            placeholder="Поиск" 
            aria-label="Поиск товаров"
            autocomplete="off"
            value="<?= htmlspecialcharsbx($arResult['q'] ?? '') ?>"
        >
    </form>
</div>

<script>
    BX.ready(function(){
        new JCTitleSearch({
            'AJAX_PAGE': '<?= CUtil::JSEscape(POST_FORM_ACTION_URI) ?>',
            'CONTAINER_ID': '<?= $CONTAINER_ID ?>',
            'INPUT_ID': '<?= $INPUT_ID ?>',
            'MIN_QUERY_LEN': 2
        });
    });
</script>