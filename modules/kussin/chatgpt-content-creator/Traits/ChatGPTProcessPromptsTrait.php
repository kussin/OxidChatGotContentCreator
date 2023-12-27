<?php

namespace Kussin\ChatGpt\Traits;

use OxidEsales\Eshop\Core\Registry;

trait ChatGPTProcessPromptsTrait
{
    private function _getProcessPrompts($oObject, $SFieldId, $iLang = 0, $iMaxTokens = 350)
    {
        switch ($SFieldId) {
            case 'oxshortdesc':
                $sPrompt = $this->_getChatGptProcessPrompt4ShortDescription($iLang);
                $sTitle = $oObject->oxarticles__oxtitle->value;
                $sManufacturer = $oObject->getManufacturer()->oxmanufacturers__oxtitle->value;
                break;
            default:
            case 'oxlongdesc':
                $sPrompt = $this->_getChatGptProcessPrompt4LongDescription($iLang);
                $sTitle = $oObject->oxarticles__oxtitle->value;
                $sManufacturer = $oObject->getManufacturer()->oxmanufacturers__oxtitle->value;
                break;
        }

        return sprintf(
            $sPrompt,
            $sTitle,
            $sManufacturer,
            $iMaxTokens
        );
    }

    protected function _getChatGptProcessPrompt4ShortDescription($iLang = 0)
    {
        $sPrompt = trim(Registry::getConfig()->getConfigParam('sKussinChatGptPromptShortDescriptionDE')); // TODO: MULTI-LANGUAL

        if ($sPrompt == '') {
            // FALLBACK
            $oLang = Registry::getLang();
            $sPrompt = $oLang->translateString('KUSSIN_CHATGPT_SHORT_DESCRIPTION_PROMPT', $iLang);
        }

        return $sPrompt;
    }

    protected function _getChatGptProcessPrompt4LongDescription($iLang = 0)
    {
        $sPrompt = trim(Registry::getConfig()->getConfigParam('sKussinChatGptPromptLongDescriptionDE')); // TODO: MULTI-LANGUAL

        if ($sPrompt == '') {
            // FALLBACK
            $oLang = Registry::getLang();
            $sPrompt = $oLang->translateString('KUSSIN_CHATGPT_LONG_DESCRIPTION_PROMPT', $iLang);
        }

        return $sPrompt;
    }
}