<?php

namespace Kussin\ChatGpt\Traits;

use OxidEsales\Eshop\Core\Registry;

trait ChatGPTInstructionTrait
{
    private function _getChatGptInstruction()
    {
        $oLang = Registry::getLang();
        return $oLang->translateString('KUSSIN_CHATGPT_LONG_DESCRIPTION_INSTRUCTION_PROMPT', $oLang->getBaseLanguage());
    }

    private function _getContinuePrompt()
    {
        $oLang = Registry::getLang();
        return $oLang->translateString('KUSSIN_CHATGPT_LONG_DESCRIPTION_CONTINUE_PROMPT', $oLang->getBaseLanguage());
    }
}