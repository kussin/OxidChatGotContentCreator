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

        if ($aItem[3] == 'oxlongdesc') {
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

    protected function _savingProductAttributeContentType($oObject, $sOxid, $sFieldId, $iLang, $sGeneratedContentHash)
    {
        // DECODE CONTENT
        $aAttributes = $this->_getJsonContent($this->_decodeProcessContent($sGeneratedContentHash));

        if ($aAttributes) {
            // LOAD OBJECT
            $oObject->load($sOxid);

            // SAVE CONTENT
            foreach ($aAttributes as $aAttribute => $sValue) {
                // CHECK ATTRIBUTE EXISTS
                if (($sAttributeId = $this->_getProductAttributeId($aAttribute, $iLang)) !== FALSE) {
                    if (!$this->_hasProductAttributeValue($sOxid, $sAttributeId, $iLang)) {
                        $sValueColumn = ($iLang > 0) ? 'OXVALUE_' . $iLang : 'OXVALUE';

                        $oAttribute = oxNew(BaseModel::class);
                        $oAttribute->init("oxobject2attribute");
                        $oAttribute->oxobject2attribute__oxobjectid = new Field($sOxid);
                        $oAttribute->oxobject2attribute__oxattrid = new Field($sAttributeId);
                        $oAttribute->{strtolower('oxobject2attribute__' . $sValueColumn)} = new Field($sValue);
                        $oAttribute->save();
                    }
                }
            }

            // TOUCH TIMESTAMP
            $this->_touchTimestamp($sOxid);

            $oObject->save();

            // RETURN OBJECT LINK
            return $oObject->getLink();
        }

        return FALSE;
    }

    private function _getProductAttributeId($sAttributeName, $iLang)
    {
        $sColumnName = ($iLang > 0) ? 'OXTITLE_' . $iLang : 'OXTITLE';

        // LOAD ATTRIBUTE ID
        $sQuery = 'SELECT `OXID` FROM `oxattribute` WHERE (`' . $sColumnName . '` LIKE "' . $sAttributeName . '");';
        $aResponse = $this->_getCustomDbResult($sQuery)

        return count($aResponse) > 0 ? $aResponse[0] : FALSE;
    }

    private function _hasProductAttributeValue($sObjectId, $sAttributeId, $iLang)
    {
        $sColumnName = ($iLang > 0) ? 'OXTITLE_' . $iLang : 'OXTITLE';

        // LOAD ATTRIBUTE ID
        $sQuery = 'SELECT `OXID` FROM `oxobject2attribute` WHERE (`OXOBJECTID` LIKE "' . $sObjectId . '") AND (`OXATTRID` LIKE "' . $sAttributeId . '") AND (`' . $sColumnName . '` NOT LIKE "");';
        $aResponse = $this->_getCustomDbResult($sQuery)

        return count($aResponse) > 0;
    }

    private function _touchTimestamp($sOxid, $sTable = 'oxarticles'): bool
    {
        $sQuery = 'UPDATE IGNORE `' . $sTable . '` SET `KUSSINCHATGPTGENERATED` = 1, `OXTIMESTAMP` = NOW() WHERE (`OXID` LIKE "' . $sOxid . '");';

        return (bool) DatabaseProvider::getDb()->execute($sQuery);
    }
}