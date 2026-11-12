<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

function getCardPriceData($arItem)
{
    $oldPrice = (float)$arItem['ITEM_PRICES'][0]['PRICE'];
    $discountStock = min((int)$arItem['PROPERTIES']['AKTSIYA_']['VALUE'], 100);
    $discountForCard = min((int)$arItem['PROPERTIES']['SKIDKA_PO_KARTE_']['VALUE'], 100);
    
    $discountPercent = $discountStock > 0 ? $discountStock : $discountForCard;
    
    $newPrice = $discountPercent > 0 
        ? $oldPrice * (1 - $discountPercent / 100)
        : $oldPrice;

    $discountOldLabel = 'Цена без карты';
    $discountLabel = 'Цена по карте';

    if ($discountStock > 0) {
        $discountType = 'stock';
        $discountOldLabel = 'Цена без акции';
        $discountLabel = 'Цена по акции';
    } elseif ($discountForCard > 0) {
        $discountType = 'card';  
    } else {
        $discountType = 'none';
    }
    
    return [
        'OLD_PRICE' => [
            'VALUE' => round($oldPrice, 2),
            'LABEL' =>  $discountOldLabel,
            'FORMATTED' => number_format(round($oldPrice, 2), 2, '.', ' ')
        ],
        'NEW_PRICE' => [
            'VALUE' => round($newPrice, 2),
            'LABEL' => $discountLabel,
            'FORMATTED' => number_format(round($newPrice, 2), 2, '.', ' ')
        ],
        'DISCOUNT' => [
            'PERCENT' => $discountPercent,
            'TYPE' => $discountType,
            'LABEL' => $discountPercent > 0 ? "Скидка {$discountPercent}%" : 'Без скидки'
        ],
        'SAVED' => [
            'VALUE' => round($oldPrice - $newPrice, 2),
            'FORMATTED' => number_format(round($oldPrice - $newPrice, 2), 2, '.', ' '),
            'LABEL' => 'Вы экономите'
        ]
    ];
}

?>