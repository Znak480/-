<?php

namespace Craft\Core\Exceptions\Component;

class ValidateException extends \Exception
{
	protected $code = 400;
	protected $message = 'Validation Error';
}