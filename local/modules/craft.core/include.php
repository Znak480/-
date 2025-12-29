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


define('CRAFT_DEVELOP_ADMIN_URL_SYNONYMS_LIST', '/bitrix/admin/craft_developer_search_synonyms.php');

define('CRAFT_DEVELOP_ADMIN_URL_SYNONYMS_EDIT', '/bitrix/admin/craft_developer_search_synonyms_edit.php');