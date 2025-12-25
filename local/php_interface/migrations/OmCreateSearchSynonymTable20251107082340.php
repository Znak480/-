<?php

namespace Sprint\Migration;


class OmCreateSearchSynonymTable20251107082340 extends Version
{
    protected $author = "mirko";

    protected $description = "";

    protected $moduleVersion = "4.18.1";

    public function up()
    {
		global $DB;

		$sql = "CREATE TABLE `craft_search_synonym` (
  `ID` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `SEARCH_TEXT` varchar(255) COLLATE 'utf8mb4_general_ci' NOT NULL,
  `SEARCH_ITEMS` longtext COLLATE 'utf8mb4_general_ci' NOT NULL,
  `CREATED_AT` datetime NOT NULL,
  `UPDATED_AT` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE='InnoDB' COLLATE 'utf8mb4_general_ci';";

		$DB->Query($sql);
    }

    public function down()
    {
    }
}
