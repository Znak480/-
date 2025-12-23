<?php

namespace Craft\Core\Rest;

interface Curl
{
	public function execute(string $url, array $params, array $headers = []): self;

	public function json(): ?array;

	public function string(): string;
}