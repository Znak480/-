<?php

namespace Craft\Core\Component;

abstract class CacheableComponent extends CaptchaComponent
{
	protected function getCacheTTL(): int
	{
		return intval($this->arParams['CACHE_TTL']) ?? 86400;
	}
}