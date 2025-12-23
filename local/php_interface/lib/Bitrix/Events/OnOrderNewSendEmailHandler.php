<?php

namespace Craft\Bitrix\Events;

use Bitrix\Sale\Order;

class OnOrderNewSendEmailHandler
{
	public static function ModifyOrderSaleMails($orderID, &$eventName, &$arFields)
	{
		if(\CModule::IncludeModule("sale") && \CModule::IncludeModule("iblock"))
		{
			//СОСТАВ ЗАКАЗА РАЗБИРАЕМ SALE_ORDER НА ЗАПЧАСТИ
			$strOrderList = "";
			$dbBasketItems = \CSaleBasket::GetList(
				["NAME" => "ASC"],
				["ORDER_ID" => $orderID],
				false,
				false,
				["PRODUCT_ID", "ID", "NAME", "QUANTITY", "PRICE", "CURRENCY"]
			);
			while($arProps = $dbBasketItems->Fetch())
			{
				//ПЕРЕМНОЖАЕМ КОЛИЧЕСТВО НА ЦЕНУ
				$summ = $arProps['QUANTITY'] * $arProps['PRICE'];
				//СОБИРАЕМ В СТРОКУ ТАБЛИЦЫ
				$strCustomOrderList .= "<tr><td>" . $arProps['NAME'] . "</td><td>" . $arProps['QUANTITY'] . "</td><td>" . $arProps['PRICE'] . "</td><td>" . $arProps['CURRENCY'] . "</td><td>" . $summ . "</td><tr>";
			}
			//ОБЪЯВЛЯЕМ ПЕРЕМЕННУЮ ДЛЯ ПИСЬМА
			$arFields["ORDER_TABLE_ITEMS"] = $strCustomOrderList;
		}
	}

	public static function prepareMail($ID, &$eventName, &$arFields)
	{

		if($eventName != 'SALE_NEW_ORDER')
			return false;

		$order = Order::load($ID);
		$paymentCollection = $order->getPaymentCollection();
		//вариант оплаты
		$arFields['NAME_PAYMENT'] = $paymentCollection[0]->getPaySystem()->getField('NAME');
		//вариант доставки
		$arFields['NAME_DELIVERY'] = \CSaleDelivery::GetByID($order->getDeliverySystemId())['NAME'];

		$order_props = '';
		$ob_order_props = \CSaleOrderPropsValue::GetOrderProps($ID);
		while($arPropsField = $ob_order_props->Fetch())
		{
			if(!empty($arPropsField['VALUE']))
			{
				$order_props .= $arPropsField['NAME'] . ': ' . $arPropsField['VALUE'] . "<br>";
			}
		}


		$strOrderList = "<table border=0 cellpadding=5 cellspacing=0 width=100%><tr><td style='background:#ddd'>N</td><td style='background:#ddd'>Наименование</td><td style='background:#ddd'>Количество</td><td style='background:#ddd'>Цена, руб</td><td style='background:#ddd'>Стоимость, руб</td></tr>";
		$dbBasketItems = \CSaleBasket::GetList(
			["NAME" => "ASC"],
			["ORDER_ID" => $ID],
			false,
			false,
			["PRODUCT_ID", "ID", "NAME", "QUANTITY", "PRICE", "CURRENCY"]
		);
		$i = 1;

		global $currentCity;
		while($arBasketItems = $dbBasketItems->Fetch())
		{
			$arFields2 = [];
			$arSelect = ["ID", "NAME", "DETAIL_PAGE_URL", "PROPERTY_ARTIKUL"];
			$arFilter = ["IBLOCK_ID" => $currentCity['IBLOCK_CATALOG']['VALUE'], "ACTIVE_DATE" => "Y", "ACTIVE" => "Y", "ID" => $arBasketItems["PRODUCT_ID"]];
			$res = \CIBlockElement::GetList([], $arFilter, false, ["nTopCount" => 1], $arSelect);
			while($ob = $res->GetNextElement())
			{
				$arFields2 = $ob->GetFields();
				$arProps2 = $ob->GetProperties();
			}


			//            $strOrderList .= "<tr><td style='border-bottom:1px solid #ddd'>".$i."</td><td style='border-bottom:1px solid #ddd'>".$arBasketItems["NAME"]."</td><td style='border-bottom:1px solid #ddd'>".$arBasketItems["QUANTITY"]."</td><td style='border-bottom:1px solid #ddd'>".SaleFormatCurrency($arBasketItems["PRICE"], $arBasketItems["CURRENCY"])."</td></tr>";
			$strOrderList .= "<tr><td style='border-bottom:1px solid #ddd'>" . $i . "</td><td style='border-bottom:1px solid #ddd'>" . $arBasketItems["NAME"] . " (арт: " . $arProps2['ARTIKUL']['VALUE'] . ")</td><td style='border-bottom:1px solid #ddd'>" . $arBasketItems["QUANTITY"] . "</td><td style='border-bottom:1px solid #ddd'>" . number_format($arBasketItems["PRICE"], 2, ',', ' ') . "</td><td style='border-bottom:1px solid #ddd'>" . number_format($arBasketItems["QUANTITY"] * $arBasketItems["PRICE"], 2, ',', ' ') . "</td></tr>";
			$i++;
		}
		$strOrderList .= "</table>";
		$arFields['ORDER_LIST'] = $strOrderList;
		$arFields['ORDER_PROP'] = $order_props;
	}
}