<?php

namespace Craft\Core\Exceptions\Component;

class PostRequestException extends \Exception
{
	protected $code = 200;

	protected $message = 'Is request not POST';
}