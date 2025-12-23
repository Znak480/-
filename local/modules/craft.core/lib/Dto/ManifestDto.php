<?php

namespace Craft\Core\Dto;


/**
 * @property  ManifestChainDto[] $blocks
 */
class ManifestDto
{
	public function __construct(
		protected array $blocks
	)
	{
	}

	public static function fromJson(array $json): ManifestDto
	{
		return new self(self::readJson($json));
	}

	protected static function readJson(array $json): array
	{
		$result = [];

		foreach($json as $name => $block)
		{
			$result[] = new ManifestChainDto($name, ManifestBlockDto::fromArray($block));
		}


		return $result;
	}

	public function getBlockByName(string $name): ?ManifestBlockDto
	{


		$blockList = array_filter($this->blocks, function($block) use ($name) {
			return $block->getName() === $name;
		});


		if(!$blockList)
		{
			$blockList = array_filter($this->blocks, function(ManifestChainDto $block) use ($name) {
				return $block->getName() === 'src/components/' . $name . '.vue';
			});
		}

		if(count($blockList) != 1)
		{
			return null;
		}

		$blockList = array_shift($blockList);
		/* @var ManifestChainDto $blockList */

		return $blockList->getManifestBlock();
	}

	public function getCoreCss(): ?ManifestBlockDto
	{
		$blocks = array_filter($this->blocks, function(ManifestChainDto $block) {
			return $block->getName() === 'style.css';
		});

		if(count($blocks) != 1)
		{
			return null;
		}

		$block = array_shift($blocks);

		return $block->getManifestBlock();
	}

	public function getCoreJs(): ?ManifestBlockDto
	{
		$blocks = array_filter($this->blocks, function(ManifestChainDto $block) {
			return $block->getManifestBlock()->getIsEntry();
		});

		if(count($blocks) != 1)
		{
			return null;
		}

		$block = array_shift($blocks);

		return $block->getManifestBlock();
	}
}