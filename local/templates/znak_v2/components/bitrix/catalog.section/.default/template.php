<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$bxajaxid = '';
if (isset($component) && isset($component->__template)) {
    $bxajaxid = CAjax::GetComponentID(
        $component->__name, 
        $component->__template->__name, 
        $component->arParams['AJAX_OPTION_ADDITIONAL']
    );
}

$isAjax = (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest');

if ($isAjax) {
    while (ob_get_level()) {
        ob_end_clean();
    }
}

if ($isAjax) {
    if (!empty($arResult["ITEMS"])) {
        foreach ($arResult["ITEMS"] as $arItem) {
            $APPLICATION->IncludeFile(
                "/local/include/card-product.php",
                ["arItem" => $arItem],
                ["MODE" => "PHP"]
            );
        }
    }

    $APPLICATION->IncludeComponent(
        "bitrix:system.pagenavigation",
        "modern",
        [
            "NAV_RESULT" => $arResult["NAV_RESULT"],
            "NAV_PARAMS" => $arResult["NAV_PARAMS"],
            "PAGER_PARAMS" => $arParams["PAGER_PARAMS_NAME"],
        ],
        $component
    );
    return;
}
?>

<div class="catalog-wrapper">
    <div class="catalog-products-list" id="products-list-<?=$bxajaxid?>">
        <?php
        if (!empty($arResult["ITEMS"])) {
            foreach ($arResult["ITEMS"] as $arItem) {
                $APPLICATION->IncludeFile(
                    "/local/include/card-product.php",
                    ["arItem" => $arItem],
                    ["MODE" => "PHP"]
                );
            }
        } else {
            echo '<div class="catalog-empty">Товары не найдены</div>';
        }
        ?>
    </div>

    <div class="catalog-pagination-wrapper" id="catalog-pagination-<?=$bxajaxid?>" <?= $isAjax ? 'data-ajax="Y"' : '' ?>>
        <? if (isset($arResult["NAV_RESULT"]) && is_object($arResult["NAV_RESULT"])): ?>
            <? if ($arResult["NAV_RESULT"]->nEndPage > 1 && 
                $arResult["NAV_RESULT"]->NavPageNomer < $arResult["NAV_RESULT"]->nEndPage): ?>
            <?
            $totalItems = (int)$arResult["NAV_RESULT"]->NavRecordCount;
            $currentPage = (int)$arResult["NAV_RESULT"]->NavPageNomer;
            $pageSize = (int)$arResult["NAV_RESULT"]->NavPageSize;
            $shownItems = $currentPage * $pageSize;
            $remainingItems = $totalItems - $shownItems;
            
            if ($remainingItems < 0) $remainingItems = 0;
            ?>
                <button id="btn_<?=$bxajaxid?>" 
                    class="btn btn-primary btn-sm btn-load-more" 
                    data-ajax-id="<?=$bxajaxid?>" 
                    data-show-more="<?=$arResult["NAV_RESULT"]->NavNum?>" 
                    data-next-page="<?=($arResult["NAV_RESULT"]->NavPageNomer + 1)?>" 
                    data-max-page="<?=$arResult["NAV_RESULT"]->NavPageCount?>"
                    data-current-page="<?=$arResult["NAV_RESULT"]->NavPageNomer?>"
                    data-total-items-count="<?=(int)$totalItems?>"
                >
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" class="load-more-icon">
                        <path d="M12 4V20M4 12H20" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                    </svg>
                    <span class="load-more-title">Показать еще</span>
                    <span class="load-more-count">(<?= $remainingItems ?>)</span>
                </button>

                <span class="pagination-divider">или</span>
            <? endif;?>
        <? endif;?>
        <? $APPLICATION->IncludeComponent(
            "bitrix:system.pagenavigation",
            "modern",
            [
                "NAV_RESULT" => $arResult["NAV_RESULT"],
                "NAV_PARAMS" => $arResult["NAV_PARAMS"],
                "PAGER_PARAMS" => $arParams["PAGER_PARAMS_NAME"],
            ],
            $component
        );
        ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('[data-show-more]');
    const divider = document.querySelector('.pagination-divider');
    let spinner = `<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
        <path d="M0 0h24v24H0z" fill="none" />
        <g stroke="currentColor">
            <circle cx="12" cy="12" r="9.5" fill="none" stroke-linecap="round" stroke-width="3">
                <animate attributeName="stroke-dasharray" calcMode="spline" dur="1.5s" keySplines="0.42,0,0.58,1;0.42,0,0.58,1;0.42,0,0.58,1" keyTimes="0;0.475;0.95;1" repeatCount="indefinite" values="0 150;42 150;42 150;42 150" />
                <animate attributeName="stroke-dashoffset" calcMode="spline" dur="1.5s" keySplines="0.42,0,0.58,1;0.42,0,0.58,1;0.42,0,0.58,1" keyTimes="0;0.475;0.95;1" repeatCount="indefinite" values="0;-16;-59;-59" />
            </circle>
            <animateTransform attributeName="transform" dur="2s" repeatCount="indefinite" type="rotate" values="0 12 12;360 12 12" />
        </g>
    </svg>
    `;
    buttons.forEach(async function(btn) {
        btn.addEventListener('click', async function(e) {
            e.preventDefault();
            e.stopPropagation();

            const btn = this;
            
            if (btn.classList.contains('loading')) {
                return;
            }
            
            const page = parseInt(btn.dataset.nextPage);
            const id = btn.dataset.showMore;
            const bx_ajax_id = btn.dataset.ajaxId;
            const containerId = 'products-list-' + bx_ajax_id;
            const maxPage = parseInt(btn.dataset.maxPage);
            const totalItemsCount = btn.dataset.totalItemsCount;
            
            // Сохраняем оригинальный HTML для восстановления
            const originalHtml = btn.innerHTML;
            
            btn.classList.add('loading');
            btn.innerHTML = spinner;
            
            try {
                const url = new URL(window.location.href);
                url.searchParams.set('PAGEN_' + id, page);
                
                const controller = new AbortController();
                const timeoutId = setTimeout(() => controller.abort(), 30000);
                
                const response = await fetch(url.toString(), {
                    method: 'GET',
                    signal: controller.signal,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                
                clearTimeout(timeoutId);
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const html = await response.text();
                
                if (!html || html.trim().length === 0) {
                    console.warn('Пустой ответ');
                    btn.textContent = 'Ошибка';
                    btn.classList.add('error');
                    return;
                }
                
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = html;
                
                const cards = tempDiv.querySelectorAll('.product-card');
            
                const pagination = tempDiv.querySelector('.pagination');
                
                if (cards.length === 0) {
                    btn.textContent = 'Товары не найдены';
                    btn.classList.add('error');
                    setTimeout(() => {
                        btn.classList.remove('error');
                        btn.innerHTML = originalHtml;
                    }, 3000);
                    return;
                }
                
                const paginationWrapper = document.getElementById('catalog-pagination-' + bx_ajax_id);
                if (paginationWrapper) {
                    const oldPagination = paginationWrapper.querySelector('.pagination');
                    if (oldPagination && pagination) {
                        oldPagination.remove();
                        paginationWrapper.appendChild(pagination);
                    } else if (pagination) {
                        paginationWrapper.appendChild(pagination);
                    }
                }
                
                const container = document.getElementById(containerId);
                if (container) {
                    // Используем DocumentFragment для оптимизации
                    const fragment = document.createDocumentFragment();
                    cards.forEach(function(card) {
                        fragment.appendChild(card.cloneNode(true));
                    });
                    container.appendChild(fragment);
                    
                    const newPage = page + 1;
                    btn.dataset.nextPage = newPage;
                    btn.dataset.currentPage = page;

                    const totalCards = container.querySelectorAll('.product-card').length; 
                    const remainsItemsCount = totalItemsCount - totalCards;
                    
                    if (page >= maxPage) {
                        btn.style.display = 'none';
                        divider.style.display = 'none';
                    } else {
                        btn.innerHTML = originalHtml;
                        btn.querySelector(".load-more-count").innerHTML = `(${remainsItemsCount})`;
                    }
                } else {
                    console.error('Контейнер не найден:', containerId);
                    btn.textContent = 'Ошибка';
                    btn.classList.add('error');
                }

                 if (typeof synchronizeItemsWithBasket === 'function') {
                    await synchronizeItemsWithBasket();
                }
            } catch (error) {
                if (error.name === 'AbortError') {
                    console.error('Таймаут запроса');
                    btn.textContent = 'Ошибка, попробуйте снова';
                } else {
                    console.error('Ошибка:', error);
                    btn.textContent = 'Ошибка, попробуйте снова';
                }
                btn.classList.add('error');
                
                setTimeout(() => {
                    btn.classList.remove('error');
                    btn.innerHTML = originalHtml;
                }, 3000);
            } finally {
                btn.classList.remove('loading');
            }
        });
    });
});
</script>