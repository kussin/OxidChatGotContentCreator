<?php

namespace Kussin\ChatGpt\Traits;

use Kussin\ArticleDataEnhancer\Core\Data;
use OxidEsales\Eshop\Core\Registry;
use QuneMedia\ChatGpt\Prompts\LanguageMapper;
use QuneMedia\ChatGpt\Prompts\Prompt;

trait ArticleDataEnhancerTrait
{
    private function _getEnhancedArticleData($ArticleId, $bReturnJson = true)
    {
        $bArticleDataEnhancer = (bool) Registry::getConfig()->getConfigParam('blKussinChatGptProcessQueueEnabled');

        if (!$bArticleDataEnhancer) {
            return $bReturnJson ? json_encode(array()) : array();
        }

        // INIT DATA
        $oData = new Data();

        return $bReturnJson ? json_encode($oData->getArticleData($ArticleId)) : $oData->getArticleData($ArticleId);
    }

    protected function _getEnhancedArticlePrompt($ArticleId, $iJsonMinLength = 10): string
    {
        $sEnhancedArticleData = $this->_getEnhancedArticleData($ArticleId);

        if (strlen($sEnhancedArticleData) < $iJsonMinLength) {
            return '';
        }

        $oLang = Registry::getLang();
        $sLocaleCode = LanguageMapper::getLocaleCode($oLang->getLanguageAbbr($oLang->getBaseLanguage()));
        $sPrompt = Prompt::load()->get('ENHANCED_ARTICLE', $sLocaleCode);

        return PHP_EOL . sprintf(
            $sPrompt,
            $sEnhancedArticleData
        );
    }
}