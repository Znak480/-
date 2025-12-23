<?php

namespace Craft\Area\Entity;

class Area extends EO_Area
{
	private $_container = [];
	private $_position = 0;

	public function getContentEditAreaLink(): string
	{
		return sprintf(JEDI_AREA_ADMIN_URL_EDIT_CONTENT . '?ID=%s&lang=%s&bxpublic=Y', $this->getId(), LANG);
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
}