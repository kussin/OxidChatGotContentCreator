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
}