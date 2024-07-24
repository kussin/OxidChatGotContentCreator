<?php

namespace Kussin\ChatGpt\Traits;

use OxidEsales\Eshop\Core\Registry;
use QuneMedia\ChatGpt\Prompts\LanguageMapper;
use QuneMedia\ChatGpt\Prompts\Prompt;

trait ChatGPTInstructionTrait
{
    private function _getChatGptInstruction($iLang = null)
    {
        $oLang = Registry::getLang();

        if ($iLang === null) {
            $iLang = $oLang->getBaseLanguage();
        }

        return Prompt::load()->get(
            'LONG_DESCRIPTION_INSTRUCTION',
            LanguageMapper::getLocaleCode($oLang->getLanguageAbbr($iLang))
        );
    }
}