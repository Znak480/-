<?php

namespace Craft\Core\Helper;

class DtoManager
{

	const TYPE_SNAKE_CASE = 'snake_case';

	public function toArray(): array
	{
		$result = [];
		$objectKeys = json_decode(json_encode($this), true);

		foreach($objectKeys as $objectKey => $objectValue)
		{
			$result[$this->transformKeyToUpper($objectKey)] = $objectValue;
		}

		return $result;
	}

	/**
	 * @param array<string, string> $data
	 */
	public static function fromArray(array $data)
	{
		$obj = new static();

		foreach($data as $key => $value)
		{
			switch($obj->analyzeVariable($key))
			{
				case self::TYPE_SNAKE_CASE:
					$key = $obj->fromSnakeCaseToCamelCase($key);
					break;
			}

			$methodName = 'set' . ucfirst($key);

			if(method_exists(static::class, $methodName))
			{
				call_user_func([$obj, $methodName], $value);
			}

		}

		return $obj;
	}

	public function analyzeVariable(string $key): ?string
	{
		if(strpos($key, '_') !== false)
		{
			return self::TYPE_SNAKE_CASE;
		}

		return null;
	}

	public function fromSnakeCaseToCamelCase(string $key): string
	{
		$splitKeyParts = explode('_', $key);
		foreach($splitKeyParts as $index => &$keyPart)
		{
			if($index > 0)
			{
				$keyPart = ucfirst($keyPart);
			}
		}

		return implode('', $splitKeyParts);
	}


	/**
	 * Return key => KEY, some_key => SOME_KEY, someKey => SOME_KEY
	 */
	public function transformKeyToUpper(string $key): string
	{
		$words_splited = preg_split('/(?=[A-Z])/', $key);
		$words_capitalized = array_map("ucfirst", $words_splited);
		return strtoupper(implode("_", $words_capitalized));
	}
}