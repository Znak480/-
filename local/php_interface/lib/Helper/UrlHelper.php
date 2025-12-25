<?php

namespace Craft\Helper;

class UrlHelper
{

	public static function subdomain(): ?string
	{
		$hostParts = explode('.', self::domain());
		$part = array_shift($hostParts);

		if($part)
		{
			return $part;
		}

		return null;
	}

	public static function protocol(): string
	{
		return self::isHttps() ? 'https://' : 'http://';
	}

	public static function isHttps(): bool
	{
		return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
	}

	public static function domain(): ?string
	{
		return $_SERVER['SERVER_NAME'];
	}
}