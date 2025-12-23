<?php

namespace Craft\Core\Component;

use Bitrix\Main\Component\ParameterSigner;
use Bitrix\Main\Diag\Debug;
use Bitrix\Main\Error;
use Bitrix\Main\ErrorCollection;
use Bitrix\Main\Event;
use Bitrix\Main\EventResult;
use Craft\Core\Component\Helper\AjaxComponentHelper;
use Craft\Core\Component\Security\Csrf;
use Craft\Core\Exceptions\Component\CsrfValidateException;
use Craft\Core\Exceptions\Component\EventErrorExecption;

abstract class BaseComponent extends \CBitrixComponent
{
	protected ErrorCollection $errorCollection;

	public function __construct($component = null)
	{
		parent::__construct($component);
		$this->errorCollection = new ErrorCollection();
	}

	public function getErrors(): array
	{
		return $this->errorCollection->toArray();
	}

	public function getErrorByCode($code): Error
	{
		return $this->errorCollection->getErrorByCode($code);
	}

	abstract public function handleRequest();

	abstract function componentNamespace(): string;

	abstract protected function attachFilesToProperties(array &$formData): void;

	abstract protected function validateCaptcha(array $formData): void;

	abstract protected function sendMail(array $mailFields = []): void;

	abstract protected function validate(array $postData): void;

	abstract protected function loadModules(): void;

	abstract protected function load(): void;

	abstract public function executeAction();

	abstract protected function store(array $formData): void;

	protected function _validate(array $formData)
	{
		$this->validate($formData);

		$event = new Event($this->componentNamespace(), 'afterValidate', [
			$this->arParams['FORM_KEY'],
			$formData,
		]);
		$event->send();
		foreach($event->getResults() as $result)
		{
			switch($result->getType())
			{
				case EventResult::ERROR:
					$this->errorCollection->add([new Error('Event `afterValidate` has errors')]);
					break;
			}
		}
	}

	protected function _store(array $formData): void
	{
		$event = new Event($this->componentNamespace(), 'beforeElementAdd', [
			$this->arParams['FORM_KEY'],
			$formData,
		]);
		$event->send();
		foreach($event->getResults() as $result)
		{

			switch($result->getType())
			{
				case EventResult::ERROR:
					throw new EventErrorExecption('Event `beforeElementAdd` has errors');

				case EventResult::SUCCESS:
					$formData = array_merge($formData, $result->getParameters());
					break;
			}

		}

		$this->store($formData);


		$event = new Event($this->componentNamespace(), 'afterElementAdd', [
			$this->arParams['FORM_KEY'],
			$formData,
		]);
		$event->send();
		foreach($event->getResults() as $result)
		{
			switch($result->getType())
			{
				case EventResult::ERROR:
					throw new EventErrorExecption('Event `afterElementAdd` has errors');
			}
		}
	}

	public function executeComponent()
	{
		try
		{
			$this->prepareAjax();
			$this->load();
		} catch(\Exception $exception)
		{
			return;
		}

		$this->includeComponentTemplate();
	}

	protected function prepareAjax(): void
	{
		$this->arResult['SIGN_COMPONENT_PARAMS'] = ParameterSigner::signParameters($this->getName(), array_merge($this->arParams, ['TEMPLATE' => $this->getTemplateName()]));
	}

	public function label(string $propertyCode): ?string
	{
		$label = null;

		$property = $this->takeProperty($propertyCode);
		if($property)
		{
			$label = $property['NAME'];
		}

		return $label;
	}

	public function error(string $code): ?string
	{
		$error = $this->errorCollection->getErrorByCode($code);
		if(!$error)
		{
			return null;
		}

		return $error->getMessage();
	}

	protected function hasErrors(): bool
	{
		return !$this->errorCollection->isEmpty();
	}

	protected function addError(string $code, string $message, $customData = null): void
	{
		$this->errorCollection->add([new Error($message, $code, $customData)]);
	}

	protected function addValidationError(string $code, string $message): void
	{
		$this->addError($code, $message, 'validation');
	}

	protected function takeProperty(string $propertyCode): ?array
	{
		$property = null;

		if($this->arResult['PROPERTIES'][$propertyCode])
		{
			$property = $this->arResult['PROPERTIES'][$propertyCode];
		}

		return $property;
	}


	/**
	 * @return void
	 * @throws CsrfValidateException
	 */
	protected function validateCsrf(): void
	{
		$token = $this->request->getPost('_csrf');
		if(!$token)
		{
			if(!check_bitrix_sessid())
			{
				throw new CsrfValidateException();
			}
		} else
		{
			if(!Csrf::getInstance()->validateToken($token))
			{
				throw new CsrfValidateException();
			}
		}
	}

	protected function renderHtml($page = 'template', string $templateName = null): string
	{
		ob_start();

		if($templateName)
		{
			$this->setTemplateName($templateName);
		}

		$this->includeComponentTemplate($page);
		return ob_get_clean();
	}

	/**
	 * @see loadListProperties
	 */
	public function getDictionary(string $code): array
	{
		$enumList = [];

		if(array_key_exists($code, $this->arResult['LIST_DICTIONARY']))
		{
			$enumList = $this->arResult['LIST_DICTIONARY'][$code];
		}

		return $enumList;
	}

	protected function _loadData(): void
	{
		$this->iblockData();
		$this->loadData();
	}

	protected function iblockData(): void
	{
		if($this->arParams['IBLOCK_ID'])
		{
			$this->arResult['PROPERTIES'] = $this->loadProperties();
			$this->arResult['LIST_DICTIONARY'] = $this->loadListProperties();
		}
	}

	protected function loadListProperties(): array
	{
		if(!$this->arParams['IBLOCK_ID'])
		{
			return [];
		}

		$enumDictionary = [];
		$allPropertyList = $this->loadProperties();
		$cache = \Bitrix\Main\Data\Cache::createInstance();

		if($cache->initCache($this->getCacheTTL(), md5(__METHOD__ . __CLASS__)))
		{
			$enumDictionary = $cache->getVars();
		} elseif($cache->startDataCache())
		{
			$propertyEnumList = array_filter($allPropertyList, function($property) {
				return $property['PROPERTY_TYPE'] == 'L';
			});

			if($propertyEnumList)
			{
				foreach($propertyEnumList as $propertyCode => $property)
				{
					$enumListQuery = \CIBlockPropertyEnum::GetList(
						[
							'SORT' => 'ASC',
						],
						[
							'CODE'      => $propertyCode,
							'IBLOCK_ID' => $this->arParams['IBLOCK_ID'],
						]
					);

					$enumDictionary[$propertyCode][] = [
						'ID'     => null,
						'VALUE'  => null,
						'XML_ID' => null,
						'DEF'    => null,
						'LABEL'  => 'Не выбранно',
					];

					while($enum = $enumListQuery->fetch())
					{
						$enumDictionary[$propertyCode][] = [
							'ID'     => $enum['ID'],
							'VALUE'  => $enum['VALUE'],
							'LABEL'  => $enum['VALUE'],
							'XML_ID' => $enum['XML_ID'] ?? null,
							'DEF'    => $enum['DEF'],
						];
					}
				}
			}

			$cache->endDataCache($enumDictionary);
		}

		return $enumDictionary;
	}

	protected function loadProperties(): array
	{
		if(!$this->arParams['IBLOCK_ID'])
		{
			return [];
		}

		$properties = [];
		$cache = \Bitrix\Main\Data\Cache::createInstance();
		if($cache->initCache($this->getCacheTTL(), md5(__CLASS__ . __METHOD__)))
		{
			$properties = $cache->getVars();
		} elseif($cache->startDataCache())
		{
			$propertiesQuery = \CIBlockProperty::GetList(
				[
					'SORT' => 'ASC',
				],
				[
					'ACTIVE'    => 'Y',
					'IBLOCK_ID' => $this->arParams['IBLOCK_ID'],
				]
			);


			while($property = $propertiesQuery->GetNext())
			{
				$properties[$property['CODE']] = [
					'ID'            => $property['ID'],
					'NAME'          => $property['NAME'],
					'ACTIVE'        => $property['ACTIVE'],
					'PROPERTY_TYPE' => $property['PROPERTY_TYPE'],
					'CODE'          => $property['CODE'],
					'XML_ID'        => $property['XML_ID'],
					'IS_REQUIRED'   => $property['IS_REQUIRED'],
					'MULTIPLE'      => $property['MULTIPLE'],
					'SETTINGS'      => is_array($property['USER_TYPE_SETTINGS']) ? $property['USER_TYPE_SETTINGS'] : [],
				];
			}

			$cache->endDataCache($properties);
		}

		return $properties;
	}
}