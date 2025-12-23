<?php

namespace Craft\Core\Exceptions\Component;

class CaptchaValidateException extends \Exception
{
	protected $code = 400;
	protected $message = "Captcha validation failed";
}