<?php

use Craft\Core\Dto\ManifestDto;
use Bitrix\Main\Page\Asset;
use Craft\Core\Dto\ManifestBlockDto;

class CraftViteComponent extends CBitrixComponent
{

	protected ?Asset $assets;
	protected ?ManifestDto $manifestList;

	public function onPrepareComponentParams($arParams)
	{
		$arParams['SOURCE'] = $arParams['SOURCE'] ?? 'index.html';
		$arParams['ID'] = $this->generateRandomString();
		$arParams['PROPS'] = is_array($arParams['PROPS']) ? $arParams['PROPS'] : [];

		return $arParams;
	}

	public function executeComponent()
	{

		$this->assets = Asset::getInstance();

		try
		{
			$this->modules(['craft.core']);

			$this->readManifest();

			$this->loadCore();

			/*
			$manifestBlock = $this->findManifestBlock($this->arParams['SOURCE']);
			if(!$manifestBlock)
			{
				throw new \Exception("Manifest not found");
			}
			$this->loadManifest($manifestBlock);
			*/

			$this->includeComponentTemplate();
		} catch(Exception $e)
		{
			echo $e->getMessage();
			return;
		}
	}

	protected function findManifestBlock(string $blockKey): ?ManifestBlockDto
	{
		$manifest = $this->manifestList->getBlockByName($blockKey);
		if(!$manifest)
		{
			return null;
		}

		return $manifest;
	}

	protected function loadCore(): void
	{
		$js = $this->manifestList->getCoreJs();
		if($js)
		{
			$this->loadManifest($js);
		}

		$css = $this->manifestList->getCoreCss();
		if($css)
		{
			$this->loadManifest($css);
		}
	}


	protected function readManifest(): void
	{
		if(empty($this->manifestList))
		{
			$content = file_get_contents($this->getManifestPath());
			if(!$content || mb_strlen($content) == 0)
			{
				throw new Exception('Manifest file is empty');
			}

			$manifestJson = json_decode($content, true);
			$this->manifestList = ManifestDto::fromJson($manifestJson);
		}
	}

	protected function loadManifest(ManifestBlockDto $manifest): void
	{
		if($manifest->getImports())
		{
			foreach($manifest->getImports() as $import)
			{
				$importManifestBlock = $this->findManifestBlock($import);
				if($importManifestBlock)
				{
					$this->loadManifest($importManifestBlock);
				}
			}
		}

		if($manifest->getFile() && !$manifest->isCss())
		{
			if($manifest->getIsDynamicEntry())
			{
				$this->assets->addString('<script type="module" src="' . $this->viteDir() . '/dist/' . $manifest->getFile() . '"></script>');

			} else
			{
				$this->assets->addJs($this->viteDir() . '/dist/' . $manifest->getFile());
			}
		}

		if($manifest->getCss())
		{
			foreach($manifest->getCss() as $css)
			{
				$this->assets->addCss($this->viteDir() . '/dist/' . $css);
			}
		}

		if($manifest->isCss())
		{
			$this->assets->addCss($this->viteDir() . '/dist/' . $manifest->getFile());
		}

		$this->includeAssets($manifest);
	}

	protected function includeAssets(ManifestBlockDto $manifestBlock): void
	{
		if(!$manifestBlock->getAssets())
		{
			return;
		}

		$assets = Asset::getInstance();

		foreach($manifestBlock->getAssets() as $asset)
		{
			if($asset->isFont())
			{
				$assets->addString('<link rel="preload" as="font" type="font/' . $asset->getExtension() . '" href="' . $this->viteDir() . '/dist/' . $asset->getFile() . '" crossorigin="anonymous">');
			}
		}
	}


	protected function modules(array $modules): void
	{
		foreach($modules as $module)
		{
			if(!\Bitrix\Main\Loader::includeModule($module))
			{
				throw new Exception('Module "' . $module . '" not found');
			}
		}
	}

	protected function viteDir(): string
	{
		return '/local/markup/vuetify';
	}

	protected function getManifestPath(): string
	{
		return $_SERVER['DOCUMENT_ROOT'] . $this->viteDir() . '/dist/.vite/manifest.json';
	}

	function generateRandomString($length = 10): string
	{
		return substr(str_shuffle(str_repeat($x = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
	}
}