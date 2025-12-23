<?php

namespace Craft\Area\Dto;

class AreaContentDto
{
	private string $blockCode;
	private $value;

	public function __construct(
		string $blockCode,
			   $value
	)
	{
		$this->blockCode = $blockCode;
		$this->value = $value;
	}

	public function getBlockCode(): string
	{
		return $this->blockCode;
	}

	public function getValue()
	{
		return $this->value;
	}
}