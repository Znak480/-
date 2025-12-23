<?php

namespace Craft\Core\Component;

use Bitrix\Main\Component\ParameterSigner;
use Bitrix\Main\Engine\ActionFilter\Csrf;
use Bitrix\Main\Engine\ActionFilter\HttpMethod;
use CFile;
use Bitrix\Main\Errorable;
use Bitrix\Main\Engine\Contract\Controllerable;
use Craft\Core\Helper\PostRequestFileHelper;
use Craft\Core\Exceptions\Component\SaveFileException;
use Craft\Core\Exceptions\Component\ValidateException;
use Craft\Core\Exceptions\Component\EventErrorExecption;
use Craft\Core\Exceptions\Component\SaveElementException;

abstract class AjaxComponent extends LoadableComponent implements Controllerable, Errorable
{
	protected array $uploadedFileIdList = [];

	public function onPrepareComponentParams($arParams)
	{
		$arParams = parent::onPrepareComponentParams($arParams);

		$arParams['SUCCESS_MESSAGE'] = $arParams['SUCCESS_MESSAGE'] ? $arParams['SUCCESS_MESSAGE'] : 'Форма успешно отправлена';
		$arParams['IBLOCK_ID'] = intval($arParams['IBLOCK_ID']);
		return $arParams;
	}


	protected function getUploadDir(): string
	{
		return 'developForm';
	}

	public function configureActions()
	{
		return [
			'execute' => [
				'prefilters' => [
					new HttpMethod(
						[HttpMethod::METHOD_POST]
					),
					new Csrf(),
				],
			],
		];
	}

	public function executeAction($signedParameters = '')
	{
		$componentParams = [];
		if($signedParameters)
		{
			$componentParams = ParameterSigner::unsignParameters($this->getName(), $signedParameters);
		}
		$template = $componentParams['TEMPLATE'] ?? null;

		try
		{
			$this->load();

			$this->validateCsrf();
			$this->prepareFiles();
			$this->handleRequest();

		} catch(\Exception $exception)
		{
			$this->cleanUploadFiles();

			$this->addError('system_error', $exception->getMessage());

			return [
				'template' => $this->renderHtml('template', $template),
			];
		}


		return [
			'template' => $this->renderHtml('success', $template),
		];
	}

	/**
	 * @return void
	 * @throws SaveElementException
	 * @throws ValidateException
	 * @throws \Craft\Core\Exceptions\Component\CaptchaValidateException
	 * @throws EventErrorExecption
	 */
	public function handleRequest()
	{
		$postData = $this->getFormData();

		$this->attachFilesToProperties($postData);

		$this->validateCaptcha($postData);

		$this->_validate($postData);


		if($this->hasErrors())
		{
			throw new \Exception('Error');
		}

		$this->_store($postData);

		$this->sendMail();
	}

	protected function attachFilesToProperties(array &$formData): void
	{
		if(!$this->getUploadedFileIdList())
		{
			return;
		}

		$allProperties = $this->loadProperties();

		$filePropertyList = array_filter($allProperties, function($property) {
			return $property['PROPERTY_TYPE'] == 'F';
		});

		foreach($filePropertyList as $property)
		{
			$propertyCode = $property['CODE'];

			if($fileIdList = $this->getUploadedFileIdListByPropertyCode($propertyCode))
			{
				if($property['MULTIPLE'] == 'Y')
				{
					$formData[$propertyCode] = $fileIdList;
				} else
				{
					$formData[$propertyCode] = $fileIdList[0];
				}

			}
		}
	}

	public function value(string $code): ?string
	{
		$formData = $this->getFormData();

		if(!empty($formData[$code]))
		{
			return $formData[$code];
		}

		return null;
	}

	protected function getFormData(): array
	{
		return $this->request->getPostList()->toArray();
	}

	protected function prepareFiles(): void
	{
		if(!$_FILES)
		{
			return;
		}

		$_files = PostRequestFileHelper::prepareFileData();

		if(!$_files)
		{
			return;
		}

		$errors = [];
		foreach($_files as $propertyCode => $fileData)
		{
			foreach($fileData as $file)
			{
				$fileId = \CFile::SaveFile($file, $this->getUploadDir());
				if(!$fileId)
				{
					$errors[] = $file['name'];
				} else
				{
					$this->addUploadedFileId($propertyCode, $fileId);
				}
			}
		}

		if($errors)
		{
			throw new SaveFileException(implode(PHP_EOL, array_map(function($error) {
				return 'Ошибка сохранения файла: ' . $error;
			}, $errors)));
		}
	}

	public function addUploadedFileId(string $code, int $fileId): void
	{
		$this->uploadedFileIdList[$code][] = $fileId;
	}

	public function getUploadedFileIdList(): array
	{
		return $this->uploadedFileIdList;
	}

	protected function getUploadedFileIdListByPropertyCode(string $propertyCode): array
	{
		$fileIdList = [];

		if(array_key_exists($propertyCode, $this->getUploadedFileIdList()))
		{
			$fileIdList = $this->getUploadedFileIdList()[$propertyCode];
		}

		return $fileIdList;
	}

	protected function getAllFileIdList(): array
	{
		$fileIdList = [];
		foreach($this->getUploadedFileIdList() as $propertyCode => $_fileIdList)
		{
			$fileIdList = array_merge($fileIdList, $_fileIdList);
		}
		return $fileIdList;
	}

	protected function cleanUploadFiles(): void
	{
		foreach($this->getAllFileIdList() as $fileId)
		{
			CFile::Delete($fileId);
		}
	}
}