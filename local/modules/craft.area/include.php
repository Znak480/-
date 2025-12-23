<?php
$modulePath = $_SERVER["DOCUMENT_ROOT"] . '/local/modules/craft.area';
$loaderPath = $modulePath . '/Psr4AutoloaderClass.php';

if(file_exists($loaderPath))
{
	include_once $loaderPath;

	$loader = new \Craft\Area\Psr4AutoloaderClass();
	$loader->addNamespace("Craft\\Area\\", $modulePath . '/lib');
	$loader->register();
}


$jsConfigPath = __DIR__ . '/js/config.php';
if(file_exists($jsConfigPath))
{
	include_once $jsConfigPath;
}


define('CRAFT_AREA_ADMIN_URL_LIST_AREA', '/bitrix/admin/craft_area_list.php');
define('CRAFT_AREA_ADMIN_URL_EDIT_AREA', '/bitrix/admin/craft_area_edit.php');

define('JEDI_AREA_ADMIN_URL_EDIT_CONTENT', '/bitrix/admin/craft_area_content_edit.php');