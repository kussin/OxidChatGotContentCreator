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

        // CMS CONTENT
        self::_addCmsContent();
    }

    private static function _addMissingConfigurationFields(): void
    {
        self::_updateOxvendor();
        self::_updateOxmanufacturers();
        self::_updateOxarticles();
        self::_updateOxcategories();
    }

    private static function _addCmsContent(): void
    {
        self::_addDisclaimer();
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

    private static function _hasDbEntry($sTable, $sOxid): bool
    {
        $sQuery = "SELECT * FROM `$sTable` WHERE OXID LIKE '$sOxid';";
        $oResult = DatabaseProvider::getDb()->getAll($sQuery);

        return ($oResult == FALSE) ? FALSE : TRUE;
    }

    private static function _createProcessQueue(): void
    {
        if (!self::_hasDbTable('kussin_chatgpt_content_creator_queue')) {
            $sQuery = file_get_contents(__DIR__ . '/../sql/insert.sql');
            DatabaseProvider::getDb()->execute($sQuery);
        }
    }

    private static function _addDisclaimer(): void
    {
        if (!self::_hasDbEntry('oxcontents', 'kussin_chatgpt_disclaimer')) {
            $sQuery = file_get_contents(__DIR__ . '/../sql/disclaimer.sql');
            DatabaseProvider::getDb()->execute($sQuery);
        }
    }

    private static function _updateOxvendor(): void
    {
        self::_addNewColumn(
            'oxvendor',
            [
                array(
                    'name' => 'KUSSINCHATGPTGENERATED',
                    'settings' => 'TINYINT(1) NULL DEFAULT \'0\' COMMENT \'KUSSIN ChatGPT generated flag\'',
                )
            ]
        );
    }

    private static function _updateOxmanufacturers(): void
    {
        self::_addNewColumn(
            'oxmanufacturers',
            [
                array(
                    'name' => 'KUSSINCHATGPTGENERATED',
                    'settings' => 'TINYINT(1) NULL DEFAULT \'0\' COMMENT \'KUSSIN ChatGPT generated flag\'',
                )
            ]
        );
    }

    private static function _updateOxcategories(): void
    {
        self::_addNewColumn(
            'oxcategories',
            [
                array(
                    'name' => 'KUSSINCHATGPTGENERATED',
                    'settings' => 'TINYINT(1) NULL DEFAULT \'0\' COMMENT \'KUSSIN ChatGPT generated flag\'',
                )
            ]
        );
    }

    private static function _updateOxarticles(): void
    {
        self::_addNewColumn(
            'oxarticles',
            [
                array(
                    'name' => 'KUSSINCHATGPTGENERATED',
                    'settings' => 'TINYINT(1) NULL DEFAULT \'0\' COMMENT \'KUSSIN ChatGPT generated flag\'',
                )
            ]
        );
    }

}
