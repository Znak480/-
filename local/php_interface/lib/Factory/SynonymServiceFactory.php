<?php

namespace Craft\Factory;

use Craft\Service\SynonymSearchEngine;
use Craft\Service\SynonymService;

class SynonymServiceFactory
{
	public static function getService(): SynonymService
	{
		return new SynonymService(
			new SynonymSearchEngine()
		);
	}
}