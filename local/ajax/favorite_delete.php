<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader;
use Intensa\Favorite\ORM\FavoriteTable;
use Intensa\Favorite\Cache;
use Bitrix\Main\Context;

header('Content-Type: application/json');

$request = Context::getCurrent()->getRequest();

if (!check_bitrix_sessid()) {
    echo json_encode(['success' => false, 'error' => 'Ошибка безопасности']);
    die();
}

$elementid = (int)$request->getPost('elementId');

if($elementid < 0){
    return json_decode(['success'=> false, 'error' => 'Элемент с данным id не найден']);
}

try {
    $item = FavoriteTable::query()
        ->forCurrentSite()
        ->forCurrentUser()
        ->setSelect(['ID'])
        ->byElementId($elementId)
        ->setLimit(1)
        ->exec()
        ->fetch();

    if (!$item) {
        echo json_encode(['success' => false, 'error' => 'Not found']);
        die();
    }

    $result = FavoriteTable::delete($item['ID']);

    if ($result->isSuccess()) {
        Cache::clear();
        
        $count = FavoriteTable::query()
            ->setSelect(['ID'])
            ->forCurrentSite()
            ->forCurrentUser()
            ->exec()
            ->getSelectedRowsCount();

        echo json_encode([
            'success' => true,
            'elementId' => $elementId,
            'count' => $count,
            'status' => "N"
        ]);
    } else {
        echo json_encode(['success' => false, 'errors' => $result->getErrors()]);
    }

} catch (\Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}

die();
?>