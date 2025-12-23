<?php

namespace Craft\Core\Component\Helper;

use Bitrix\Main\Security\Sign\BadSignatureException;
use Bitrix\Main\Security\Sign\Signer;

class AjaxComponentHelper
{

	/**
	 * @param $data mixed
	 * @param $salt string
	 * @return string
	 */
	public static function signData($data, $salt = NULL)
	{
		$signer = new Signer();
		return $signer->sign(base64_encode(serialize($data)), $salt);
	}

	/**
	 * @param $data mixed
	 * @param $salt string
	 * @return mixed
	 */
	public static function unsignData($data, $salt = NULL)
	{
		$signer = new Signer();

		try
		{
			$unsignedData = $signer->unsign($data, $salt);
			$unsignedData = unserialize(base64_decode($unsignedData));
		} catch(BadSignatureException $e)
		{
			die($e->getMessage());
		}

		return $unsignedData;
	}

	public static function htmlspecialcharsbxArray($arr)
	{
		if(is_array($arr))
		{
			array_walk_recursive($arr, function(&$item, $key) {
				$item = htmlspecialcharsbx($item);
			});
		} else
		{
			$arr = htmlspecialcharsbx($arr);
		}

		return $arr;
	}
}