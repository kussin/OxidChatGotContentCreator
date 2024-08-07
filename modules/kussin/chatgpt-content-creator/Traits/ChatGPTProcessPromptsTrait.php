<?php

namespace Kussin\ChatGpt\Traits;

use OxidEsales\Eshop\Application\Model\Attribute;
use OxidEsales\Eshop\Core\Registry;
use QuneMedia\ChatGpt\Prompts\LanguageMapper;
use QuneMedia\ChatGpt\Prompts\Prompt;

trait ChatGPTProcessPromptsTrait
{
    use ArticleDataEnhancerTrait;
    use LanguageTrait;
    use ChatGPTPromptOptimizerTrait;

    protected function _getProcessMaxTokens($sFieldId, $iMaxTokens = 350) : int
    {
        switch ($sFieldId) {
            case 'oxshortdesc':
                $dFactor = 0.9;
                break;

            default:
            case 'oxlongdesc':
                $dFactor = 1.1;
                break;
        }

        return floor((int) $iMaxTokens * $dFactor);
    }

    protected function _useHtml($sFieldId) : bool
    {
        switch ($sFieldId) {
            case 'oxlongdesc':
                return true;

            default:
            case 'oxshortdesc':
                return false;
        }
    }

    private function _getProcessPrompts($sMode, $oObject, $sFieldId, $iLang = 0, $iMaxTokens = 350)
    {
        $aValues = array();

        // GET LOCALE CODES
        $sBaseLocaleCode = 'de_DE';
        $sEditLocaleCode = LanguageMapper::getLocaleCode($this->_getLanguageCode($iLang));

        if ($sMode == 'optimize') {
            // OPTIMIZE CONTENT
            $sPrompt = $this->_getChatGptProcessPrompt4OptimizeContent($iLang);
            $aValues[] = $this->_encodeProcessSpecialChars($oObject->{$sFieldId}->value);

        } elseif ($sMode == 'translate') {
            // TRANSLATE CONTENT
            $aValues[] = $this->_optimizePromptValue($oObject->oxarticles__oxtitle->value); // ARTIKELNAME
            $aValues[] = Prompt::load()->get('LABEL___' . $sBaseLocaleCode, $sEditLocaleCode); // AUSGANGSSPRACHE

            switch (str_replace(array('_1', '_2', '_3', '_4', '_5', '_6', '_7'), '', $sFieldId)) {
                case 'oxarticles__oxtitle':
                    $sPrompt = $this->_getChatGptProcessPrompt4TranslationTitle($iLang);
                    break;

                case 'oxarticles__oxshortdesc':
                        $sPrompt = $this->_getChatGptProcessPrompt4TranslationShortDescription($iLang);
                        $aValues[] = $this->_encodeProcessSpecialChars(strip_tags($oObject->oxarticles__oxshortdesc->value));
                        break;

                default:
                case 'oxartextends__oxlongdesc':
                    $sPrompt = $this->_getChatGptProcessPrompt4TranslationLongDescription($iLang);
                    $aValues[] = $this->_encodeProcessSpecialChars(strip_tags($oObject->getLongDescription()));
                    break;
            }

        } else {
            // CREATE CONTENT
            switch (str_replace(array('_1', '_2', '_3', '_4', '_5', '_6', '_7'), '', $sFieldId)) {
                case 'oxarticles__oxattribute':
                    $sPrompt = $this->_getChatGptProcessPrompt4Attributes($iLang);
                    $aValues[] = $this->_encodeProcessSpecialChars($oObject->oxarticles__oxtitle->value);
                    $aValues[] = $oObject->oxarticles__oxmpn->value;
                    $aValues[] = $this->_encodeProcessSpecialChars($oObject->getManufacturer()->oxmanufacturers__oxtitle->value);
                    break;

                case 'oxarticles__oxsearchkeys':
                    $sPrompt = $this->_getChatGptProcessPrompt4SearchKeys($iLang);
                    $aValues[] = $this->_encodeProcessSpecialChars($oObject->oxarticles__oxtitle->value);
                    $aValues[] = $this->_encodeProcessSpecialChars($oObject->getManufacturer()->oxmanufacturers__oxtitle->value);
                    break;

                case 'oxarticles__oxshortdesc':
                    $sPrompt = $this->_getChatGptProcessPrompt4ShortDescription($iLang);
                    $aValues[] = $this->_encodeProcessSpecialChars($oObject->oxarticles__oxtitle->value);
                    $aValues[] = $this->_encodeProcessSpecialChars($oObject->getManufacturer()->oxmanufacturers__oxtitle->value);
                    break;

                default:
                case 'oxartextends__oxlongdesc':
                    $sPrompt = $this->_getChatGptProcessPrompt4LongDescription($iLang);
                    $aValues[] = $this->_encodeProcessSpecialChars($oObject->oxarticles__oxtitle->value);
                    $aValues[] = $this->_encodeProcessSpecialChars($oObject->getManufacturer()->oxmanufacturers__oxtitle->value);

                    // EXTENT PROMPT W/ ENHANCED ARTICLE DATA
                    $sArticleIdKey = trim(Registry::getConfig()->getConfigParam('sKussinChatGptArticleDataEnhancerArticleIdKey'));
                    $sPrompt .= $this->_getEnhancedArticlePrompt($oObject->{$sArticleIdKey}->value);

                    break;
            }
        }

        // FIX PROMPT
        $sPrompt = str_replace(['"', '"', '&quot;',], '`', $sPrompt);

        // ADD TOKENS
        $aValues[] = $iMaxTokens;

        return vsprintf(
            $sPrompt,
            $aValues
        );
    }

    protected function _encodeProcessSpecialChars($sString, $sCharset = 'UTF-8') : string
    {
        $sStringUtf8 = mb_convert_encoding($sString, $sCharset, mb_detect_encoding($sString));

        return htmlspecialchars($sStringUtf8, ENT_QUOTES, $sCharset);
    }

    protected function _encodeProcessContent($sString, $sCharset = 'UTF-8') : string
    {
        return base64_encode(trim($sString));
    }

    protected function _decodeProcessContent($sString) : string
    {
        return trim(base64_decode($sString));
    }

    protected function _getChatGptProcessPrompt4ShortDescription($iLang = 0)
    {
        $sPrompt = trim(Registry::getConfig()->getConfigParam('sKussinChatGptPromptShortDescription' . $this->_getLanguageCode($iLang)));

        if ($sPrompt == '') {
            // FALLBACK
            $oLang = Registry::getLang();
            $sLocaleCode = LanguageMapper::getLocaleCode($oLang->getLanguageAbbr($iLang));
            $sPrompt = Prompt::load()->get('SHORT_DESCRIPTION', $sLocaleCode);
        }

        return $sPrompt;
    }

    protected function _getChatGptProcessPrompt4LongDescription($iLang = 0)
    {
        $sPrompt = trim(Registry::getConfig()->getConfigParam('sKussinChatGptPromptLongDescription' . $this->_getLanguageCode($iLang)));

        if ($sPrompt == '') {
            // FALLBACK
            $oLang = Registry::getLang();
            $sLocaleCode = LanguageMapper::getLocaleCode($oLang->getLanguageAbbr($iLang));
            $sPrompt = Prompt::load()->get('LONG_DESCRIPTION', $sLocaleCode);
        }

        return $sPrompt;
    }

    protected function _getChatGptProcessPrompt4SearchKeys($iLang = 0)
    {
        $sPrompt = trim(Registry::getConfig()->getConfigParam('sKussinChatGptPromptProductSearchKeys' . $this->_getLanguageCode($iLang)));

        if ($sPrompt == '') {
            // FALLBACK
            $oLang = Registry::getLang();
            $sLocaleCode = LanguageMapper::getLocaleCode($oLang->getLanguageAbbr($iLang));
            $sPrompt = Prompt::load()->get('PRODUCT_SEARCHKEYS', $sLocaleCode);
        }

        return $sPrompt;
    }

    protected function _getChatGptProcessPrompt4Attributes($iLang = 0)
    {
        $sPrompt = trim(Registry::getConfig()->getConfigParam('sKussinChatGptPromptProductAttributes' . $this->_getLanguageCode($iLang)));

        if ($sPrompt == '') {
            // FALLBACK
            $oLang = Registry::getLang();
            $sLocaleCode = LanguageMapper::getLocaleCode($oLang->getLanguageAbbr($iLang));
            $sPrompt = Prompt::load()->get('PRODUCT_ATTRIBUTES', $sLocaleCode);
        }

        // ADD ATTRIBUTE NAMES
        $aAttributeNames = array();
        foreach ($this->_getCustomDbResult('SELECT `OXID` FROM `oxattribute`;') as $aAttributeId) {
            if (isset($aAttributeId)) {
                $oAttribute = oxNew(Attribute::class);
//                $oAttribute->loadInLang($aAttributeId, $iLang);
                $oAttribute->load($aAttributeId);

                // ADD TO PROMPT
                $aAttributeNames[] = $oAttribute->oxattribute__oxtitle->value;
            }
        }

        return $sPrompt . PHP_EOL . implode(', ', $aAttributeNames);
    }

    protected function _getChatGptProcessPrompt4OptimizeContent($iLang = 0)
    {
        $sPrompt = trim(Registry::getConfig()->getConfigParam('sKussinChatGptPromptOptimizeContent' . $this->_getLanguageCode($iLang)));

        if ($sPrompt == '') {
            // FALLBACK
            $oLang = Registry::getLang();
            $sLocaleCode = LanguageMapper::getLocaleCode($oLang->getLanguageAbbr($iLang));
            $sPrompt = Prompt::load()->get('OPTIMIZE_CONTENT', $sLocaleCode);
        }

        return $sPrompt;
    }

    protected function _getChatGptProcessPrompt4TranslationTitle($iLang = 0)
    {
        // TODO: ADD CUSTOM TRANSLATION PROMPT
        $sPrompt = '';

        if ($sPrompt == '') {
            // FALLBACK
            $oLang = Registry::getLang();
            $sLocaleCode = LanguageMapper::getLocaleCode($oLang->getLanguageAbbr($iLang));
            $sPrompt = Prompt::load()->get('TRANSLATION_TITLE', $sLocaleCode);
        }

        // ADDITIONAL CONTEXT
        $sPrompt = $this->_addAdditionalContext4ProcessPromptTranslation() . $sPrompt;

        return $sPrompt;
    }

    protected function _getChatGptProcessPrompt4TranslationShortDescription($iLang = 0)
    {
        // TODO: ADD CUSTOM TRANSLATION PROMPT
        $sPrompt = '';

        if ($sPrompt == '') {
            // FALLBACK
            $oLang = Registry::getLang();
            $sLocaleCode = LanguageMapper::getLocaleCode($oLang->getLanguageAbbr($iLang));
            $sPrompt = Prompt::load()->get('TRANSLATION_SHORT_DESCRIPTION', $sLocaleCode);
        }

        // ADDITIONAL CONTEXT
        $sPrompt = $this->_addAdditionalContext4ProcessPromptTranslation() . $sPrompt;

        return $sPrompt;
    }

    protected function _getChatGptProcessPrompt4TranslationLongDescription($iLang = 0)
    {
        // TODO: ADD CUSTOM TRANSLATION PROMPT
        $sPrompt = '';

        if ($sPrompt == '') {
            // FALLBACK
            $oLang = Registry::getLang();
            $sLocaleCode = LanguageMapper::getLocaleCode($oLang->getLanguageAbbr($iLang));
            $sPrompt = Prompt::load()->get('TRANSLATION_LONG_TRANSLATION', $sLocaleCode);
        }

        // ADDITIONAL CONTEXT
        $sPrompt = $this->_addAdditionalContext4ProcessPromptTranslation() . $sPrompt;

        return $sPrompt;
    }

    protected function _addAdditionalContext4ProcessPromptTranslation()
    {
        // ADDITIONAL CONTEXT
        $sAdditionalContext = trim(Registry::getConfig()->getConfigParam('sKussinChatGptPromptAdditionalTranslationContext'));

        if ($sAdditionalContext == '') {
            return '';
        }

        return $sAdditionalContext . "\n\n";
    }
}