<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\LoaderException;
use Bitrix\Main\Data\Cache;
use Intensa\Favorite\Cache as FavoriteCache;
use Intensa\Favorite\ORM\FavoriteTable;

class FavoriteList extends CBitrixComponent
{
    public function executeComponent()
    {
        if (!$this->loadModule()) {
            return [];
        }

        $cache = Cache::createInstance();

        $cacheDir = FavoriteCache::CACHE_DIR;
        $cacheId = FavoriteCache::getItemsId();

        if (!$cacheId) {
            return [];
        }

        $elementsId = [];

        if ($cache->initCache($this->arParams['CACHE_TIME'], $cacheId, $cacheDir)) {
            $elementsId = $cache->getVars();
        }  elseif ($cache->startDataCache()) {
            $items = FavoriteTable::query()
                ->setSelect(['ID', 'ELEMENT_ID'])
                ->forCurrentSite()
                ->forCurrentUser()
                ->fetchAll();

            $elementsId = array_column($items, 'ELEMENT_ID');
            $cache->endDataCache($elementsId);
        }

        $this->includeComponentTemplate();

        return $elementsId;
    }

    public function onPrepareComponentParams($arParams)
    {
        if (empty($arParams['CACHE_TIME'])) {
            $arParams['CACHE_TIME'] = 86400;
        }
        if (empty($arParams['SHOW_CLEAR_BUTTON'])) {
            $arParams['SHOW_CLEAR_BUTTON'] = 'Y';
        }

        return $arParams;
    }

    private function loadModule()
    {
        try {
            return Loader::includeModule('intensa.favorite');
        } catch (LoaderException $e) {
            return false;
        }
    }
}