<?php

namespace Sprint\Migration;


class OrmDeleteSearchTextCol20251111121725 extends Version
{
	protected $author = "mirko";

	protected $description = "";

	protected $moduleVersion = "4.18.1";

	public function up()
	{
		$sql = "ALTER TABLE `craft_search_synonym`
DROP `SEARCH_TEXT`,
CHANGE `UPDATED_AT` `UPDATED_AT` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP AFTER `CREATED_AT`;";

		global $DB;

		$DB->Query($sql);
	}

	public function down()
	{
		//your code ...
	}
}
