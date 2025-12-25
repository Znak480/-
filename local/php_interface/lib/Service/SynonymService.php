<?php

namespace Craft\Service;

class SynonymService
{

	public function __construct(
		protected SynonymSearchEngine $searchEngine
	)
	{
	}

	/**
	 * @return array<int, string>
	 */
	public function findSynonyms(string $phrase): array
	{
		$synonyms = [];
		$models = $this->searchEngine->findAllByPhrase($phrase);

		foreach($models as $model)
		{
			$synonyms = array_merge($synonyms, $model->getSearchItemsEx());
		}

		return $synonyms;
	}
}