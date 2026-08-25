<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader;
use Bitrix\Sale\Basket;
use Bitrix\Sale\Fuser;
use Bitrix\Main\Context;

header('Content-Type: application/json');

$request = Context::getCurrent()->getRequest();

if (!Loader::includeModule('sale')) {
    echo json_encode(['success' => false, 'error' => 'Модуль sale не загружен']);
    die();
}
if (!Loader::includeModule('catalog')) {
    echo json_encode(['success' => false, 'error' => 'Модуль catalog не загружен']);
    die();
}
if (!Loader::includeModule('iblock')) {
    echo json_encode(['success' => false, 'error' => 'Модуль iblock не загружен']);
    die();
}

$action = $request->get('action') ?: 'add';
$productId = (int)$request->get('id');
$quantity = (int)$request->get('quant');
$modificator = (int)$request->get('modificator');

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
        $response = handleUpdateCart($productId, $quantity, $modificator);
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
    $basket = Basket::loadItemsForFUser(Fuser::getId(), SITE_ID);

    if ($item = $basket->getExistsItem('catalog', $productId)) {
        $item->setField('QUANTITY', $item->getQuantity() + $quantity);
    }
    else {
        $item = $basket->createItem('catalog', $productId);
        $item->setFields(array(
            'QUANTITY' => $quantity,
            'CURRENCY' => Bitrix\Currency\CurrencyManager::getBaseCurrency(),
            'LID' => Bitrix\Main\Context::getCurrent()->getSite(),
            'PRODUCT_PROVIDER_CLASS' => 'CCatalogProductProvider',
        ));
    }
    $basket->save();
    
    return [
        'success' => true,

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

function handleUpdateCart($productId, $quantity, $modif)
{
    if (!is_numeric($quantity) || $quantity < 0) {
        return ['success' => false, 'error' => 'Некорректное количество товара'];
    }

    $quantity = (int)$quantity;
    $basket = Basket::loadItemsForFUser(Fuser::getId(), SITE_ID);

    if ($item = $basket->getExistsItem('catalog', $productId)) {
        $item->setField('QUANTITY', $quantity);
    }else {
        return ['success' => false, 'error' => 'Товар не найден в корзине'];
    }

    $result = $basket->save();
    if (!$result->isSuccess()) {
        foreach ($result->getErrors() as $error) {
            error_log('[BasketSaveError] ' . $error->getMessage());
        }
        return ['success' => false, 'error' => 'Ошибка сохранения корзины'];
    }

    return ['success' => true, 'cart' => getCartData()];
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