<?php

class craft_orm extends CModule
{
	const MODULE_ID = 'craft.orm';
	const DIR_MODULE = 'local';

	var $MODULE_ID = "craft.orm";
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME = '[craft] Генератор аннотаций';
	var $MODULE_DESCRIPTION = 'Генератор аннотаций';
	var $MODULE_CSS;

	var $errors;

	function __construct()
	{
		$arModuleVersion = [];
		include(__DIR__ . '/version.php');
	}

	function InstallDB()
	{
		global $DB, $APPLICATION;
	}

	function UnInstallDB($arParams = [])
	{
		global $DB, $APPLICATION;
	}

	function InstallEvents()
	{
	}

	function UnInstallEvents()
	{
	}

	function InstallFiles()
	{
	}

	function UnInstallFiles()
	{
	}

	function DoInstall()
	{
		RegisterModule("craft.orm");
	}

	function DoUninstall()
	{
		UnRegisterModule("craft.orm");
	}
}
