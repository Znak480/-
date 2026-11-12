<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;
use Bitrix\Sale;
use Bitrix\Sale\Basket;
use Bitrix\Sale\DiscountCouponsManager;
use Bitrix\Sale\Fuser;
use Bitrix\Sale\PriceMaths;
use Bitrix\Main\Context;

use Znak\Importer\Log\FileLogger;
use Znak\Importer\Log\LogLevel;

/* 
 * Кастомная корзина с выбором товара и применением скидки,
 * заранее указанной в свойствах товара
 */

class ZnakBasketComponent extends CBitrixComponent
{
    private const SELECT_PROP = "SELECTED";
    private const DEFAULT_PATH_TO_ORDER = "/cart/order";

    private const IMAGE_SIZE_STANDARD = 110;

    private const BASE_CURRENCY = "RUB";

    private string $siteId;
    private int $fuserId;
    private Basket $basket;

    /** @var array<int, array> Кэш данных товаров: ID → [props, picture, ...] */
    private array $productsData = [];

    private FileLogger $logger;

    private ProductBadgeManager $badgeManager;


    public function __construct($component = null)
    {
        $this->logger = new FileLogger(
            logDir: $_SERVER['DOCUMENT_ROOT'],
            minLevel: LogLevel::Info,
            echo: PHP_SAPI === 'cli',
            prefix: "basket-import ",
        );
        parent::__construct($component);

        $this->badgeManager = ProductBadgeManager::getInstance();
        $this->badgeManager->addRule([
            'property' => 'SKIDKA_PO_KARTE_',
            'priority' => 90,
            'callback' => function ($value) {
                return [
                    'class' => 'badge--hit',
                    'text' => 'Cкидка по карте',
                    'type' => 'card'
                ];
            }
        ]);
    }

    public function executeComponent()
    {
        $this->init();

        $request = Context::getCurrent()->getRequest();
        $isAjax = $request->isAjaxRequest()
            || (strtolower((string)($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '')) === 'xmlhttprequest')
            || $request->getPost('action') !== null;

        if ($isAjax) {
            $this->handleAjax();
        }

        $this->fillProductsProperties();
        $this->recalculatePrices();

        $this->arResult["TOTAL_DATA"] = $this->buildResultTotal();
        $this->arResult["ITEMS"] = $this->buildResult();
        $this->arResult["SELECTED_ALL"] = $this->isAllSelected();

        $this->arParams['PATH_TO_ORDER'] = trim((string)$this->arParams['PATH_TO_ORDER']);
		if (empty($this->arParams['PATH_TO_ORDER']))
		{
			$this->arParams['PATH_TO_ORDER'] = self::DEFAULT_PATH_TO_ORDER;
		}

        $this->includeComponentTemplate();
    }

    private function isAllSelected(): bool
    {
        $hasAny = false;
        foreach ($this->basket as $item) {
            $hasAny = true;
            if (!$this->isItemSelected($item)) {
                return false;
            }
        }
        return $hasAny;
    }

    private function buildResultTotal()
    {
        $count = 0;
        $total = 0;
        $baseTotal = 0;
        $discountTotal = 0;

        $basketItems = $this->basket->getBasketItems();

        $currency = self::BASE_CURRENCY;

        foreach ($basketItems as $raw) {
            if (!$this->isItemSelected($raw)) {
                continue;
            }
            $quantity = $raw->getQuantity();

            $total += $raw->getPrice() * $quantity;
            $baseTotal += $raw->getBasePrice() * $quantity;
            $discountTotal += $raw->getField('DISCOUNT_PRICE') * $quantity;

            $currency = $raw->getCurrency() ?: $currency;
            $count++;
        }

        $formatedTotal = CCurrencyLang::CurrencyFormat($total, $currency, true);
        $formatedBaseTotal = CCurrencyLang::CurrencyFormat($baseTotal, $currency, true);
        $formatedDiscountTotal = CCurrencyLang::CurrencyFormat($discountTotal, $currency, true);

        return [
            "BASE_TOTAL_PRICE" => $baseTotal,
            "FORMATED_BASE_TOTAL_PRICE" => $formatedBaseTotal,

            "TOTAL_PRICE" => $total,
            "FORMATED_TOTAL_PRICE" => $formatedTotal,

            "DISCOUNT_TOTAL_PRICE" => $discountTotal,
            "FORMATED_DISCOUNT_TOTAL_PRICE" => $formatedDiscountTotal,

            "TOTAL_COUNT" => $count
        ];
    }

    private function fillProductsProperties(): void
    {
        $productIds = [];
        foreach ($this->basket as $item) {
            $productIds[] = $item->getProductId();
        }

        if (empty($productIds)) {
            return;
        }

        $res = \CIBlockElement::GetList(
            [],
            ['=ID' => $productIds, 'IBLOCK_ID' => 19],
            false,
            false,
            [
                'ID',
                'PREVIEW_PICTURE',
                'DETAIL_PICTURE',
                'DETAIL_PAGE_URL',
                'PROPERTY_AKTSIYA_',
                'PROPERTY_SKIDKA_PO_KARTE_',
            ]
        );

        while ($ob = $res->GetNextElement()) {
            $fields = $ob->GetFields();
            $props  = $ob->GetProperties();
            $badges = $this->badgeManager->getBadges([
                'ID'         => (int)$fields['ID'],
                'PROPERTIES' => $props,
            ]);
            $this->productsData[$fields['ID']] = [
                'PREVIEW_PICTURE' => (int)$fields['PREVIEW_PICTURE'],
                'DETAIL_PICTURE'  => (int)$fields['DETAIL_PICTURE'],
                'DETAIL_PAGE_URL' => $fields['DETAIL_PAGE_URL'],
                'AKTSIYA'         => (int)($props['AKTSIYA_']['VALUE'] ?? 0),
                'SKIDKA'          => (int)($props['SKIDKA_PO_KARTE_']['VALUE'] ?? 0),
                'BADGES'          => $badges,
            ];
        }
    }

    private function buildResult()
    {
        $items = [];
        foreach ($this->basket as $raw) {
            $productId = $raw->getProductId();
            $data = $this->productsData[$productId] ?? [];

            $pictureId  = $data['PREVIEW_PICTURE'] ?? 0;
            $pictureSrc = '';

            if ($pictureId > 0) {
                $picture = \CFile::ResizeImageGet(
                    $pictureId,
                    ['width' => self::IMAGE_SIZE_STANDARD, 'height' => self::IMAGE_SIZE_STANDARD],
                    BX_RESIZE_IMAGE_PROPORTIONAL,
                    true
                );
                $pictureSrc = $picture['src'] ?? '';
            }

            $quantity =  $raw->getQuantity();
            $price = $raw->getPrice();
            $basePrice = $raw->getBasePrice();
            $discountPrice = $raw->getField('DISCOUNT_PRICE');

            $discountType = $this->getItemProperty($raw, 'DISCOUNT_TYPE')['VALUE'] ?? null;
            if ($discountType === null || $discountType === '') {
                $discountType = null;
            }

            $badges = isset($discountType) ? $data["BADGES"] : null;

            $item = [
                'ID'             => $raw->getId(),
                'PRODUCT_ID'     => $productId,
                'SORT'           => $raw->getField("SORT"),
                "NAME"           => $raw->getField("NAME"),
                "QUANTITY"       => $quantity,
                "CURRENCY"       => $raw->getCurrency(),
                "DELAY"          => $raw->getField("DELAY"),
                "URL"            => $raw->getField('DETAIL_PAGE_URL'),
                'SELECTED'       => $this->isItemSelected($raw),
                "PICTURE"        =>  [
                    "ID"  => $pictureId,
                    "SRC" => $pictureSrc,
                ],
                "MEASURE"       => [
                    "CODE" => $raw->getField('MEASURE_CODE'),
                    "NAME" => $raw->getField('MEASURE_NAME')
                ],
                "PRICE"          => $price,
                "BASE_PRICE"     => $basePrice,
                "DISCOUNT_PRICE" => $discountPrice,
                "SUM_PRICE"      => $quantity * $price,
                "SUM_BASE_PRICE" => $quantity * $basePrice,
                "SUM_DISCOUNT_PRICE" => $quantity * $discountPrice,

                "DISCOUNT_TYPE" =>  $discountType,
                "BADGES" =>  $badges
            ];

            $item['SHOW_OLD_PRICE'] = (float)$basePrice > 0
                && (float)$price < (float)$basePrice;

            $this->formatedPrice($item);
            $items[] = $item;
        }

        return $items;
    }

    private function formatedPrice(array &$item): void
    {
        $item["PRICE_FORMATED"] = CCurrencyLang::CurrencyFormat($item['PRICE'], $item['CURRENCY'], true);
        $item["BASE_PRICE_FORMATED"] = CCurrencyLang::CurrencyFormat($item['BASE_PRICE'], $item['CURRENCY'], true);
        $item["DISCOUNT_PRICE_FORMATED"] = CCurrencyLang::CurrencyFormat($item['DISCOUNT_PRICE'], $item['CURRENCY'], true);
        $item["SUM_PRICE_FORMATED"] = CCurrencyLang::CurrencyFormat($item['SUM_PRICE'], $item['CURRENCY'], true);
        $item["SUM_BASE_PRICE_FORMATED"] = CCurrencyLang::CurrencyFormat($item['SUM_BASE_PRICE'], $item['CURRENCY'], true);
        $item["SUM_DISCOUNT_PRICE_FORMATED"] = CCurrencyLang::CurrencyFormat($item['SUM_DISCOUNT_PRICE'], $item['CURRENCY'], true);
    }

    private function getItemProperty(\Bitrix\Sale\BasketItem $item, string $code): array
    {
        $collection = $item->getPropertyCollection();
        foreach ($collection as $prop) {
            if ($prop->getField("CODE") === $code) {
                return [
                    "CODE"  => $prop->getField("CODE"),
                    "VALUE" => $prop->getField("VALUE")
                ];
            }
        }
        return [];
    }

    private function isItemSelected(\Bitrix\Sale\BasketItem $item)
    {
        $property = $this->getItemProperty($item, self::SELECT_PROP);

        if (empty($property)) {
            return false;
        }

        return $property["VALUE"] === "Y";
    }

    private function init()
    {
        \Bitrix\Main\Loader::includeModule('sale');
        \Bitrix\Main\Loader::includeModule('catalog');

        $this->fuserId = (int)Fuser::getId();
        $this->siteId  = SITE_ID;
        $this->basket  = Basket::loadItemsForFUser($this->fuserId, $this->siteId);
    }

    private function getDiscountPercent(int $productId, string $mode): int
    {
        $data = $this->productsData[$productId] ?? null;
        if (!$data) {
            return 0;
        }

        return match ($mode) {
            'card'    => (int) $data['SKIDKA'],
            'aktsiya' => (int) $data['AKTSIYA'],
            default   => 0,
        };
    }

    private function setItemProperty(\Bitrix\Sale\BasketItem $item, string $code, string $value, string $name): void
    {
        $propertyCollection = $item->getPropertyCollection();

        foreach ($propertyCollection as $prop) {
            if ($prop->getField("CODE") === $code) {
                if ((string)$prop->getField('VALUE') !== $value) {
                    $prop->setField('VALUE', $value);
                }
                return;
            }
        }

        $prop = $propertyCollection->createItem();
        $prop->setFields(['NAME' => $name, 'CODE' => $code, 'VALUE' => $value]);
    }

    private function setItemSelected(\Bitrix\Sale\BasketItem $item, bool $value): void
    {
        $this->logger->info($item->getProductId() . " " . ($value ? "Y" : "N"));
        $this->setItemProperty($item,  self::SELECT_PROP, $value ? "Y" : "N", "Выбран товар");
    }

    private function recalculatePrices(): void
    {
        $useCard = ($_SESSION['USE_CARD'] ?? 'N') === 'Y';
        $this->logger->info('recalculate: USE_CARD=' . ($useCard ? 'Y' : 'N'));

        $changed = false;

        foreach ($this->basket as $item) {
            $basePrice = $item->getBasePrice();
            if ($basePrice <= 0) {
                continue;
            }

            $primary     = $useCard ? 'card' : 'aktsiya';
            $percent     = $this->getDiscountPercent($item->getProductId(), $primary);
            $appliedMode = $percent > 0 ? $primary : null;

            if ($appliedMode === null && $useCard) {
                $percent = $this->getDiscountPercent($item->getProductId(), 'aktsiya');
                if ($percent > 0) {
                    $appliedMode = 'aktsiya';
                }
            }

            $currentType = $this->getItemProperty($item, 'DISCOUNT_TYPE')["VALUE"];

            if ($appliedMode === null) {
                if ($item->getField('CUSTOM_PRICE') === 'Y') {
                    $item->setField('PRICE',          $basePrice);
                    $item->setField('DISCOUNT_PRICE', 0);
                    $item->setField('CUSTOM_PRICE',   'N');
                    $changed = true;
                }
                if ($currentType !== null) {
                    $this->setItemProperty($item, 'DISCOUNT_TYPE', '', 'Тип скидки');
                    $changed = true;
                }
                continue;
            }

            $newPrice = PriceMaths::roundPrecision($basePrice * (1 - $percent / 100));

            if ((float)$item->getPrice() !== (float)$newPrice) {
                $item->setField('PRICE',          $newPrice);
                $item->setField('BASE_PRICE',     $basePrice);
                $item->setField('DISCOUNT_PRICE', $basePrice - $newPrice);
                $item->setField('CUSTOM_PRICE',   'Y');
                $changed = true;
            }

            if ($currentType !== $appliedMode) {
                $this->setItemProperty($item, 'DISCOUNT_TYPE', $appliedMode, 'Тип скидки');
                $changed = true;
            }
        }

        if ($changed) {
            $res = $this->basket->save();
            if (!$res->isSuccess()) {
                $this->logger->error(
                    'basket save failed: ' . implode('; ', $res->getErrorMessages())
                );
            }
        }
    }

    private function handleAjax(): void
    {
        global $APPLICATION;
        $APPLICATION->RestartBuffer();

        $request = Context::getCurrent()->getRequest();

        header('Content-Type: application/json; charset=UTF-8');
        header('X-Content-Type-Options: nosniff');

        try {
            if (!$request->isPost() || !check_bitrix_sessid()) {
                throw new \RuntimeException('Bad request');
            }

            $action = (string)$request->getPost('action');

            $data = $request->getPost('data');
            if (is_string($data)) {
                $data = json_decode($data, true) ?: [];
            }
            if (!is_array($data)) {
                $data = [];
            }

            match ($action) {
                'select'         => $this->ajaxSelect($data),
                'selectAll'      => $this->ajaxSelectAll($data),
                'quantity'       => $this->ajaxSetQuantity($data),
                'delete'         => $this->ajaxDeleteItem($data),
                'deleteSelected' => $this->ajaxDeleteSelected(),
                'useCard'        => $this->ajaxSetUseCard($data),
                default          => throw new \InvalidArgumentException('Unknown action: ' . $action),
            };

            $res = $this->basket->save();
            if (!$res->isSuccess()) {
                throw new \RuntimeException(implode('; ', $res->getErrorMessages()));
            }

            $this->fillProductsProperties();
            $this->recalculatePrices();

            echo \Bitrix\Main\Web\Json::encode([
                'success' => true,
                'items'   => $this->buildResult(),
                'total'   => $this->buildResultTotal(),
                'selectedAll' => $this->isAllSelected()
            ], JSON_UNESCAPED_UNICODE);
        } catch (\Throwable $e) {
            echo \Bitrix\Main\Web\Json::encode([
                'success' => false,
                'error'   => $e->getMessage(),
            ], JSON_UNESCAPED_UNICODE);
        }

        CMain::FinalActions();
        die();
    }


    private function requireItem(array $data): \Bitrix\Sale\BasketItem
    {
        $id = (string)($data['id'] ?? '');
        $item = $this->findItem($id);

        if (!$item) {
            throw new \RuntimeException('Item not found: ' . json_encode($data));
        }

        return $item;
    }


    /**
     * AJAX METHOD
     */
    private function ajaxSelect(array $data): void
    {
        $item = $this->requireItem($data);
        $selected = filter_var($data['value'] ?? false, FILTER_VALIDATE_BOOLEAN);

        $this->setItemSelected($item, $selected);
    }

    private function ajaxSelectAll(array $data): void
    {
        $selected = filter_var($data['value'] ?? false, FILTER_VALIDATE_BOOLEAN);
        foreach ($this->basket as $item) {
            $this->setItemSelected($item, $selected);
        }
    }

    private function ajaxSetQuantity(array $data): void
    {
        $item = $this->requireItem($data);

        $quantity = $data['quantity'] ?? $item->getQuantity();
        if (!is_numeric($quantity)) {
            throw new \InvalidArgumentException('Invalid quantity');
        }
        $quantity = (float)$quantity;

        $minOrderQty = (float)($item->getField('MIN_ORDER_QTY') ?: 1);
        if ($quantity < $minOrderQty) {
            $quantity = $minOrderQty;
        }

        $item->setField('QUANTITY', $quantity);
    }

    private function ajaxDeleteItem(array $data): void
    {
        $this->requireItem($data)->delete();
    }

    private function ajaxDeleteSelected(): void
    {
        foreach ($this->basket as $item) {
            if ($this->isItemSelected($item)) {
                $item->delete();
            }
        }
    }

    private function ajaxSetUseCard(array $data): void
    {
        $useCard = filter_var($data['value'] ?? false, FILTER_VALIDATE_BOOLEAN);
        $this->logger->warning($useCard);
        \Bitrix\Main\Application::getInstance()
            ->getSession()
            ->set('USE_CARD', $useCard ? 'Y' : 'N');
    }

    private function findItem(string $id): ?\Bitrix\Sale\BasketItem
    {
        if ($id === '') {
            return null;
        }
        foreach ($this->basket as $item) {
            if ((string)$item->getProductId() === $id) {
                return $item;
            }
        }
        return null;
    }
}
