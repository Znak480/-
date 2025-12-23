<?php

namespace Craft\Area\Entity;

use Bitrix\Main\Diag\Debug;

class AreaContent extends EO_AreaContent
{

	public function setValueEx($value): void
	{

		$field = $this->getField();

		if(!$field && $this->hasField())
		{
			$field = $this->fillField();
		}

		if(!$field)
		{
			$field = AreaFieldTable::getByPrimary($this->getAreaBlockId())->fetchObject();
		}

		if(!$field)
		{
			return;
		}

		switch($field->getType())
		{
			case AreaField::BLOCK_TYPE_COMPLEX:

				$settings = $field->getSettingsEx();

				$_value = $value;
				$newValue = [];

				$index = 0;
				foreach($_value as $subValues)
				{
					foreach($subValues as $subField => $subValue)
					{
						if(empty($subValue))
						{
							break;
						}

						$currentSubField = $settings->gen($subField);
						if($currentSubField->isEqual(AreaField::BLOCK_TYPE_IMAGE))
						{
							$newValue[$index][$subField] = $subValue;
							if(is_array($subValue) && array_key_exists('tmp_name', $subValue))
							{
								$fileId = $this->storeFile($subValue, 'craft.area/' . $field->getType());
								if($fileId)
								{
									$newValue[$index][$subField] = $fileId;
								}
							}

							if(is_array($subValue) && array_key_exists('is_del', $subValue))
							{
								\CFile::Delete($subValue['ID']);
								$newValue[$index][$subField] = null;

							}
						} else
						{
							$newValue[$index][$subField] = $subValue;
						}

					}

					$index++;
				}

				if($newValue)
				{
					$value = $newValue;
				}

				break;
			case AreaField::BLOCK_TYPE_IMAGE:

				if(is_array($value) && !array_key_exists('tmp_name', $value)) # multiple
				{
					$_values = [];
					foreach($value as $fileData)
					{
						if(is_array($fileData) && !array_key_exists('tmp_name', $fileData))
						{
							continue;
						}

						$_values[] = $this->storeFile($fileData, 'craft.area/' . $field->getType());

					}

					if($_values)
					{
						$value = $_values;
					}

					$oldValue = $this->getValueEx();
					$_oldValueIdList = null;
					if($oldValue)
					{
						$_oldValueIdList = array_map(function($fileData) { return $fileData['ID']; }, $oldValue);
						$_oldValueIdList = array_filter($_oldValueIdList);
					}

					if($_oldValueIdList)
					{
						$value = array_merge($_oldValueIdList, $value);
					}

					$value = array_unique($value);

				} else if(is_array($value) && array_key_exists('tmp_name', $value)) # single
				{
					$value = $this->storeFile($value, 'craft.area/' . $field->getType());
				}


				# file delete logic
				if(is_array($value) && array_key_exists('is_del', $value))
				{
					$fileId = $value['ID'];
					\CFile::Delete($fileId);
					$value = null;

				} else if(is_array($value) && !array_key_exists('is_del', $value))
				{
					foreach($value as $index => $fileData)
					{
						if(!is_array($fileData) || ($fileData['is_del'] != 'Y' || empty($fileData['ID'])))
						{
							continue;
						}

						\CFile::Delete($fileData['ID']);
						unset($value[$index]);
					}
				}
				break;
		}


		$this->setValueSerialized($value);

	}

	public function setValueSerialized(mixed $value): AreaContent
	{
		return parent::setValue(serialize(['VALUE' => $value]));
	}

	protected function saveFile(array $fileData, $path)
	{
		$fileId = \CFile::SaveFile($fileData, $path);
		if($fileId)
		{
			return $fileId;
		}

		return null;
	}

	public function getValueEx()
	{
		$rawValue = $this->getValue();
		$_value = unserialize($rawValue);
		$value = $_value['VALUE'];

		if(empty($value))
		{
			return null;
		}


		$field = $this->getField();
		if(!$field)
		{
			$field = $this->fillField();
		}

		if(!$field)
		{
			return $value;
		}

		switch($field->getType())
		{
//			case AreaField::BLOCK_TYPE_COMPLEX:
//				if(!$field->getMultiple())
//				{
//					if(!empty($value[0]))
//					{
//						$value = $value[0];
//					}
//				}
//				break;
			case AreaField::BLOCK_TYPE_IMAGE:
				if($field->getMultiple())
				{
					if(is_array($value))
					{
						$value = array_map(function($fileId) {
							return \CFile::GetFileArray($fileId);
						}, $value);
					}
				} else
				{
					$value = \CFile::GetFileArray($value);
				}
				break;
		}


		return $value;
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

	protected function storeFile($rawFileData, $path = ''): ?int
	{
		$rawFile = \CIBlock::makeFileArray($rawFileData);
		if($rawFile)
		{
			$fileId = $this->saveFile($rawFile, $path);
			if($fileId)
			{
				return $fileId;
			}
		}

		return null;
	}
}