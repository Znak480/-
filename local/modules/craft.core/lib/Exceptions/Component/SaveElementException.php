<?php

namespace Craft\Core\Exceptions\Component;

class SaveElementException extends \Exception
{
	protected $code = 400;
	protected $message = "Save error";
}