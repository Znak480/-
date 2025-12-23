<?php

session_start();

if(file_exists(__DIR__ . "/regional.php"))
{
	require_once __DIR__ . "/regional.php";
}

$fileRoute = '/var/www/u1378845/data/www/u1378845.isp.regruhosting.ru/cart/log.txt';
$fileRoute2 = '/var/www/u1378845/data/www/u1378845.isp.regruhosting.ru/cart/log2.txt';

const NO_SHOW_PROP = ["AKTSIYA_", "SKIDKA_PO_KARTE_", "POISKOVYY_KONTENT"];

function getElementById($id)
{
	global $currentCity;
	$result = false;
	//$arSelect = array("ID", "IBLOCK_ID", "ACTIVE", "NAME", "PREVIEW_PICTURE", "PREVIEW_TEXT", "DETAIL_PAGE_URL","CATALOG_GROUP_".$currentCity['PRICE_ID']['VALUE']);
	$arSelect = ["ID", "NAME", "DATE_ACTIVE_FROM", "PROPERTY_SALE", "PROPERTY_DISCOUNT", "PROPERTY_HIT", "PREVIEW_PICTURE", "DETAIL_PAGE_URL", "CATALOG_GROUP_" . $currentCity['PRICE_ID']['VALUE'], 'PROPERTY_SKIDKA_PO_KARTE_', "PROPERTY_RAITING_PRODAZH", "PROPERTY_AKTSIYA_"];
	$arFilter = ["ID" => IntVal($id), "ACTIVE" => "Y"];
	$res = CIBlockElement::GetList([], $arFilter, false, ["nPageSize" => 1], $arSelect);
	while($ob = $res->GetNextElement())
	{
		$arFields = $ob->GetFields();
		$arFields['PROPERTIES']['SKIDKA_PO_KARTE_']['VALUE'] = $arFields['PROPERTY_SKIDKA_PO_KARTE__VALUE'];
		$arFields['PROPERTIES']['RAITING_PRODAZH']['VALUE'] = $arFields['PROPERTY_RAITING_PRODAZH_VALUE'];
		$arFields['PROPERTIES']['AKTSIYA_']['VALUE'] = $arFields['PROPERTY_AKTSIYA__VALUE'];
		$arFields['PRICES'][$currentCity['PRICE_CODE']['VALUE']] = [
			"VALUE"       => $arFields['CATALOG_PRICE_' . $currentCity['PRICE_ID']['VALUE']],
			"PRINT_VALUE" => $arFields['CATALOG_PRICE_' . $currentCity['PRICE_ID']['VALUE']] . " р.",
		];
		$arProps = $ob->GetProperties();
		$result = $arFields;
		$result['PROPERTIES'] = $arProps;
	}
	return $result;
}

function translit($str)
{
	$rus = ['А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я'];
	$lat = ['A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya'];
	return str_replace($rus, $lat, $str);
}

function translit2($str)
{
	$rus = ['-----', '----', '---', '--', 'quot', 'amp', '&quot;', 'A', 'B', 'V', 'G', 'D', 'E', 'E', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Y', 'Y', 'Y', 'E', '"', "/", " ", ",", "'"];
	$lat = ['-', '-', '-', '-', '', '-', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'y', 'y', 'y', 'e', '-', "-", "-", "-", "-"];
	return str_replace($rus, $lat, $str);
}

function ov_dump($val)
{
	echo '<pre>';
	print_r($val);
	echo '</pre>';
}

function qtyProduct($qty, $measure)
{
	global $USER;
	if($USER->IsAuthorized())
	{
		// 9 - сотрудники
		if(in_array(9, CUser::GetUserGroup($USER->GetID())))
		{
			return getQtyText($qty, $measure, true);
		}
	}

	return getQtyText($qty);

}

function getQtyText($qty, $measure = '', $employ = false)
{
	if($qty < 0) $qty = 0;
	$str = ($employ) ? ' - ' . $qty . ' ' . $measure : '';
	if($qty == 0)
	{
		return '<span class="availability-status availability-status_out">Под заказ</span>';
	} else if($qty <= 10)
	{
		return '<span class="availability-status availability-status_in-stock">Мало в наличии ' . $str . '*</span>';
	} else if($qty <= 50)
	{
		return '<span class="availability-status availability-status_in-stock">Достаточно в наличии ' . $str . '*</span>';
	} else
	{
		return '<span class="availability-status availability-status_in-stock">Много в наличии ' . $str . '*</span>';
	}
}
