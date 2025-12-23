<?php
$modulePath = $_SERVER["DOCUMENT_ROOT"] . '/local/modules/craft.core';
$loaderPath = $modulePath . '/Psr4AutoloaderClass.php';

if(file_exists(__DIR__ . '/vendor/autoload.php'))
{
	include_once __DIR__ . '/vendor/autoload.php';
} else if(file_exists($loaderPath))
{
	include_once $loaderPath;

	$loader = new \Craft\Core\Psr4AutoloaderClass();
	$loader->addNamespace("Craft\\Core\\", $modulePath . '/lib');
	$loader->register();
}


$jsConfigPath = __DIR__ . '/js/config.php';
if(file_exists($jsConfigPath))
{
	include_once $jsConfigPath;
}

function craftFormUnInstallEvent()
{
	$GLOBALS["APPLICATION"]->ThrowException('Модуль craft.user не может работать без модуля craft.form', "JEDI_USER_DEPENDES_JEDI_FORM");
	return false;
}