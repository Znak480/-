<?php

namespace Craft\Area;

class Module
{
	const ID = 'craft.area';

	public static function getModuleDir($absolute = true): string
	{
		$root = $absolute ? self::getDocRoot() : '';

		if(is_file(self::getDocRoot() . '/local/modules/' . self::ID . '/include.php'))
		{
			return $root . '/local/modules/' . self::ID;
		} else
		{
			return $root . '/bitrix/modules/' . self::ID;
		}
	}

	public static function getDocRoot(): string
	{
		return rtrim($_SERVER['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR);
	}
}