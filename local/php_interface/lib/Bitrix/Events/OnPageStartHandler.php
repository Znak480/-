<?php

namespace Craft\Bitrix\Events;

class OnPageStartHandler
{
	public static function FixDoubleSessionId()
	{
		if(
			session_id()
			&& isset($_COOKIE["PHPSESSID"])
			&& $_COOKIE["PHPSESSID"] != session_id()
		)
		{
			setcookie('PHPSESSID', '', time() - 100, '/');
			header('Location: ' . $_SERVER['REQUEST_URI]']);
		}
	}
}