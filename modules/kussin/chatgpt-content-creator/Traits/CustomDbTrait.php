<?php

namespace Kussin\ChatGpt\Traits;

use OxidEsales\Eshop\Core\DatabaseProvider;

trait CustomDbTrait
{
    private function _getCustomDbValue($sQuery)
    {
        $oResult = DatabaseProvider::getDb()->select($sQuery);

        if ($oResult != false && $oResult->count() > 0) {
            while (!$oResult->EOF) {
                $aData = $oResult->getFields();

                return (count($aData) > 1) ? $aData : $aData[0];

                // NEXT ROW
//                $oResult->fetchRow();
            }
        }

        return false;
    }

    private function _getCustomDbResult($sQuery)
    {
        $aResult = array();

        $oResult = DatabaseProvider::getDb()->select($sQuery);

        if ($oResult != false && $oResult->count() > 0) {
            while (!$oResult->EOF) {
                $aData = $oResult->getFields();

                $aResult[] = (count($aData) > 1) ? $aData : $aData[0];

                // NEXT ROW
                $oResult->fetchRow();
            }
        }

        return $aResult;
    }
}