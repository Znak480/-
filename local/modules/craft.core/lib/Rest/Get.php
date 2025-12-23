<?php

namespace Craft\Core\Rest;

class Get implements Curl
{
	protected $response;

	public static function instance(): self
	{
		return new self();
	}

	public function execute(string $url, array $params, array $headers = []): Curl
	{
		$ch = curl_init($url . '?' . http_build_query($params));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_HEADER, false);
		$this->response = curl_exec($ch);
		curl_close($ch);

		return $this;
	}

	public function json(): ?array
	{
		try
		{
			return json_decode($this->response, true);
		} catch(\Exception $exception)
		{
			return null;
		}
	}

	public function string(): string
	{
		return strval($this->response);
	}
}