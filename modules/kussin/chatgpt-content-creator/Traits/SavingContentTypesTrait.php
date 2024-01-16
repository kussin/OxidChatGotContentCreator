<?php

namespace Kussin\ChatGpt\Traits;

use OxidEsales\Eshop\Core\DatabaseProvider;
use OxidEsales\Eshop\Core\Field;
use OxidEsales\Eshop\Core\Model\BaseModel;

trait SavingContentTypesTrait
{
    use ChatGPTProcessPromptsTrait;
    use CustomDbTrait;
    use JsonTrait;

    protected function _savingDefaultContentType($oObject, $sOxid, $sFieldId, $iLang, $sGeneratedContentHash) : string
    {
        // DECODE CONTENT
        $sGeneratedContent = $this->_decodeProcessContent($sGeneratedContentHash);

        // LOAD OBJECT
        $oObject->load($sOxid);

        // SAVE CONTENT
        $oContent = new Field($sGeneratedContent);

        if ($sFieldId == 'oxlongdesc') {
            $oObject->setArticleLongDesc($oContent->getRawValue());
        } else {
            $oObject->{$sFieldId} = new Field($oContent);
        }

        // TOUCH TIMESTAMP
        $this->_touchTimestamp($sOxid, ( ($aItem[1] == 'oxartextends') ? 'oxarticles' : $aItem[1] ));

        $oObject->save();

        // RETURN OBJECT LINK
        return $oObject->getLink();
    }

    protected function _savingProductAttributeContentType($oObject, $sOxid, $iLang, $sGeneratedContentHash)
    {
        // DECODE CONTENT
        $aAttributes = $this->_getJsonContent($this->_decodeProcessContent($sGeneratedContentHash));

        if ($aAttributes) {
            $oAttributeUpdateCount = 0;

            // SAVE CONTENT
            foreach ($aAttributes as $sAttributeName => $sValue) {
                // CHECK ATTRIBUTE EXISTS
                if (($sAttributeId = $this->_getProductAttributeId($sAttributeName, $iLang)) !== FALSE) {
                    // CLEANUP VALUE
                    $sValue = $this->_cleanupValue($sValue);

                    if (
                        !$this->_hasProductAttributeValue($sOxid, $sAttributeId, $iLang)
                        && $sValue
                    ) {
                        $sValueColumn = ($iLang > 0) ? 'OXVALUE_' . $iLang : 'OXVALUE';

                        try {
                            $oAttribute = oxNew(BaseModel::class);
                            $oAttribute->init("oxobject2attribute");
                            $oAttribute->oxobject2attribute__oxobjectid = new Field($sOxid);
                            $oAttribute->oxobject2attribute__oxattrid = new Field($sAttributeId);
                            $oAttribute->{strtolower('oxobject2attribute__' . $sValueColumn)} = new Field($sValue);
                            $oAttribute->save();

                            $oAttributeUpdateCount++;
                        } catch (\Exception $oException) {
                            // ERROR
                            $this->_error(array(
                                'method' => __CLASS__ . '::' . __FUNCTION__,
                                'response' => $oException,
                            ));
                        }
                    }
                }
            }

            // TOUCH TIMESTAMP
            if ($oAttributeUpdateCount > 0) {
                $this->_touchTimestamp($sOxid);
            }

            // LOAD OBJECT
            $oObject->load($sOxid);

            // RETURN OBJECT LINK
            return $oObject->getLink();
        }

        return FALSE;
    }

    protected function _getProductAttributeId($sAttributeName, $iLang)
    {
        $sColumnName = ($iLang > 0) ? 'OXTITLE_' . $iLang : 'OXTITLE';

        // LOAD ATTRIBUTE ID
        $sQuery = 'SELECT `OXID` FROM `oxattribute` WHERE (`' . $sColumnName . '` LIKE "' . $sAttributeName . '");';
        $aResponse = $this->_getCustomDbResult($sQuery);

        return count($aResponse) > 0 ? $aResponse[0] : FALSE;
    }

    protected function _hasProductAttributeValue($sObjectId, $sAttributeId, $iLang): bool
    {
        $sColumnName = ($iLang > 0) ? 'OXVALUE_' . $iLang : 'OXVALUE';

        // LOAD ATTRIBUTE ID
        $sQuery = 'SELECT `OXID` FROM `oxobject2attribute` WHERE (`OXOBJECTID` LIKE "' . $sObjectId . '") AND (`OXATTRID` LIKE "' . $sAttributeId . '") AND (`' . $sColumnName . '` NOT LIKE "");';
        $aResponse = $this->_getCustomDbResult($sQuery);

        return count($aResponse) > 0;
    }

    protected function _cleanupValue($sValue)
    {
        $sCleanedValue = trim($sValue);

        // FORBIDDEN VALUES
        $sCleanedValue = $this->_forbiddenValues($sCleanedValue);

        if (is_null($sValue) || is_null($sCleanedValue)) {
            // NULL VALUE FORBIDDEN
            return FALSE;
        }

        if (is_array($sValue)) {
            // ARRAY VALUE FORBIDDEN
            return FALSE;
        }

        if (is_bool($sValue)) {
            // BOOLEAN to STRING
            return $sValue ? '1' : '0';
        }

        return ($sCleanedValue != '') ? $sCleanedValue : FALSE;
    }

    protected function _forbiddenValues($sValue)
    {
        // TODO: GET FORBIDDEN VALUES FROM CONFIG
        $aForbiddenValues = array('unbekannt');

        if (in_array(strtolower(trim($sValue)), $aForbiddenValues)) {
            return NULL;
        }

        return trim($sValue);
    }

    protected function _touchTimestamp($sOxid, $sTable = 'oxarticles'): bool
    {
        $sQuery = 'UPDATE IGNORE `' . $sTable . '` SET `KUSSINCHATGPTGENERATED` = 1, `OXTIMESTAMP` = NOW() WHERE (`OXID` LIKE "' . $sOxid . '");';

        return (bool) DatabaseProvider::getDb()->execute($sQuery);
    }
}