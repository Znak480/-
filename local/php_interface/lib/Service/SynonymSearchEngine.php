<?php

namespace Craft\Service;

use Craft\Orm\EO_SearchSynonym_Collection;
use Craft\Orm\SearchSynonymTable;

class SynonymSearchEngine
{
	public function findAllByPhrase(string $phrase): EO_SearchSynonym_Collection
	{
		return $this->findByJson(
			SearchSynonymTable::F_SEARCH_ITEMS,
			$phrase
		);
	}

	public function findByJson(string $col, string $value): EO_SearchSynonym_Collection
	{
		$query = SearchSynonymTable::query();

		$prepareValue = str_replace('\\', '\\\\\\', json_encode($value));

		$query->whereLike($col, '%' . $prepareValue . '%');

		return $query->fetchCollection();
	}

	public function findAll(array $filter = []): EO_SearchSynonym_Collection
	{
		return SearchSynonymTable::getList([
			'filter' => $filter,
		])->fetchCollection();
	}

}