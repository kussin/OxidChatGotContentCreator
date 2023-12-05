<?php

namespace Kussin\ChatGpt\Controller\Admin;

use Kussin\ChatGpt\libs\PHPChatGPT\ChatGPT;
use OxidEsales\Eshop\Application\Model\Article;
use OxidEsales\Eshop\Core\DatabaseProvider;
use OxidEsales\Eshop\Core\Registry;

class ArticleMain extends ArticleMain_parent
{
    private $_oArticle = null;

    private $_oChatGptClient = null;

    private function _kussinLoadArticle()
    {
        if ($this->_oArticle === null) {
            // SAVE ARTICLE
            parent::save();

            $this->_oArticle = oxNew(Article::class);
            $this->_oArticle->load($this->getEditObjectId());
        }

        return $this->_oArticle;
    }

    public function kussinchatgptlongdesc()
    {
        // LOAD ARTICLE
        $this->_kussinLoadArticle();

        // TODO: Generate long description from ChatGPT API
    }

    public function kussinchatgptshortdesc()
    {
        // LOAD ARTICLE
        $this->_kussinLoadArticle();

        // TODO: Generate short description from ChatGPT API
    }

    private function _kussinGetChatGptContent($sPrompt, $sModel = FALSE, $dTemperature = FALSE, $iMaxTokens = FALSE)
    {
        // LOAD CHATGPT CLIENT
        if ($this->_oChatGptClient === null) {
            $this->_oChatGptClient = new ChatGPT();
        }

        return $this->_oChatGptClient->createTextRequest(
            $sPrompt,
            ($sModel !== FALSE ? $sModel : Registry::getConfig()->getConfigParam('sKussinChatGptApiModel')),
            ($dTemperature !== FALSE ? $dTemperature : Registry::getConfig()->getConfigParam('dKussinChatGptApiTemperature')),
            ($iMaxTokens !== FALSE ? $iMaxTokens : Registry::getConfig()->getConfigParam('iKussinPositionApiMaxTokens'))
        );
    }
}
