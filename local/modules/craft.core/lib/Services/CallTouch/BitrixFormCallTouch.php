<?php

namespace Craft\Service\CallTouch;

use Bitrix\Main\Loader;

class BitrixFormCallTouch implements CallTouchInterface
{
	protected CallTouch $callTouch;
	protected static $instance = null;
	protected $params = [];

	public static function instance(
		CallTouch $callTouch
	): static
	{
		if(is_null(static::$instance))
		{
			static::$instance = new static($callTouch);
		}

		return self::$instance;
	}

	public function __construct(
		CallTouch $calltouchService
	)
	{
		$this->callTouch = $calltouchService;
	}

	public function params(int $webFormId, int $resultId): BitrixFormCallTouch
	{
		if(!Loader::includeModule('form'))
		{
			return $this;
		}

		$result = [];
		$answerData = [];
		\CFormResult::GetDataByID($resultId, [], $result, $answerData);


		$callTouchForm = [];
		foreach($answerData as $propertyCode => $answer)
		{
			$answer = array_shift($answer);

			switch($propertyCode)
			{
				case 'PHONE':
					$callTouchForm['phoneNumber'] = $answer['USER_TEXT'];
					break;
				case 'CLIENT_NAME':
					$callTouchForm['fio'] = $answer['USER_TEXT'];
					break;
				case 'EMAIL':
					$callTouchForm['email'] = $answer['USER_TEXT'];
					break;
			}

		}

		$webForm = \CForm::GetByID($webFormId)->Fetch();
		if($webForm['NAME'])
		{
			$callTouchForm['formName'] = $webForm['NAME'];
		}

		$this->params = $callTouchForm;

		return $this;
	}


	public function send(array $params = []): void
	{
		if($this->params)
		{
			$this->callTouch->send(array_merge($this->params, $params));
		}
	}
}