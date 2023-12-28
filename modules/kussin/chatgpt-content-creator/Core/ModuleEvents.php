<?php

declare(strict_types=1);

namespace Kussin\ChatGpt\Core;

use OxidEsales\Eshop\Core\DatabaseProvider;

final class ModuleEvents
{
    public static function onActivate(): void
    {
        // INITIONALIZE
        self::_createProcessQueue();

        // UPDATE
        self::_addMissingConfigurationFields();
    }

    private static function _addMissingConfigurationFields(): void
    {
    }

    private static function _hasDbTable($sTable): bool
    {
        $sQuery = "SHOW TABLES LIKE '$sTable';";
        $oResult = DatabaseProvider::getDb()->getAll($sQuery);

        return ($oResult == FALSE) ? FALSE : TRUE;
    }

    private static function _hasDbTableColumn($sTable, $sColumn): bool
    {
        $sQuery = "SHOW COLUMNS FROM `$sTable` LIKE '$sColumn';";
        $oResult = DatabaseProvider::getDb()->getAll($sQuery);

        return ($oResult == FALSE) ? FALSE : TRUE;
    }

    private static function _addNewColumn($sTable, $aColumns): void
    {
        foreach ($aColumns as $aColumn) {
            $sName = $aColumn['name'];
            $sSettings = $aColumn['settings'];

            if (!self::_hasDbTableColumn($sTable, $sName)) {
                $sQuery = "ALTER TABLE `$sTable` ADD COLUMN `$sName` $sSettings;";
                DatabaseProvider::getDb()->execute($sQuery);
            }
        }
    }

    private static function _createProcessQueue(): void
    {
        if (!self::_hasDbTable('kussin_chatgpt_content_creator_queue')) {
            $sQuery = file_get_contents(__DIR__ . '/../sql/insert.sql');
            DatabaseProvider::getDb()->execute($sQuery);
        }
    }

}
