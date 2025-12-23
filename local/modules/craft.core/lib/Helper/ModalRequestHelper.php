<?php

namespace Craft\Core\Helper;

class ModalRequestHelper
{
	protected static $instance;
	protected ?string $url = null;
	protected ?array $params = [];

	public function __construct(string $url)
	{
		$this->url = $url;
	}

	public static function init(string $url): ModalRequestHelper
	{
		if(is_null(self::$instance))
		{
			self::$instance = new self($url);
		}

		return self::$instance;
	}

	public function params(array $params): ModalRequestHelper
	{
		$this->params = $params;
		return $this;
	}

	public function build(): string
	{
		return sprintf('%s?%s', $this->url, http_build_query($this->params));
	}
}
