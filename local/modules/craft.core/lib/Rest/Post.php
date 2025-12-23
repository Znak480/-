<?php

namespace Craft\Core\Rest;

class Post implements Curl
{

	protected ?string $response = null;

	public static function instance(): Post
	{
		return new static();
	}

	public function execute(string $url, array $params, array $headers = []): Post
	{
		$ch = curl_init($url);

		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params, '', '&'));
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