<?php

namespace Kussin\ChatGpt\Controller\Admin;

use Kussin\ChatGpt\libs\PHPChatGPT\ChatGPT;
use Kussin\ChatGpt\Traits\LoggerTrait;
use OxidEsales\Eshop\Application\Model\Article;
use OxidEsales\Eshop\Core\DatabaseProvider;
use OxidEsales\Eshop\Core\Field;
use OxidEsales\Eshop\Core\Registry;

class ArticleMain extends ArticleMain_parent
{
    use LoggerTrait;

    private $_oArticle = null;

    private $_oChatGptClient = null;

    private function _kussinLoadArticle()
    {
        if ($this->_oArticle === null) {
            $this->_oArticle = oxNew(Article::class);
            $this->_oArticle->load($this->getEditObjectId());
        }

        return $this->_oArticle;
    }

    public function kussinchatgptlongdesc()
    {
        $iMaxTokens = (int) Registry::getConfig()->getConfigParam('iKussinPositionApiMaxTokens');
        $sPrompt = trim(Registry::getConfig()->getConfigParam('sKussinChatGptPromptLongDescriptionDE')); // TODO: MULTI-LANGUAL

        if ($sPrompt == '') {
            // FALLBACK
            $oLang = Registry::getLang();
            $sPrompt = $oLang->translateString('KUSSIN_CHATGPT_LONG_DESCRIPTION_PROMPT', $oLang->getBaseLanguage());
        }

        // GET PROMPT
        $sPrompt = sprintf(
            $sPrompt,
            $this->_kussinLoadArticle()->oxarticles__oxtitle->value,
            $this->_kussinLoadArticle()->getManufacturer()->oxmanufacturers__oxtitle->value,
            $iMaxTokens
        );

        // GET CHATGPT CONTENT
        $aResponse = $this->_kussinGetChatGptContent($sPrompt, FALSE, FALSE, floor($iMaxTokens * 1.1));

        if ($aResponse['error'] == NULL) {

            try {
                // SAVE ARTICLE
                parent::save();

                // SAVE DESCRIPTION
                $oArticle = oxNew(Article::class);
                $oArticle->load( $this->_kussinLoadArticle()->getId() );

                $oContent = new Field($aResponse['data']);
                $oArticle->setArticleLongDesc($oContent);

                $oArticle->save();

            } catch (\Exception $oException) {
                // ERROR
                echo $oException->getMessage();
                die();
            }
        }
    }

    public function kussinchatgptshortdesc()
    {
        $iMaxTokens = 150;
        $sPrompt = trim(Registry::getConfig()->getConfigParam('sKussinChatGptPromptLongDescriptionDE')); // TODO: MULTI-LANGUAL

        if ($sPrompt == '') {
            // FALLBACK
            $oLang = Registry::getLang();
            $sPrompt = $oLang->translateString('KUSSIN_CHATGPT_SHORT_DESCRIPTION_PROMPT', $oLang->getBaseLanguage());
        }

        // GET PROMPT
        $sPrompt = sprintf(
            $sPrompt,
            $this->_kussinLoadArticle()->oxarticles__oxtitle->value,
            $this->_kussinLoadArticle()->getManufacturer()->oxmanufacturers__oxtitle->value,
            $iMaxTokens
        );

        // GET CHATGPT CONTENT
        $aResponse = $this->_kussinGetChatGptContent($sPrompt, FALSE, FALSE, floor($iMaxTokens * 0.9));

        if ($aResponse['error'] == NULL) {

            try {
                // SAVE ARTICLE
                parent::save();

                // SAVE DESCRIPTION
                $oArticle = oxNew(Article::class);
                $oArticle->load( $this->_kussinLoadArticle()->getId() );

                $oContent = new Field($aResponse['data']);
                $oArticle->oxarticles__oxshortdesc = new Field($oContent);

                $oArticle->save();

            } catch (\Exception $oException) {
                // ERROR
                echo $oException->getMessage();
                die();
            }
        }
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
            ($dTemperature !== FALSE ? $dTemperature : (double) Registry::getConfig()->getConfigParam('dKussinChatGptApiTemperature')),
            ($iMaxTokens !== FALSE ? $iMaxTokens : (int) Registry::getConfig()->getConfigParam('iKussinPositionApiMaxTokens'))
        );
    }
}
