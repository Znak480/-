<?php

namespace Craft\Core\Services\Archive;

class BitrixZipArchive extends DevZipArchive
{
	private array $fileIdList;

	public function setFileIdList(array $fileIdList): void
	{
		$this->fileIdList = $fileIdList;
	}

	public function getFileIdList(): array
	{
		return $this->fileIdList;
	}

	public function getArchiveDirectory(): ?string
	{
		if(!$this->archiveDirectory)
		{
			$this->setArchiveDirectory($_SERVER['DOCUMENT_ROOT'].'/upload/zip/files');
		}

		return $this->archiveDirectory;
	}

	public function archive(): void
	{
		if(!$this->getFileIdList())
		{
			return;
		}

		$files = array_map(function ($fileId) {

			$file = \CFile::GetFileArray($fileId);

			if($file)
			{
				return $file['SRC'];
			}

			return NULL;
		}, $this->getFileIdList());

		$files = array_filter($files);

		$this->setFileNames($files);

		parent::archive();
	}

}