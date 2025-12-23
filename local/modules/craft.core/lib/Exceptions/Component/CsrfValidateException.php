<?php

namespace Craft\Core\Exceptions\Component;

class CsrfValidateException extends \Exception
{
	protected $code = '400';
	protected $message = 'Invalid CSRF Token';
}