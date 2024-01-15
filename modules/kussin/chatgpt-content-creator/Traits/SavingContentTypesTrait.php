<?php

namespace Kussin\ChatGpt\Traits;

use OxidEsales\Eshop\Core\DatabaseProvider;
use OxidEsales\Eshop\Core\Field;

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
                // TODO: Check and save attribute values
//                $oContent = new Field($sValue);
//                $oObject->{$sFieldId} = new Field($oContent);
            }

            // TOUCH TIMESTAMP
            $this->_touchTimestamp($sOxid, (($aItem[1] == 'oxartextends') ? 'oxarticles' : $aItem[1]));

            $oObject->save();

            // RETURN OBJECT LINK
            return $oObject->getLink();
        }

        return FALSE;
    }

    private function _touchTimestamp($sOxid, $sTable = 'oxarticles'): bool
    {
        $sQuery = 'UPDATE IGNORE `' . $sTable . '` SET `KUSSINCHATGPTGENERATED` = 1, `OXTIMESTAMP` = NOW() WHERE (`OXID` LIKE "' . $sOxid . '");';

        return (bool) DatabaseProvider::getDb()->execute($sQuery);
    }
}