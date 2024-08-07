<?php

namespace Kussin\ChatGpt\Traits;

use OxidEsales\Eshop\Core\Registry;
use QuneMedia\ChatGpt\Prompts\Prompt;

trait LanguageTrait
{
    use ChatGPTPromptOptimizerTrait;

    protected function _getLanguageCode($iLang) : string
    {
        $oLang = Registry::getLang();

        return strtoupper($oLang->getLanguageAbbr($iLang));
    }

    protected function _getTranslationLanguage($iTranslationId, $iLang) : string
    {
        // GET LANGUAGES
        $aLanguages = array_values(Registry::getConfig()->getConfigParam('baselocalecode'));

        return $aLanguages[$iTranslationId];
    }

    protected function _translate($sPrompt): array
    {
        // TRANSLATE
        $aResponse = $this->_kussinGetChatGptContent($sPrompt);

        // OPTIMIZE
        if ($aResponse['error'] == NULL) {
            // LOAD PARAMS
            $sEditLocaleCode = Registry::getRequest()->getRequestEscapedParameter('editlocalecode');

            $sPrompt = sprintf(
                Prompt::load()->get('OPTIMIZE_TRANSLATION', $sEditLocaleCode),
                $this->_optimizeResponse($aResponse['data'])
            );

            // LOG
            $this->_info(array(
                'method' => __CLASS__ . '::' . __FUNCTION__,
                'prompt' => $sPrompt,
                'params' => array(
                    'translation' => $aResponse['data'],
                ),
            ));

//            $aResponse = $this->_kussinGetChatGptContent($sPrompt);

            // HOTFIX
//            $aOptimizedResponse = $this->_kussinGetChatGptContent($sPrompt);
//
//            if (
//                ($aOptimizedResponse['error'] == NULL)
//                && (strlen($aOptimizedResponse['data']) >= 10)
//            ) {
//                $aResponse = $aOptimizedResponse;
//            }
        }

        return $aResponse;
    }
}