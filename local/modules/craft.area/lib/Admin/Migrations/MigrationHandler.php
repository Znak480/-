<?php

namespace Craft\Area\Admin\Migrations;

class MigrationHandler
{
	public static function getConfigDirectory(): string
	{
		return __DIR__ . '/../../../config/migrations';
	}

	public static function registerEvent(): void
	{
		$eventManager = \Bitrix\Main\EventManager::getInstance();
		$eventManager->registerEventHandlerCompatible(
			'sprint.migration',
			"OnSearchConfigFiles",
			'craft.area',
			MigrationHandler::class,
			"getConfigDirectory",
			10
		);
	}
}