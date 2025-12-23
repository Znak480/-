<?php

namespace Craft\Core\Component;

use Bitrix\Main\Loader;
use Craft\Core\Exceptions\Component\NotInstalledModuleException;

abstract class LoadableComponent extends MailedComponent
{
	/**
	 * @throws \Exception
	 */
	protected function load(): void
	{
		try
		{
			$this->loadModules();
		} catch(\Exception $exception)
		{
			return;
		}

		$this->loadServices();

		$this->_loadData();
	}

	protected function loadModules(): void
	{
		$modules = $this->modules();

		if(!is_array($modules))
		{
			return;
		}

		foreach($modules as $module)
		{
			if(!Loader::includeModule($module))
			{
				throw new NotInstalledModuleException('Модуль ' . $module . ' не подключен');
			}
		}
	}

	abstract protected function modules(): ?array;

	abstract protected function loadData(): void;

	abstract public function loadServices(): void;
}