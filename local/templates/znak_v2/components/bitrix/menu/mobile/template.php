<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true){
    die();
}


$menuId = $arParams['MENU_ID'] ?? "empty-mobile-menu";

?>

<?if (!empty($arResult)):?>
<aside id="<?= $menuId ?>" class="mobile-menu" aria-hidden="false">
    <div class="mobile-menu-inner">
        <button id="btn-mobile-close" class="btn btn-ghost btn-mobile-close" data-close>
           <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                <path d="M0 0h24v24H0z" fill="none" />
                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                    <path stroke-dasharray="20" d="M21 12h-17.5">
                        <animate fill="freeze" attributeName="stroke-dashoffset" dur="0.3s" values="20;0" />
                    </path>
                    <path stroke-dasharray="12" stroke-dashoffset="12" d="M3 12l7 7M3 12l7 -7">
                        <animate fill="freeze" attributeName="stroke-dashoffset" begin="0.3s" dur="0.2s" to="0" />
                    </path>
                </g>
            </svg>

        </button>
        <ul class="mobile-menu-list">
            <?foreach($arResult as $arItem):?>
            <li>
                <a href="<?=$arItem["LINK"]?>"
                    <?if($arItem["SELECTED"]):?>class="active"
                    <?endif;?>
                    <?if($arItem["PARAMS"]["target"]):?>target="
                    <?=$arItem["PARAMS"]["target"]?>"
                    <?endif;?>>
                    <?=$arItem["TEXT"]?>
                </a>
            </li>
            <?endforeach;?>
        </ul>
        <hr>
        <a href="/technic_work/" class="btn btn-ghost btn-mobile-feedback">
            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                <path d="M0 0h24v24H0z" fill="none" />
                <path fill="currentColor" d="M4 20q-.825 0-1.412-.587T2 18V6q0-.825.588-1.412T4 4h16q.825 0 1.413.588T22 6v12q0 .825-.587 1.413T20 20zm8-7L4 8v10h16V8zm0-2l8-5H4zM4 8V6v12z" />
            </svg>
            <span>Обратная связь</span>
        </a>

    </div>
</aside>


<?endif;?>