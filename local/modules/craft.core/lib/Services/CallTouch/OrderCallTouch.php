<?php

namespace Craft\Service\CallTouch;

use Bitrix\Main\Loader;
use Bitrix\Sale\Order;

/**
 * @property array<string, string> $params
 */
final class OrderCallTouch implements CallTouchInterface
{
	protected static ?OrderCallTouch $instance = null;
	protected CallTouch $callTouch;
	protected array $params = [];

	public static function instance(CallTouch $callTouch): OrderCallTouch
	{
		if(is_null(static::$instance))
		{
			static::$instance = new static($callTouch);
		}

		return static::$instance;
	}

	public function __construct(
		CallTouch $callTouch,
	)
	{
		$this->callTouch = $callTouch;
	}

	public function paramsFromOrderId(int $orderId): OrderCallTouch
	{

		if(!Loader::includeModule('sale'))
		{
			return $this;
		}

		$order = Order::getList([
			'filter' => [
				'ID' => $orderId,
			],
		])->fetch();

		if(!$order)
		{
			return $this;
		}

		/* @var Order $order */


		$userId = $order['USER_ID'];
		$user = \CUser::GetByID($userId)->Fetch();
		if(!$user)
		{
			return $this;
		}

		/* @var array $user */

		$this->params['formName'] = 'Заказ на сайте';
		$this->params['phoneNumber'] = $user['PERSONAL_PHONE'];
		$this->params['fio'] = implode(' ', [
			$user['LAST_NAME'],
			$user['NAME'],
			$user['SECOND_NAME'],
		]);
		$this->params['email'] = $user['EMAIL'];


		return $this;
	}

	/**
	 * @param array<string, string> $params
	 */
	public function send(array $params = []): void
	{
		if($this->params)
		{
			$this->callTouch->send(array_merge($this->params, $params));
		}
	}
}