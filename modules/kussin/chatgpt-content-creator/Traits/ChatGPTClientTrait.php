<?php

namespace Kussin\ChatGpt\Traits;

use Kussin\ChatGpt\libs\PHPChatGPT\ChatGPT;
use OxidEsales\Eshop\Core\Registry;

trait ChatGPTClientTrait
{
    private $_oChatGptClient = null;

    private function _kussinGetChatGptContent($sPrompt, $sModel = FALSE, $dTemperature = FALSE, $iMaxTokens = FALSE, $bHtml = FALSE, $iLang = null, $sMode = 'text')
    {
        // LOAD CHATGPT CLIENT
        if ($this->_oChatGptClient === null) {
            $this->_oChatGptClient = new ChatGPT();
        }

        // SET MODE
        $this->_oChatGptClient->setMode(($sMode == 'translate' ? 'translation' : 'text'));

        return $this->_oChatGptClient->getCompleteTextResponse(
            $sPrompt,
            ($sModel !== FALSE ? $sModel : Registry::getConfig()->getConfigParam('sKussinChatGptApiModel')),
            ($dTemperature !== FALSE ? $dTemperature : (double) Registry::getConfig()->getConfigParam('dKussinChatGptApiTemperature')),
            ($iMaxTokens !== FALSE ? $iMaxTokens : (int) Registry::getConfig()->getConfigParam('iKussinChatGptApiMaxTokens')),
            $bHtml,
            $iLang
        );
    }
}