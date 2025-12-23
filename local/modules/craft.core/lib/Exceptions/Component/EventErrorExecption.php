<?php

namespace Craft\Core\Exceptions\Component;

class EventErrorExecption extends \Exception
{
	protected $code = 400;
	protected $message = 'Event Error';
}