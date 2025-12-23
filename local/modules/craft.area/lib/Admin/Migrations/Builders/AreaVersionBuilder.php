<?php

namespace Craft\Area\Admin\Migrations\Builders;

use Craft\Area\Admin\Migrations\Manager\OrmExchangeImport;
use Sprint\Migration\Exchange\RestartableReader;
use Sprint\Migration\Version;

class AreaVersionBuilder extends Version
{
	public function import(): RestartableReader
	{
		$dir = $this->getVersionConfig()->getVersionExchangeDir(
			$this->getVersionName()
		);

		return (new RestartableReader(
			$this,
			new OrmExchangeImport(),
			$dir

		))->setExchangeResource('full_area_data.xml');
	}
}