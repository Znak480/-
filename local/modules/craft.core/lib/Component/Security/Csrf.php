<?php

namespace Craft\Core\Component\Security;

use Bitrix\Main\Application;
use Bitrix\Main\Session\SessionInterface;

class Csrf
{
	protected static $instance;

	protected SessionInterface $session;

	const SESSION_KEY = 'userCsrfToken';

	public function __construct()
	{
		$this->session = Application::getInstance()->getSession();
	}

	public static function getInstance(): self
	{
		if(is_null(self::$instance))
		{
			self::$instance = new self;
		}
		return self::$instance;
	}

	public function generateToken(): string
	{
		$token = bin2hex(random_bytes(32));

		$this->session->set(self::SESSION_KEY, $token);

		return $token;
	}

	public function validateToken($token): bool
	{
		$csrf = $this->session->get(self::SESSION_KEY);

		if(!$csrf)
		{
			return false;
		}

		return hash_equals($csrf, $token);
	}
}