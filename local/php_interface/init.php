<?php

use Bitrix\Main\Loader;

if(file_exists($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/wsrubi.smtp/classes/general/wsrubismtp.php"))
{
	include_once $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/wsrubi.smtp/classes/general/wsrubismtp.php";
}

if(file_exists(__DIR__ . '/vendor/autoload.php'))
{
	include_once __DIR__ . '/vendor/autoload.php';
} else if(file_exists($_SERVER["DOCUMENT_ROOT"] . '/local/php_interface/Psr4AutoloaderClass.php'))
{
	include_once $_SERVER["DOCUMENT_ROOT"] . '/local/php_interface/Psr4AutoloaderClass.php';
	$loader = new Psr4AutoloaderClass();
	$loader->addNamespace("Craft\\", $_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/lib');
	$loader->register();
}

foreach([] as $module)
{
	Loader::includeModule($module);
}

require_once __DIR__ . '/dev_functions.php';
require_once __DIR__ . '/../js/config.php';


if(Loader::includeModule('craft.core'))
{
	require_once __DIR__ . '/defines.php';
}

require_once __DIR__ . '/old_init.php';
require_once __DIR__ . '/events.php';