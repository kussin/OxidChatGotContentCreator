<?php

namespace Kussin\ChatGpt\Traits;

use OxidEsales\Eshop\Application\Model\Article;
use OxidEsales\Eshop\Application\Model\Category;
use OxidEsales\Eshop\Application\Model\Manufacturer;
use OxidEsales\Eshop\Application\Model\Vendor;
use OxidEsales\Eshop\Core\DatabaseProvider;

trait OxidObjectsTrait
{
    private $_aChatGPTData = array();

    private function _getOxidObject($sObject)
    {
        switch ($sObject) {
            case 'oxcategories':
                return oxNew(Category::class);

            case 'oxvendor':
                return oxNew(Vendor::class);

            case 'oxmanufacturers':
                return oxNew(Manufacturer::class);

            default:
            case 'oxarticles':
            case 'oxartextends':
                return oxNew(Article::class);
        }
    }

    private function _getOxidFieldId($sObjectId, $sFieldId, $iLang = 0): string
    {
        // SET LANG SUFFIX
        $sLangSuffix = ($iLang > 0) ? '_' . $iLang : '';

        return strtolower($sObjectId . '__' . $sFieldId . $sLangSuffix);
    }

    private function _getChatGPTData($id): array
    {
        if (!isset($this->_aChatGPTData[$id])) {

            // BUILD SQL QUERY
            $sQuery  = 'SELECT * FROM kussin_chatgpt_content_creator_queue WHERE id = "' . $id . '" LIMIT 1';

            $oResult = DatabaseProvider::getDb(DatabaseProvider::FETCH_MODE_ASSOC)->select($sQuery);

            if ($oResult != false && $oResult->count() > 0) {
                while (!$oResult->EOF) {
                    $aData = $oResult->getFields();

                    $this->_aChatGPTData[$id] = $aData;
                    break;

                    //do something
                    $oResult->fetchRow();
                }
            }
        }

        return $this->_aChatGPTData[$id] ?? array();
    }

    protected function _getObjectTitle($oObject, $sObjectId, $sObject = 'oxarticles', $iLang = 0): string
    {
        // LOAD OBJECT
        $oObject->load($sObjectId);

        switch ($sObject) {
            case 'oxarticles':
            case 'oxcategories':
            case 'oxmanufacturers':
            case 'oxvendor':
                return (string) $oObject->{$this->_getOxidFieldId($sObject, 'OXTITLE', $iLang)}->value;

            case 'oxartextends':
                return (string) $oObject->{$this->_getOxidFieldId('oxarticles', 'OXTITLE', $iLang)}->value;

            default:
                return $sObjectId;
        }
    }
}