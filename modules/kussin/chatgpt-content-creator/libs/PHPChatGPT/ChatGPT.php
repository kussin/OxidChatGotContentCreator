<?php

namespace Kussin\ChatGpt\libs\PHPChatGPT;

use Kussin\ChatGpt\Traits\ChatGPTInstructionTrait;
use Kussin\ChatGpt\Traits\LoggerTrait;
use OxidEsales\Eshop\Core\Registry;

class ChatGPT extends \QuneMedia\ChatGpt\Connector\ChatGPT
{
    use ChatGPTInstructionTrait;
    use LoggerTrait;

    private int $_iInfinityLoopCount = 0;

    public function getCompleteTextResponse($sPrompt, $sModel = 'gpt-3.5-turbo-instruct', $dTemperature = 0.7, $iMaxTokens = 1000, $bHtml = false, $iLang = null): array
    {
        // SET API KEY
        $sApiKey = Registry::getConfig()->getConfigParam('sKussinChatGptApiKey');
        parent::setApiKey($sApiKey);

        $aCompleteTextResponse = $this->createTextRequest($sPrompt, $sModel, $dTemperature, $iMaxTokens, $bHtml, $iLang);

        $this->_debug(array(
            'method' => __CLASS__ . '::' . __FUNCTION__,
            'response' => $aCompleteTextResponse,
        ));

        if (
            ($aCompleteTextResponse['continue'] === true)
            && ($this->_iInfinityLoopCount < self::MAX_CONTINUE_REQUESTS)
        ) {
            $aContinueTextResponse = $this->getCompleteTextResponse($this->_getContinuePrompt($iLang), $sModel, $dTemperature, $iMaxTokens, $bHtml);
            $aCompleteTextResponse['data'] .= $aContinueTextResponse['data'];

            $this->_iInfinityLoopCount++;
        }

        return $aCompleteTextResponse;
    }

    protected function _getExtendedPrompt($iLang): string
    {
        return $this->_getChatGptInstruction($iLang);
    }
}
