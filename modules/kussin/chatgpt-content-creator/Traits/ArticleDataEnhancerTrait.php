<?php

namespace Kussin\ChatGpt\Traits;

use Kussin\ArticleDataEnhancer\Core\Data;
use OxidEsales\Eshop\Core\Registry;

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
        $sPrompt = $oLang->translateString('KUSSIN_CHATGPT_ENHANCED_ARTICLE_DATA_PROMPT', $oLang->getBaseLanguage());

        return PHP_EOL . sprintf(
            $sPrompt,
            $sEnhancedArticleData
        );
    }
}