<?php

namespace Craft\Orm;

class SearchSynonym extends EO_SearchSynonym
{

	public function setSearchItemsEx(array $items): SearchSynonym
	{
		$this->setSearchItems(json_encode($items));
		return $this;
	}

	/**
	 * @return array<int,string>
	 */
	public function getSearchItemsEx(): array
	{
		$jsonItems = json_decode($this->getSearchItems(), true);
		return $jsonItems ?? [];
	}

}