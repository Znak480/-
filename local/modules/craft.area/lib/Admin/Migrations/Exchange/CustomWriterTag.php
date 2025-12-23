<?php

namespace Craft\Area\Admin\Migrations\Exchange;

use Sprint\Migration\Exchange\WriterTag;

class CustomWriterTag extends WriterTag
{
	private array $files = [];


	public function addFileWithParam(mixed $val, bool $multiple, array $param = []): void
	{
		if($multiple)
		{
			foreach($val as $val1)
			{
				$this->addFileTagWithParam($val1, $param);
			}
		} elseif($val)
		{
			$this->addFileTagWithParam($val, $param);
		}
	}

	public function addFileTagWithParam(int $fileId, array $param = []): void
	{
		$file = \CFile::GetFileArray($fileId);
		if(empty($file))
		{
			return;
		}

		$this->addValueTag(
			$file['SUBDIR'] . '/' . $file['FILE_NAME'],
			array_merge([
				'name'        => $file['ORIGINAL_NAME'],
				'description' => $file['DESCRIPTION'],
				'type'        => 'file',
			], $param)

		);

		$this->files[] = $file;
	}


	public function forgetFiles(): array
	{
		$tmp = $this->files;

		$this->files = [];

		return $tmp;
	}

	public function getFiles(): array
	{
		return $this->files;
	}
}