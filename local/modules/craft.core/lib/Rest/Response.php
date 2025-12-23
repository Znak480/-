<?php

namespace Craft\Core\Rest;

class Response
{
	const STATUS_OK = 200;

	const STATUS_CREATED = 201;

	const STATUS_ERROR = 500;

	const STATUS_BAD_REQUEST = 400;

	const KEY_ITEMS = 'data';

	private static function statusList()
	{
		return [
			self::STATUS_OK          => 'OK',
			self::STATUS_CREATED     => 'Created',
			self::STATUS_BAD_REQUEST => 'Bad request',
		];
	}

	private static function getStatus($statusCode)
	{
		$list = self::statusList();

		return sprintf('%s %s', $statusCode, $list[$statusCode]);
	}

	public static function emit($statusCode, $data = NULL)
	{
		global $APPLICATION;
		$APPLICATION->RestartBuffer();
		header('Content-Type: application/json; charset=utf-8');
		header('HTTP/1.0 ' . self::getStatus($statusCode));

		$response = [
			'code' => $statusCode,
		];

		$response[self::KEY_ITEMS] = $data;

		echo json_encode($response);
		exit();
	}

	public static function success(array $data = [])
	{
		global $APPLICATION;
		$APPLICATION->RestartBuffer();
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode(array_merge(['code' => self::STATUS_OK], $data));
		exit();
	}

	public static function badRequest($message = NULL)
	{
		global $APPLICATION;
		$APPLICATION->RestartBuffer();
		header('Content-Type: application/json; charset=utf-8');
		header('HTTP/1.0 ' . self::getStatus(self::STATUS_BAD_REQUEST));

		$response = [
			'code'  => self::STATUS_BAD_REQUEST,
			'error' => self::statusList()[self::STATUS_BAD_REQUEST],
		];

		echo json_encode(array_merge($response, $message));
		exit();
	}
}