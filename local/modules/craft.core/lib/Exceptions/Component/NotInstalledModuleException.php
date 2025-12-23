<?php

namespace Craft\Core\Exceptions\Component;

class NotInstalledModuleException extends \Exception
{
	protected $code = 400;
	protected $message = "The module is not installed.";
}