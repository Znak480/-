<?php

class craft_core extends CModule
{
	const MODULE_ID = 'craft.core';
	const DIR_MODULE = 'local';

	var $MODULE_ID = "craft.core";
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME = '[craft] Ядро';
	var $MODULE_DESCRIPTION = 'Инструменты разработки';
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
		$eventManager = \Bitrix\Main\EventManager::getInstance();

		$eventManager->registerEventHandlerCompatible(
			'craft.form',
			'OnModuleUnInstall',
			$this->MODULE_ID,
			'',
			'craftcoreUnInstallEvent',
		);

		$eventManager->registerEventHandlerCompatible(
			'craft.user',
			'OnModuleUnInstall',
			$this->MODULE_ID,
			'',
			'craftcoreUnInstallEvent',
		);
	}

	function UnInstallEvents()
	{
		$eventManager = \Bitrix\Main\EventManager::getInstance();

		$eventManager->unRegisterEventHandler(
			'craft.form',
			'OnModuleUnInstall',
			$this->MODULE_ID,
			'',
			'craftcoreInstallEvent',
		);

		$eventManager->unRegisterEventHandler(
			'craft.user',
			'OnModuleUnInstall',
			$this->MODULE_ID,
			'',
			'craftcoreInstallEvent',
		);
	}

	function InstallFiles()
	{

		CopyDirFiles(
			$_SERVER['DOCUMENT_ROOT'] . '/' . self::DIR_MODULE . '/modules/' . self::MODULE_ID . '/install/components',
			$_SERVER['DOCUMENT_ROOT'] . "/" . self::DIR_MODULE . "/components",
			true,
			true,
		);
	}

	function UnInstallFiles()
	{
	}

	function DoInstall()
	{
		$this->InstallEvents();
		RegisterModule(self::MODULE_ID);

		$this->InstallFiles();
	}

	function DoUninstall()
	{
		$this->UnInstallEvents();
		UnRegisterModule(self::MODULE_ID);
	}
}