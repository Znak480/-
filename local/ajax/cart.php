<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader;
use Bitrix\Sale\Basket;
use Bitrix\Sale\Fuser;
use Bitrix\Main\Context;

header('Content-Type: application/json');

$request = Context::getCurrent()->getRequest();

Loader::includeModule('sale');
Loader::includeModule('catalog');
Loader::includeModule('iblock');

$action = $request->get('action') ?: 'add';
$productId = (int)$request->get('id');
$quantity = (int)$request->get('quant');
if ($quantity < 1) $quantity = 1;

global $currentCity;
$priceId = $currentCity['PRICE_ID']['VALUE'] ?? 1;

switch ($action) {
    case 'add':
        $response = handleAddToCart($productId, $quantity, $priceId);
        break;
    case 'remove':
        $response = handleRemoveFromCart($productId);
        break;
    case 'update':
        $response = handleUpdateCart($productId, $quantity);
        break;
    case 'get':
        $response = handleGetCart();
        break;
    case 'clear':
        $response = handleClearCart();
        break;
    default:
        $response = ['success' => false, 'error' => 'Неизвестное действие'];
}

echo json_encode($response);
die();

function handleAddToCart($productId, $quantity, $priceId)
{
    $arTovar = CCatalogProduct::GetByIDEx($productId);
    if (!$arTovar) {
        return ['success' => false, 'error' => 'Товар не найден'];
    }
    
    $price = $arTovar["PRICES"][$priceId]["PRICE"] ?? 0;
    if (!empty($arTovar['PROPERTIES']['AKTSIYA_']['VALUE_ENUM'])) {
        $discount = (int)$arTovar['PROPERTIES']['AKTSIYA_']['VALUE_ENUM'];
        $price = $price - ($discount / 100 * $price);
    }
    
    $trans_ents = get_html_translation_table(HTML_ENTITIES);
    $trans_ents = array_flip($trans_ents);
    
    $arFields = [
        "MODULE" => "catalog",
        "PRODUCT_ID" => $productId,
        "PRICE" => $price,
        "CURRENCY" => "RUB",
        "LID" => SITE_ID,
        "NAME" => strtr($arTovar["NAME"], $trans_ents),
        "DETAIL_PAGE_URL" => $arTovar["DETAIL_PAGE_URL"],
        "QUANTITY" => $quantity,
        "DELAY" => 'N',
    ];
    
    if (!empty($arTovar['PROPERTIES']['KOD_TOVARA']['VALUE'])) {
        $arFields["PROPS"] = [[
            "NAME" => $arTovar['PROPERTIES']['KOD_TOVARA']['NAME'],
            "CODE" => "KOD_TOVARA",
            "VALUE" => $arTovar['PROPERTIES']['KOD_TOVARA']['VALUE'],
            "SORT" => 100,
        ]];
    }
    
    $cartId = CSaleBasket::Add($arFields);
    if (!$cartId) {
        $ex = $GLOBALS["APPLICATION"]->GetException();
        return [
            'success' => false,
            'error' => $ex ? $ex->GetString() : 'Ошибка добавления в корзину'
        ];
    }
    
    $cartData = getCartData();
    
    return [
        'success' => true,
        'cart_id' => $cartId,
        'quantity' => $cartData['quantity'],
        'total_price' => $cartData['total_price'],
        'total_price_formatted' => formatPrice($cartData['total_price']),
        'items' => $cartData['items'],
    ];
}

function handleRemoveFromCart($productId){
    $basket = Basket::loadItemsForFUser(Fuser::getId(), SITE_ID);
    
    $found = false;
    foreach ($basket as $item) {
        if ($item->getProductId() == $productId) {
            $item->delete();
            $found = true;
            break;
        }
    }
    
    if (!$found) {
        return ['success' => false, 'error' => 'Товар не найден в корзине'];
    }
    
    $basket->save();
    $cartData = getCartData();
    
    return [
        'success' => true,
        'quantity' => $cartData['quantity'],
        'total_price' => $cartData['total_price'],
        'total_price_formatted' => formatPrice($cartData['total_price']),
        'items' => $cartData['items'],
    ];
}

function handleUpdateCart($productId, $quantity){
    $basket = Basket::loadItemsForFUser(Fuser::getId(), SITE_ID);
    
    $found = false;
    foreach ($basket as $item) {
        if ($item->getProductId() == $productId) {
            $item->setQuantity($quantity);
            $found = true;
            break;
        }
    }
    
    if (!$found) {
        return ['success' => false, 'error' => 'Товар не найден в корзине'];
    }
    
    $basket->save();
    $cartData = getCartData();
    
    return [
        'success' => true,
        'quantity' => $cartData['quantity'],
        'total_price' => $cartData['total_price'],
        'total_price_formatted' => formatPrice($cartData['total_price']),
        'items' => $cartData['items'],
    ];
}

function handleGetCart(){
    $cartData = getCartData();
    
    return [
        'success' => true,
        'quantity' => $cartData['quantity'],
        'total_price' => $cartData['total_price'],
        'total_price_formatted' => formatPrice($cartData['total_price']),
        'items' => $cartData['items'],
    ];
}

function handleClearCart(){
    $basket = Basket::loadItemsForFUser(Fuser::getId(), SITE_ID);
    $basket->clear();
    $basket->save();
    
    return [
        'success' => true,
        'quantity' => 0,
        'total_price' => 0,
        'total_price_formatted' => '0 руб.',
        'items' => [],
    ];
}

function getCartData(){
    $basket = Basket::loadItemsForFUser(Fuser::getId(), SITE_ID);
    
    $totalQuantity = 0;
    $totalPrice = 0;
    $items = [];
    
    foreach ($basket as $item) {
        if ($item->canBuy()) {
            $quantity = $item->getQuantity();
            $price = $item->getPrice();
            $productId = $item->getProductId();
            
            $totalQuantity += $quantity;
            $totalPrice += $price * $quantity;
            
            $items[] = [
                'id' => $item->getId(),
                'product_id' => $productId,
                'name' => $item->getField('NAME'),
                'quantity' => $quantity,
                'price' => $price,
                'price_formatted' => number_format($price, 0, ',', ' ') . ' руб.',
                'total_price' => $price * $quantity,
                'total_price_formatted' => number_format($price * $quantity, 0, ',', ' ') . ' руб.',
                'url' => $item->getField('DETAIL_PAGE_URL'),
                'picture' => getProductPicture($productId),
            ];
        }
    }
    
    return [
        'quantity' => $totalQuantity,
        'total_price' => $totalPrice,
        'items' => $items,
    ];
}

function getProductPicture($productId){
    static $cache = [];
    
    if (isset($cache[$productId])) {
        return $cache[$productId];
    }
    
    $res = CIBlockElement::GetList(
        [],
        ['ID' => $productId],
        false,
        false,
        ['PREVIEW_PICTURE']
    );
    
    if ($item = $res->Fetch()) {
        if ($item['PREVIEW_PICTURE']) {
            $file = CFile::GetFileArray($item['PREVIEW_PICTURE']);
            if ($file) {
                $cache[$productId] = $file['SRC'];
                return $file['SRC'];
            }
        }
    }
    
    $cache[$productId] = '/assets/image/plug-product.jpg';
    return $cache[$productId];
}

function formatPrice($price)
{
    return number_format($price, 0, ',', ' ') . ' руб.';
}