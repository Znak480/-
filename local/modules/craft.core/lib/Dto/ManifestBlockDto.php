<?php

namespace Craft\Core\Dto;

use Craft\Core\Helper\DtoManager;

class ManifestBlockDto extends DtoManager
{
	protected ?string $file = null;
	protected ?string $name = null;
	protected ?string $src = null;
	protected ?bool $isDynamicEntry = false;
	protected ?bool $isEntry = false;
	protected ?array $imports = [];
	protected ?array $dynamicImports = [];
	protected ?array $css = [];
	protected ?array $assets = [];

	public function isCss(): bool
	{
		return $this->getSrc() === 'style.css';
	}


	public function getIsDynamicEntry(): ?bool
	{
		return $this->isDynamicEntry;
	}

	public function getIsEntry(): ?bool
	{
		return $this->isEntry;
	}

	public function getCss(): ?array
	{
		return $this->css;
	}

	public function setCss(?array $css): void
	{
		$this->css = $css;
	}

	public function setAssets(?array $assets): void
	{
		$this->assets = $assets;
	}

	public function getAssets(): ?array
	{
		return $this->assets;
	}

	public function setImports(?array $imports): void
	{
		$this->imports = $imports;
	}

	public function setFile(?string $file): void
	{
		$this->file = $file;
	}

	public function setName(?string $name): void
	{
		$this->name = $name;
	}

	public function setDynamicImports(?array $dynamicImports): void
	{
		$this->dynamicImports = $dynamicImports;
	}

	public function setIsDynamicEntry(?bool $isDynamicEntry): void
	{
		$this->isDynamicEntry = $isDynamicEntry;
	}

	public function setIsEntry(?bool $isEntry): void
	{
		$this->isEntry = $isEntry;
	}

	public function setSrc(?string $src): void
	{
		$this->src = $src;
	}


	public function getImports(): array
	{
		return $this->imports;
	}

	public function getFile(): string
	{
		return $this->file;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function getDynamicImports(): array
	{
		return $this->dynamicImports;
	}

	public function getSrc(): string
	{
		return $this->src;
	}
}