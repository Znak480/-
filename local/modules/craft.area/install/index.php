<?php

use Bitrix\Main\Loader;
use Bitrix\Main\EventManager;
use Craft\Area\Admin\Migrations\MigrationHandler;

class craft_area extends CModule
{
	const MODULE_ID = 'craft.area';
	const DIR_MODULE = 'local';

	var $MODULE_ID = "craft.area";
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME = '[craft] Редактируемые блоки';
	var $MODULE_DESCRIPTION = 'Удобный функционал управления контентом';
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
		if(!$DB->TableExists('craft_area'))
		{
			$this->errors = $DB->RunSQLBatch($_SERVER['DOCUMENT_ROOT'] . '/local/modules/' . $this->MODULE_ID . '/install/db/create.sql');
		}

	}

	function UnInstallDB($arParams = [])
	{
		global $DB, $APPLICATION;
		$this->errors = $DB->RunSQLBatch($_SERVER['DOCUMENT_ROOT'] . "/" . self::DIR_MODULE . "/modules/" . $this->MODULE_ID . "/install/db/delete.sql");
	}

	function InstallEvents()
	{

	}

	function UnInstallEvents()
	{
	}

	function InstallFiles()
	{
		CopyDirFiles(
			$_SERVER['DOCUMENT_ROOT'] . '/' . self::DIR_MODULE . '/modules/' . self::MODULE_ID . '/install/admin',
			$_SERVER['DOCUMENT_ROOT'] . "/bitrix/admin"
		);

		CopyDirFiles(
			$_SERVER['DOCUMENT_ROOT'] . '/' . self::DIR_MODULE . '/modules/' . self::MODULE_ID . '/install/components',
			$_SERVER['DOCUMENT_ROOT'] . "/" . self::DIR_MODULE . "/components",
			true,
			true,
		);
	}

	function UnInstallFiles()
	{
		DeleteDirFiles(
			$_SERVER["DOCUMENT_ROOT"] . '/' . self::DIR_MODULE . '/modules/' . self::MODULE_ID . '/install/admin',
			$_SERVER["DOCUMENT_ROOT"] . "/bitrix/admin"
		);
	}

	function attachMigrations()
	{

		if(!Loader::includeModule($this->MODULE_ID))
		{
			return;
		}

		$eventManager = EventManager::getInstance();

		if(Loader::includeModule('sprint.migration'))
		{
			MigrationHandler::registerEvent();
		} else
		{
			# если модуль миграций не установлен
			# чтобы после установки модуля миграций подключился конфиг
			$eventManager->registerEventHandlerCompatible(
				'main',
				'OnAfterRegisterModule',
				$this->MODULE_ID,
				MigrationHandler::class,
				'registerEvent',
			);
		}

		return true;
	}

	function deAttachMigrations()
	{
		if(!Loader::includeModule($this->MODULE_ID))
		{
			return;
		}

		$eventManager = EventManager::getInstance();
		$eventManager->unRegisterEventHandler(
			'sprint.migration',
			"OnSearchConfigFiles",
			$this->MODULE_ID,
			MigrationHandler::class,
			"getConfigDirectory",
		);
		$eventManager->unRegisterEventHandler(
			'main',
			"OnAfterRegisterModule",
			$this->MODULE_ID,
			MigrationHandler::class,
			"registerEvent",
		);
	}

	function DoInstall()
	{
		$this->InstallDB();
		$this->InstallEvents();
		$this->InstallFiles();

		RegisterModule($this->MODULE_ID);

		$this->attachMigrations();
	}

	function DoUninstall()
	{
		$this->UnInstallDB();
		$this->UnInstallEvents();
		$this->UnInstallFiles();

		$this->deAttachMigrations();

		UnRegisterModule($this->MODULE_ID);
	}
}
