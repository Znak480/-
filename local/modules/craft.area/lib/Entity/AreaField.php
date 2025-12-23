<?php

namespace Craft\Area\Entity;

use Craft\Area\Dto\ComplexSettingsDto;

class AreaField extends EO_AreaField
{

	const BLOCK_TYPE_STRING = 'string';
	const BLOCK_TYPE_TEXT = 'text';
	const BLOCK_TYPE_HTML = 'html';
	const BLOCK_TYPE_IMAGE = 'image';
	const BLOCK_TYPE_COMPLEX = 'complex';

	public static function getTypeLabel(string $typeCode): ?string
	{
		$typeList = self::getBlockTypeList();
		if($typeList[$typeCode])
		{
			return $typeList[$typeCode];
		}

		return null;
	}

	public static function getBlockTypeList(): array
	{
		return [
			self::BLOCK_TYPE_STRING  => 'Строка',
			self::BLOCK_TYPE_IMAGE   => 'Картинка',
			self::BLOCK_TYPE_TEXT    => 'Текст',
			self::BLOCK_TYPE_HTML    => 'HTML - редактор',
			self::BLOCK_TYPE_COMPLEX => 'Составное свойство',
		];
	}

	public static function getRelateBlockTypeList(): array
	{
		return [
			self::BLOCK_TYPE_STRING,
			self::BLOCK_TYPE_TEXT,
			self::BLOCK_TYPE_HTML,
			self::BLOCK_TYPE_IMAGE,
		];
	}

	public function fillFromArray(array $data): void
	{
		foreach($data as $name => $value)
		{
			try
			{
				$this->set($name, $value);
			} catch(\Exception $exception)
			{
			}
		}
	}

	public function isImage(): bool
	{
		return $this->getType() === self::BLOCK_TYPE_IMAGE;
	}

	public function isComplex(): bool
	{
		return $this->getType() == self::BLOCK_TYPE_COMPLEX;
	}

	/**
	 * @return array|ComplexSettingsDto
	 */
	public function getSettingsEx()
	{
		$settings = parent::getSettings();
		$_settings = json_decode($settings, true);

		if($this->isComplex())
		{
			$_settings = json_decode($settings, true);

			return new ComplexSettingsDto(
				$_settings['name'],
				$_settings['code'],
				$_settings['field'],
				$_settings['required'],
			);
		}

		return $_settings;
	}
}