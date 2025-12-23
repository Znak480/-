<?php

namespace Craft\Core\Exceptions\Component;

class HandleRequestException extends \Exception
{
	protected $code = '400';
	protected $message = 'Request Error';
}
