<?php

namespace Kussin\ChatGpt\Traits;

use OxidEsales\Eshop\Core\DatabaseProvider;
use OxidEsales\Eshop\Core\Field;
use OxidEsales\Eshop\Core\Model\BaseModel;
use OxidEsales\Eshop\Core\Registry;

trait SavingContentTypesTrait
{
    use ChatGPTPromptOptimizerTrait;
    use ChatGPTProcessPromptsTrait;
    use CustomDbTrait;
    use JsonTrait;
    use LoggerTrait;

    protected $_aForbiddenValues = array('null', 'n/a', 'n.v.');

    protected function _savingDefaultContentType($oObject, $sOxid, $sFieldId, $iLang, $sGeneratedContentHash, $sTouchTable = 'oxarticles') : string
    {
        // DECODE CONTENT
        $sGeneratedContent = $this->_decodeProcessContent($sGeneratedContentHash);

        $this->_debug('Ai content for ' . $sOxid . ' svae in field `' . $sFieldId . '`: ' . $sGeneratedContent);

        // GET CONTENT & LANGUAGE
        $iLang = (int) substr($sFieldId, -1);
        if ($iLang > 0) {
            // LOAD OBJECT IN LANGUAGE
            $sFieldId = substr($sFieldId, 0, -2);

            $oObject->loadInLang($iLang, $sOxid);
        } else {
            // LOAD OBJECT
            $oObject->load($sOxid);
        }

        // SAVE CONTENT
        $oContent = new Field($this->_optimizeResponse($sGeneratedContent));

        if (($sFieldId == 'oxlongdesc') || ($sFieldId == 'oxartextends__oxlongdesc')) {
            $oObject->setArticleLongDesc($oContent->getRawValue());
        } else {
            $oObject->{$sFieldId} = new Field($oContent);
        }

        // TOUCH TIMESTAMP
        $this->_touchTimestamp($sOxid, $sTouchTable);

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
        $aForbiddenValues = explode(',', Registry::getConfig()->getConfigParam('sKussinChatGptProcessProductAttributesForbiddenValues'));

        // COMBINE ARRAYS
        $aForbiddenValues = array_merge($aForbiddenValues, $this->_aForbiddenValues);

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