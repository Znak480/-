<?php

namespace Craft\Area\Dto;

class ComplexSettingsDto
{

	protected $required;
	protected $name;
	protected $code;
	protected $field;

	public function __construct(
		$name,
		$code,
		$field,
		$required
	)
	{
		$this->name = $name;
		$this->code = $code;
		$this->field = $field;
		$this->required = $required;
	}

	public function getField()
	{
		return $this->field;
	}

	public function getCode()
	{
		return $this->code;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getRequired()
	{
		return $this->required;
	}

	public function gen(string $fieldCode): ?ComplexSettingsDto
	{
		foreach($this->getCode() as $index => $code)
		{
			if($code == $fieldCode)
			{
				try
				{
					$name = $this->getName()[$index];
					$required = $this->getRequired()[$index];
					$field = $this->getField()[$index];

					return new static(
						$name,
						$code,
						$field,
						$required,
					);
				} catch(\Exception $exception)
				{
					return null;
				}
			}
		}

		return null;
	}

	public function isEqual(string $fieldType): bool
	{
		if(is_array($this->getField()))
		{
			return false;
		}
		return $fieldType == $this->getField();
	}
}