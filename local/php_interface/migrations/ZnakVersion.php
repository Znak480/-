<?php
namespace Znak\Migration;

use Sprint\Migration\Version;

abstract class ZnakMigration extends Version{
    /**
     * Проверяет, выполнена ли миграция по её имени класса.
     *
     * @param string $versionName Имя класса миграции, например, 'AddGalleryPropertyInCatalogsIBlock20260506142600'.
     * @return bool
     */
    protected function isComplitedMigration(string $versionName){
        global $DB;
        
        $tableName = $this->getConfigParam('migration_table') ?: 'sprint_migration_versions';

        $sql = "SELECT VERSION FROM `{$tableName}` 
                WHERE VERSION = '" . $DB->ForSql($versionName) . "'";

        $result = $DB->Query($sql);

        return (bool) $result->Fetch();
    }

}
?>