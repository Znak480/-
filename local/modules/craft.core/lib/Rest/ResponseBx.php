<?php

namespace Craft\Core\Rest;

class ResponseBx
{

	const SUCCESS_RESPONSE_CODE = 200;
	const ERORR_RESPONSE_CODE = 400;

	public static function success(array $body): void
	{
		self::withCode(self::SUCCESS_RESPONSE_CODE, $body);
	}

	public static function badRequest(string $message, int $code = self::ERORR_RESPONSE_CODE, array $errors = []): void
	{
		self::withCodeWhenError($message, $code, $errors);
	}

	protected static function withCodeWhenError(string $message, int $code = self::ERORR_RESPONSE_CODE, array $errors = []): void
	{
		global $APPLICATION;
		$APPLICATION->RestartBuffer();
		header('Content-Type: application/json; charset=utf-8');
		header('HTTP/1.0 ' . $code);
		echo json_encode(['error' => [
			'code'    => $code,
			'message' => $message,
			'errors'  => $errors,
		]]);
		exit();
	}

	protected static function withCode(int $code = self::SUCCESS_RESPONSE_CODE, array $body = []): void
	{
		global $APPLICATION;
		$APPLICATION->RestartBuffer();
		header('Content-Type: application/json; charset=utf-8');
		header('HTTP/1.0 ' . $code);
		echo json_encode(['status' => 'success', 'data' => $body]);
		exit();
	}
}