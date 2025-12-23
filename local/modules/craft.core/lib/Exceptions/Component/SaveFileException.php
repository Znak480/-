<?php

namespace Craft\Core\Exceptions\Component;

class SaveFileException extends \Exception
{
	protected $code = 400;
	protected $message = "Save File Error";
}