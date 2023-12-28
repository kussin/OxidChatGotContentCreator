<?php

namespace Kussin\ChatGpt\Traits;

use OxidEsales\Eshop\Core\Registry;

trait ChatGPTInstructionTrait
{
    private function _getChatGptInstruction($iLang = null)
    {
        $oLang = Registry::getLang();

        if ($iLang === null) {
            $iLang = $oLang->getBaseLanguage();
        }

        return $oLang->translateString('KUSSIN_CHATGPT_LONG_DESCRIPTION_INSTRUCTION_PROMPT', $iLang);
    }

    private function _getContinuePrompt($iLang = null)
    {
        $oLang = Registry::getLang();

        if ($iLang === null) {
            $iLang = $oLang->getBaseLanguage();
        }

        return $oLang->translateString('KUSSIN_CHATGPT_LONG_DESCRIPTION_CONTINUE_PROMPT', $iLang);
    }
}