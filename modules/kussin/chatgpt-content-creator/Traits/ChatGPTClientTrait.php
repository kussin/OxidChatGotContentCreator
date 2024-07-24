<?php

namespace Kussin\ChatGpt\Traits;

use Kussin\ChatGpt\libs\PHPChatGPT\ChatGPT;
use OxidEsales\Eshop\Core\Registry;

trait ChatGPTClientTrait
{
    private $_oChatGptClient = null;

    private int $_iAiGenerationSteps = 1;

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

    private function _kussinGetChatGptContentLongDescription($sPrompt, $sModel = FALSE, $dTemperature = FALSE, $iMaxTokens = FALSE, $bHtml = FALSE, $iLang = null, $sMode = 'text'): array
    {
        // LOAD CHATGPT CLIENT
        if ($this->_oChatGptClient === null) {
            $this->_oChatGptClient = new ChatGPT();
        }

        // STEP 1 - PROVIDE CONTEXT
        $aCompleteTextResponse = [
            'data' => $sPrompt,
        ];

        // STEP 2 - GET BASIC AI RESPONSE
//        $aCompleteTextResponse = $this->_getChatGptBasicResponse($aCompleteTextResponse['data'], $sModel, $dTemperature, $iMaxTokens, $iLang);

        // STEP 3 - ADD HTML MARKUP
        if ($bHtml) {
            $aCompleteTextResponse = $this->_getChatGptHtmlMarkupResponse($aCompleteTextResponse['data'], $sModel, $dTemperature, $iMaxTokens, $bHtml, $iLang);
        }

        // STEP 4 - PROVIDE CONTEXT
//        $aCompleteTextResponse = $this->_getChatGptOptimizeResponse($aCompleteTextResponse['data'], $sModel, $dTemperature, $iMaxTokens, $iLang);

        return $aCompleteTextResponse;
    }

    private function _createTextRequest($sPrompt, $sModel, $dTemperature, $iMaxTokens, $bHtml, $iLang): array
    {
        // LOAD CHATGPT CLIENT
        if ($this->_oChatGptClient === null) {
            $this->_oChatGptClient = new ChatGPT();
        }

        return $this->_oChatGptClient->getCompleteTextResponse(
            $sPrompt,
            ($sModel !== FALSE ? $sModel : Registry::getConfig()->getConfigParam('sKussinChatGptApiModel')),
            ($dTemperature !== FALSE ? $dTemperature : (double) Registry::getConfig()->getConfigParam('dKussinChatGptApiTemperature')),
            ($iMaxTokens !== FALSE ? $iMaxTokens : (int) Registry::getConfig()->getConfigParam('iKussinChatGptApiMaxTokens')),
            $bHtml,
            $iLang
        );
    }

    protected function _getChatGptBasicResponse($sPrompt, $sModel = 'gpt-3.5-turbo-instruct', $dTemperature = 0.7, $iMaxTokens = 1000, $iLang = null): array
    {
        // GET BASIC AI RESPONSE
        $aResponse = $this->_createTextRequest($sPrompt, $sModel, $dTemperature, $iMaxTokens, false, $iLang);

        // LOG
        $this->_debug(array(
            'method' => __CLASS__ . '::' . __FUNCTION__,
            'step' => $this->_iAiGenerationSteps++ . ' - BASIC AI RESPONSE',
            'prompt' => $sPrompt,
            'response' => $aResponse,
        ));

        return $aResponse;
    }

    protected function _getChatGptHtmlMarkupResponse($sPrompt, $sModel = 'gpt-3.5-turbo-instruct', $dTemperature = 0.7, $iMaxTokens = 1000, $bHtml = true, $iLang = null): array
    {
        // GET HTML AI RESPONSE
        $aResponse = $this->_createTextRequest($sPrompt, $sModel, $dTemperature, $iMaxTokens, $bHtml, $iLang);

        // LOG
        $this->_debug(array(
            'method' => __CLASS__ . '::' . __FUNCTION__,
            'step' => $this->_iAiGenerationSteps++ . ' - HTML AI RESPONSE',
            'prompt' => $sPrompt,
            'response' => $aResponse,
        ));

        return $aResponse;
    }

    protected function _getChatGptOptimizeResponse($sPrompt, $sModel = 'gpt-3.5-turbo-instruct', $dTemperature = 0.7, $iMaxTokens = 1000, $iLang = null): array
    {
        // GET OPTIMIZED AI RESPONSE
        $aResponse = $this->_createTextRequest($sPrompt, $sModel, $dTemperature, $iMaxTokens, false, $iLang);

        // LOG
        $this->_debug(array(
            'method' => __CLASS__ . '::' . __FUNCTION__,
            'step' => $this->_iAiGenerationSteps++ . ' - OPTIMIZE AI RESPONSE',
            'prompt' => $sPrompt,
            'response' => $aResponse,
        ));

        return $aResponse;
    }
}