<?php

namespace Craft\Service\CallTouch;

use Bitrix\Main\Diag\Debug;

class CallTouch implements CallTouchInterface
{

	protected static $instance = null;

	public static function instance()
	{
		if(is_null(self::$instance))
		{
			self::$instance = new CallTouch();
		}

		return self::$instance;
	}

	public function send(array $params = []): void
	{
		if(!defined('CALLTOUCH_SITE_ID'))
		{
			return;
		}

		$call_value = $_COOKIE['_ct_session_id']; /* ID сессии Calltouch, полученный из cookie */

		$params['subject'] = 'Заявка с сайта';

		if($params['formName'])
		{
			$params['subject'] = $params['subject'] . ' - форма: ' . $params['formName'];
			unset($params['formName']);
		}

		if($call_value != 'undefined')
		{
			$params['sessionId'] = $call_value;
		}

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-type: application/x-www-form-urlencoded;charset=utf-8"]);
		curl_setopt($ch, CURLOPT_URL, 'https://api.calltouch.ru/calls-service/RestAPI/requests/' . CALLTOUCH_SITE_ID . '/register/');
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$calltouch = curl_exec($ch);
		curl_close($ch);

//		Debug::dumpToFile(json_decode($calltouch));
	}

}