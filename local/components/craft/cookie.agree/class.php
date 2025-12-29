<?php

use Bitrix\Main\Errorable;
use Bitrix\Main\Application;
use Bitrix\Main\ErrorCollection;
use Bitrix\Main\Session\SessionInterface;
use Bitrix\Main\Engine\ActionFilter\Csrf;
use Bitrix\Main\Engine\ActionFilter\HttpMethod;
use Bitrix\Main\Engine\Contract\Controllerable;

class CraftCookieAgreeComponent extends CBitrixComponent implements Controllerable, Errorable
{
	const COOKIE_KEY = 'hide_cookies';

	protected ErrorCollection $errorCollection;
	protected SessionInterface $session;

	public function onPrepareComponentParams($arParams)
	{
		$this->errorCollection = new ErrorCollection();
		$this->session = Application::getInstance()->getSession();
		return $arParams;
	}

	public function executeComponent()
	{

		$this->arResult['TEXT'] = $this->arParams['TEXT'] ?? '';
		$this->arResult['IS_HIDE'] = $this->session->get(self::COOKIE_KEY) === true;

		$this->includeComponentTemplate();
	}

	public function executeAction()
	{
		$this->session->set(self::COOKIE_KEY, true);


		if(!$this->session->has(self::COOKIE_KEY))
		{

			throw new Exception('asdd');

			//			return [
			//				'success' => false,
			//			];
		}

	}

	public function configureActions()
	{
		return [
			'execute' => [
				'prefilters' => [
					new HttpMethod(
						[HttpMethod::METHOD_POST]
					),
					new Csrf(),
				],
			],
		];
	}

	public function getErrors()
	{
		return $this->errorCollection->toArray();
	}

	public function getErrorByCode($code)
	{
		return $this->errorCollection->getErrorByCode($code);
	}
}