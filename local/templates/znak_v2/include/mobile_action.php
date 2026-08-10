<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();


$favoriteItems = $_SESSION['FAVORITE_ITEMS'] ?? [];
$favoriteCount = count($favoriteItems);


global $USER;
$isAuth = $USER->IsAuthorized();
$userName = $isAuth ? ($USER->GetFirstName() ?: 'Кабинет') : 'Вход';
$userLink = $isAuth ? '/personal/' : '/auth/';
?>

<nav>
    <a href="/" class="btn btn-ghost btn-action" aria-label="Главная">
        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
            <path d="M0 0h24v24H0z" fill="none" />
            <path fill="currentColor" d="M4 21V9l8-6l8 6v12h-6v-7h-4v7z" />
        </svg>
        <span>Главная</span>
    </a>
    <?php 
    $APPLICATION->IncludeComponent(
        "intensa.favorite:counter",
        "",
        [
            'PAGE_LINK' => SITE_DIR."personal/favorite/"
        ],
        false
    );
    ?>
    <?php
    $APPLICATION->IncludeComponent(
        "bitrix:sale.basket.basket.small",
        "header_basket", 
        [   
            "PATH_TO_ORDER" => "/cart/order/",
            "PATH_TO_BASKET" => "/cart/",
            "PATH_TO_PERSONAL" => "/personal/",
            "SHOW_PRICE" => "Y",
        ],
        false
    );
    ?>
    <a href="<?= $userLink ?>" class="btn btn-ghost btn-action" aria-label="<?= $userName ?>">
        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
            <path d="M0 0h24v24H0z" fill="none" />
            <g fill="none" fill-rule="evenodd">
                <path
                    d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
                <path fill="currentColor"
                    d="M16 14a5 5 0 0 1 4.995 4.783L21 19v1a2 2 0 0 1-1.85 1.995L19 22H5a2 2 0 0 1-1.995-1.85L3 20v-1a5 5 0 0 1 4.783-4.995L8 14zm0 2H8a3 3 0 0 0-2.995 2.824L5 19v1h14v-1a3 3 0 0 0-2.824-2.995zM12 2a5 5 0 1 1 0 10a5 5 0 0 1 0-10m0 2a3 3 0 1 0 0 6a3 3 0 0 0 0-6" />
            </g>
        </svg>
        <span><?= $userName ?></span>
    </a>
</nav>