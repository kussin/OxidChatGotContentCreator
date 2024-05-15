<?php

namespace Kussin\ChatGpt\Traits;

use OxidEsales\Eshop\Core\Registry;

trait LanguageTrait
{

    protected function _getLanguageCode($iLang) : string
    {
        $oLang = Registry::getLang();

        return strtoupper($oLang->getLanguageAbbr($iLang));
    }

    protected function _getTranslationLanguage($iTranslationId, $iLang) : string
    {
        // GET LANGUAGES
        $aLanguages = array_values(Registry::getConfig()->getConfigParam('aLanguages'));

        return $aLanguages[$iTranslationId];
    }
}