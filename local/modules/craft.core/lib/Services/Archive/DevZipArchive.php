<?php

namespace Craft\Core\Services\Archive;

use ZipArchive;

class DevZipArchive
{

	protected array   $fileNames        = [];
	protected ?string $archiveFileName  = NULL;
	protected ?string $archiveDirectory = NULL;

	public function archive(): void
	{
		if(!$this->prepareArchiveDirectory())
		{
			return;
		}

		$zip = new ZipArchive();
		if($zip->open($this->getArchivePath(), ZIPARCHIVE::CREATE) !== true)
		{
			exit("cannot open <".$this->getArchivePath().">\n");
		}

		foreach($this->getFileNames() as $files)
		{
			$zip->addFile($_SERVER['DOCUMENT_ROOT'].$files, $files);
		}

		$save = $zip->close();
	}

	public function download(bool $isClearAfterDownload = false): void
	{
		header("Content-type: application/zip");
		header("Content-Disposition: attachment; filename=".$this->getArchiveFileName());
		header("Content-length: ".filesize($this->getArchivePath()));
		header("Pragma: no-cache");
		header("Expires: 0");
		readfile($this->getArchivePath());

		if($isClearAfterDownload)
		{
			$this->clear();
		}

		exit;
	}

	protected function clear(): void
	{
		if(is_file($this->getArchivePath()))
		{
			unlink($this->getArchivePath());
		}
	}

	protected function prepareArchiveDirectory(): bool
	{
		if(is_dir($this->getArchiveDirectory()))
		{
			return true;
		}

		return mkdir($this->getArchiveDirectory(), 0777, true);
	}

	protected function getArchivePath(): string
	{
		return $this->getArchiveDirectory().'/'.$this->getArchiveFileName();
	}

	public function getArchiveFileName(): ?string
	{
		if(!$this->archiveFileName)
		{
			$this->setArchiveFileName(time());
		}

		return $this->archiveFileName.'_archive.zip';
	}

	public function getFileNames(): array
	{
		return $this->fileNames;
	}

	public function getArchiveDirectory(): ?string
	{
		if(!$this->archiveDirectory)
		{
			$this->setArchiveDirectory($_SERVER['DOCUMENT_ROOT'].'/zip/files');
		}

		return $this->archiveDirectory;
	}

	public function setArchiveFileName(string $archiveFileName): void
	{
		$this->archiveFileName = $archiveFileName;
	}

	public function setFileNames(array $fileNames): void
	{
		$this->fileNames = $fileNames;
	}

	public function setArchiveDirectory(string $archiveDirectory): void
	{
		$this->archiveDirectory = $archiveDirectory;
	}
}