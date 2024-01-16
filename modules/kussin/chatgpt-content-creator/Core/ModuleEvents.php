<?php

declare(strict_types=1);

namespace Kussin\ChatGpt\Core;

use OxidEsales\Eshop\Core\DatabaseProvider;
use OxidEsales\Eshop\Core\Registry;

final class ModuleEvents
{
    public static function onActivate(): void
    {
        // REGISTER MODULE
        self::_register();

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
                ),
            ]
        );
    }

    private static function _updateOxmanufacturers(): void
    {
        self::_addNewColumn(
            'oxmanufacturers',
            [
                array(
                    'name' => 'KUSSINLONGDESC',
                    'settings' => 'LONGTEXT NOT NULL DEFAULT \'\' COMMENT \'KUSSIN ChatGPT Long Description\' COLLATE \'utf8_general_ci\'',
                ),
                array(
                    'name' => 'KUSSINLONGDESC_1',
                    'settings' => 'LONGTEXT NOT NULL DEFAULT \'\' COMMENT \'KUSSIN ChatGPT Long Description 1\' COLLATE \'utf8_general_ci\'',
                ),
                array(
                    'name' => 'KUSSINLONGDESC_2',
                    'settings' => 'LONGTEXT NOT NULL DEFAULT \'\' COMMENT \'KUSSIN ChatGPT Long Description 2\' COLLATE \'utf8_general_ci\'',
                ),
                array(
                    'name' => 'KUSSINLONGDESC_3',
                    'settings' => 'LONGTEXT NOT NULL DEFAULT \'\' COMMENT \'KUSSIN ChatGPT Long Description 3\' COLLATE \'utf8_general_ci\'',
                ),
                array(
                    'name' => 'KUSSINCHATGPTGENERATED',
                    'settings' => 'TINYINT(1) NULL DEFAULT \'0\' COMMENT \'KUSSIN ChatGPT generated flag\'',
                ),
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
                ),
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
                ),
            ]
        );
    }

    private static function _register($sLicenseFile = 'modules/kussin/chatgpt-content-creator/license.txt', $iTimeout = 500): void
    {
        try {
            // CREATE LICENSE FILE
            $sFilename = str_replace('//', '/', Registry::getConfig()->getConfigParam('sShopDir') . '/' . $sLicenseFile);
            if (!file_exists($sFilename)) {
                touch($sFilename);
            }

            // CLIENT ADDRESS
            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $sClientIp = $_SERVER['HTTP_CLIENT_IP'];

            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $sClientIp = $_SERVER['HTTP_X_FORWARDED_FOR'];

            } else {
                $sClientIp = $_SERVER['REMOTE_ADDR'];
            }

            // RESISTER MODULE
            $rCurl = curl_init('https://register.kussin-module.de/');
            curl_setopt($rCurl, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($rCurl, CURLOPT_POSTFIELDS, array(
                'license_url' => Registry::getConfig()->getConfigParam('sSSLShopURL') . '/' . $sLicenseFile,
                'remote_ip' => $sClientIp,
                'timestamp' => date('Y-m-d H:i:s'),
            ));
            curl_setopt($rCurl,CURLOPT_TIMEOUT,$iTimeout);
            curl_exec($rCurl);
            curl_close($rCurl);

        } catch (\Exception $oException) {
            // ERROR
        }
    }
}
