<?php

use Craft\Bitrix\Events\OnBasketDeleteHandler;
use Craft\Bitrix\Events\OnBasketUpdateHandler;
use Craft\Bitrix\Events\OnOrderNewSendEmailHandler;
use Craft\Bitrix\Events\OnPageStartHandler;

$eventManager = Bitrix\Main\EventManager::getInstance();

// лечим сайт от дублирования сессионной переменной ========
$eventManager->registerEventHandler("main", "OnPageStart", "main", OnPageStartHandler::class, 'FixDoubleSessionId', '100');
$eventManager->addEventHandler('sale', 'OnBasketDelete', [OnBasketDeleteHandler::class, 'handle']);
$eventManager->addEventHandler('sale', 'OnBasketUpdate', [OnBasketUpdateHandler::class, 'OnBasketHandler']);
$eventManager->addEventHandler('sale', 'OnOrderNewSendEmail', [OnOrderNewSendEmailHandler::class, 'prepareMail']);
$eventManager->addEventHandler('sale', 'OnOrderNewSendEmail', [OnOrderNewSendEmailHandler::class, 'ModifyOrderSaleMails']);