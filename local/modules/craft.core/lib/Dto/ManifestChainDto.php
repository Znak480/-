<?php

namespace Craft\Core\Dto;

class ManifestChainDto
{
	public function __construct(
		protected string           $name,
		protected ManifestBlockDto $manifestBlock,
	)
	{
	}


	public function getName(): string
	{
		return $this->name;
	}

	public function getManifestBlock(): ManifestBlockDto
	{
		return $this->manifestBlock;
	}
}