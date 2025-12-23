<?php

use Sprint\Migration\VersionConfig;
use Craft\Area\Admin\Migrations\Builders\AreaMigrationBuilder;

return [
	'version_builders' => [
		...VersionConfig::getDefaultBuilders(),
		'AreaMigrationBuilder' => AreaMigrationBuilder::class,
	],
];
?>