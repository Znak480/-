<?php

namespace Craft\Bitrix\Events;

use Bitrix\Main\Context;
use Bitrix\Sale\Basket;
use Bitrix\Sale\Fuser;
use CSaleBasket;

class OnBasketDeleteHandler
{
	public static function handle($ID)
	{
		global $fileRoute;
		global $fileRoute2;

		$basket = Basket::loadItemsForFUser(Fuser::getId(), SITE_ID);

		// Выведем актуальную корзину для текущего пользователя

		$arBasketItems = [];

		$dbBasketItems = CSaleBasket::GetList(
			[
			],
			[
				"FUSER_ID" => CSaleBasket::GetBasketUserID(),
				"LID"      => SITE_ID,
				"ORDER_ID" => "NULL",
			],
			false,
			false,
			["ID",
				"PRODUCT_ID", "QUANTITY", "PRICE"]
		);
		while($arItems = $dbBasketItems->Fetch())
		{
			if(strlen($arItems["CALLBACK_FUNC"]) > 0)
			{
				$arItems = CSaleBasket::GetByID($arItems["ID"]);
			}

			$arBasketItems[] = $arItems;
		}

		foreach($arBasketItems as $item)
		{
			OnBasketUpdateHandler::OnBasketHandler($item['ID'], $item);
		}

	}
}