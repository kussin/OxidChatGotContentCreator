<?php

namespace Kussin\ChatGpt\Controller\Admin;

use Kussin\ChatGpt\Traits\ArticleDataEnhancerTrait;
use Kussin\ChatGpt\Traits\ChatGPTClientTrait;
use Kussin\ChatGpt\Traits\ChatGPTPromptOptimizerTrait;
use Kussin\ChatGpt\Traits\LanguageTrait;
use Kussin\ChatGpt\Traits\LoggerTrait;
use OxidEsales\Eshop\Application\Model\Article;
use OxidEsales\Eshop\Core\Field;
use OxidEsales\Eshop\Core\Registry;
use QuneMedia\ChatGpt\Prompts\LanguageMapper;
use QuneMedia\ChatGpt\Prompts\Prompt;

class ArticleMain extends ArticleMain_parent
{
    use ArticleDataEnhancerTrait;
    use ChatGPTClientTrait;
    use ChatGPTPromptOptimizerTrait;
    use LanguageTrait;
    use LoggerTrait;

    private $_oArticle = null;



    public function render()
    {
        $oLang = Registry::getLang();
        $sBaseLocaleCode = LanguageMapper::getLocaleCode($oLang->getLanguageAbbr($oLang->getBaseLanguage()));
        $sEditLocaleCode = LanguageMapper::getLocaleCode($oLang->getLanguageAbbr(
            (int) Registry::getRequest()->getRequestEscapedParameter('editlanguage')
        ));

        $this->_aViewData["chatgpttranslatedisabled"] = ($sBaseLocaleCode == $sEditLocaleCode);
        $this->_aViewData["baselocalecode"] = $sBaseLocaleCode;
        $this->_aViewData["editlocalecode"] = $sEditLocaleCode;

        return parent::render();
    }

    private function _kussinLoadArticle($bLoadBaseArticle = false)
    {
        // LOAD PARAMS
        $iEditLanguage = Registry::getRequest()->getRequestEscapedParameter('editlanguage');

        if ($this->_oArticle === null) {
            $this->_oArticle = oxNew(Article::class);

            if ($iEditLanguage && !$bLoadBaseArticle) {
                $this->_oArticle->loadInLang($iEditLanguage, $this->getEditObjectId());
            } else {
                $this->_oArticle->load($this->getEditObjectId());
            }
        }

        return $this->_oArticle;
    }

    public function kussinchatgptlongdesc()
    {
        // LOAD PARAMS
        $iEditLanguage = Registry::getRequest()->getRequestEscapedParameter('editlanguage');
        $sEditLocaleCode = Registry::getRequest()->getRequestEscapedParameter('editlocalecode');

        $iMaxTokens = (int) Registry::getConfig()->getConfigParam('iKussinChatGptApiMaxTokens');
        $sPrompt = trim(Registry::getConfig()->getConfigParam('sKussinChatGptPromptLongDescription' . $this->_getLanguageCode($iEditLanguage)));

        if ($sPrompt == '') {
            // FALLBACK
            $sPrompt = Prompt::load()->get('LONG_DESCRIPTION', $sEditLocaleCode);
        }

        $this->_info(array(
            'method' => __CLASS__ . '::' . __FUNCTION__,
            'prompt' => $oException,
            'params' => array(
                'title' => $this->_kussinLoadArticle()->oxarticles__oxtitle->value,
                'manufacturer' => $this->_kussinLoadArticle()->getManufacturer()->oxmanufacturers__oxtitle->value,
                'max_tokens' => $iMaxTokens,
            ),
        ));

        // GET PROMPT
        $sPrompt = sprintf(
            $sPrompt,
            $this->_optimizePromptValue($this->_kussinLoadArticle()->oxarticles__oxtitle->value),
            $this->_kussinLoadArticle()->getManufacturer()->oxmanufacturers__oxtitle->value,
            $iMaxTokens
        );

        // EXTENT PROMPT W/ ENHANCED ARTICLE DATA
        $sArticleIdKey = trim(Registry::getConfig()->getConfigParam('sKussinChatGptArticleDataEnhancerArticleIdKey'));
        $sPrompt .= $this->_getEnhancedArticlePrompt($this->_kussinLoadArticle()->{$sArticleIdKey}->value);

        // GET CHATGPT CONTENT
        $aResponse = $this->_kussinGetChatGptContentLongDescription($sPrompt, FALSE, FALSE, floor($iMaxTokens * 1.1), TRUE);

        if ($aResponse['error'] == NULL) {

            try {
                // SAVE ARTICLE
                parent::save();

                // SAVE DESCRIPTION
                $oArticle = oxNew(Article::class);
                $oArticle->loadInLang($iEditLanguage, $this->_kussinLoadArticle()->getId());

                $oContent = new Field(trim($aResponse['data']));
                $oArticle->setArticleLongDesc($oContent->getRawValue());

                $oArticle->save();

            } catch (\Exception $oException) {
                // ERROR
                $this->_error(array(
                    'method' => __CLASS__ . '::' . __FUNCTION__,
                    'response' => $oException,
                ));
            }
        }
    }

    public function kussinchatgptoptimizedesc()
    {
        // LOAD PARAMS
        $iEditLanguage = Registry::getRequest()->getRequestEscapedParameter('editlanguage');
        $sEditLocaleCode = Registry::getRequest()->getRequestEscapedParameter('editlocalecode');

        $iMaxTokens = (int) Registry::getConfig()->getConfigParam('iKussinChatGptApiMaxTokens');
        $sPrompt = trim(Registry::getConfig()->getConfigParam('sKussinChatGptPromptOptimizeContent' . $this->_getLanguageCode($iEditLanguage)));

        if ($sPrompt == '') {
            // FALLBACK
            $sPrompt = Prompt::load()->get('OPTIMIZE_CONTENT', $sEditLocaleCode);
        }

        $this->_info(array(
            'method' => __CLASS__ . '::' . __FUNCTION__,
            'prompt' => $sPrompt,
            'params' => array(
                'longdesc' => $this->_kussinLoadArticle()->getLongDescription(),
            ),
        ));

        // GET PROMPT
        $sPrompt = sprintf(
            $sPrompt,
            $this->_kussinLoadArticle()->getLongDescription(),
        );

        // EXTENT PROMPT W/ ENHANCED ARTICLE DATA
        $sArticleIdKey = trim(Registry::getConfig()->getConfigParam('sKussinChatGptArticleDataEnhancerArticleIdKey'));
        $sPrompt .= $this->_getEnhancedArticlePrompt($this->_kussinLoadArticle()->{$sArticleIdKey}->value);

        // GET CHATGPT CONTENT
        $aResponse = $this->_kussinGetChatGptContent($sPrompt, FALSE, FALSE, floor($iMaxTokens * 1.1), TRUE);

        if ($aResponse['error'] == NULL) {

            try {
                // SAVE ARTICLE
                parent::save();

                // SAVE DESCRIPTION
                $oArticle = oxNew(Article::class);
                $oArticle->loadInLang($iEditLanguage, $this->_kussinLoadArticle()->getId());

                $oContent = new Field(trim($aResponse['data']));
                $oArticle->setArticleLongDesc($oContent->getRawValue());
                $oArticle->oxarticles__kussinchatgptgenerated = new Field(1);

                $oArticle->save();

            } catch (\Exception $oException) {
                // ERROR
                $this->_error(array(
                    'method' => __CLASS__ . '::' . __FUNCTION__,
                    'response' => $oException,
                ));
            }
        }
    }

    public function kussinchatgptshortdesc()
    {
        // LOAD PARAMS
        $iEditLanguage = Registry::getRequest()->getRequestEscapedParameter('editlanguage');
        $sEditLocaleCode = Registry::getRequest()->getRequestEscapedParameter('editlocalecode');

        $iMaxTokens = 150;
        $sPrompt = trim(Registry::getConfig()->getConfigParam('sKussinChatGptPromptShortDescription' . $this->_getLanguageCode($iEditLanguage)));

        if ($sPrompt == '') {
            // FALLBACK
            $sPrompt = Prompt::load()->get('SHORT_DESCRIPTION', $sEditLocaleCode);
        }

        $this->_info(array(
            'method' => __CLASS__ . '::' . __FUNCTION__,
            'prompt' => $sPrompt,
            'params' => array(
                'title' => $this->_kussinLoadArticle()->oxarticles__oxtitle->value,
                'manufacturer' => $this->_kussinLoadArticle()->getManufacturer()->oxmanufacturers__oxtitle->value,
                'max_tokens' => $iMaxTokens,
            ),
        ));

        // GET PROMPT
        $sPrompt = sprintf(
            $sPrompt,
            $this->_optimizePromptValue($this->_kussinLoadArticle()->oxarticles__oxtitle->value),
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
                $oArticle->loadInLang($iEditLanguage, $this->_kussinLoadArticle()->getId());

                $oArticle->oxarticles__oxshortdesc = new Field(trim($aResponse['data']));
                $oArticle->oxarticles__kussinchatgptgenerated = new Field(1);

                $oArticle->save();

            } catch (\Exception $oException) {
                // ERROR
                $this->_error(array(
                    'method' => __CLASS__ . '::' . __FUNCTION__,
                    'response' => $oException,
                ));
            }
        }
    }

    public function kussinchatgpttranslatetitle()
    {
        // LOAD PARAMS
        $iEditLanguage = Registry::getRequest()->getRequestEscapedParameter('editlanguage');
        $sBaseLocaleCode = Registry::getRequest()->getRequestEscapedParameter('baselocalecode');
        $sEditLocaleCode = Registry::getRequest()->getRequestEscapedParameter('editlocalecode');

        $sPrompt = sprintf(
            Prompt::load()->get('TRANSLATION_TITLE', $sEditLocaleCode),
            $this->_optimizePromptValue($this->_kussinLoadArticle(true)->oxarticles__oxtitle->value),
            Prompt::load()->get('LABEL___' . $sBaseLocaleCode, $sEditLocaleCode)
        );

        // LOG
        $this->_info(array(
            'method' => __CLASS__ . '::' . __FUNCTION__,
            'prompt' => $sPrompt,
            'params' => array(
                'title' => $this->_kussinLoadArticle()->oxarticles__oxtitle->value,
                'language' => Prompt::load()->get('LABEL___' . $sBaseLocaleCode, $sEditLocaleCode),
            ),
        ));

        // GET CHATGPT TRANSALTION
        $aResponse = $this->_translate($sPrompt);

        if ($aResponse['error'] == NULL) {

            try {
                // SAVE ARTICLE
                parent::save();

                // SAVE DESCRIPTION
                $oArticle = oxNew(Article::class);
                $oArticle->loadInLang( $iEditLanguage, $this->_kussinLoadArticle()->getId() );

                $oArticle->oxarticles__oxtitle = new Field(trim($aResponse['data']));
                $oArticle->oxarticles__kussinchatgptgenerated = new Field(1);

                $oArticle->save();

            } catch (\Exception $oException) {
                // ERROR
                $this->_error(array(
                    'method' => __CLASS__ . '::' . __FUNCTION__,
                    'response' => $oException,
                ));
            }
        }
    }

    public function kussinchatgpttranslatelongdesc()
    {
        // LOAD PARAMS
        $sBaseLocaleCode = Registry::getRequest()->getRequestEscapedParameter('baselocalecode');
        $sEditLocaleCode = Registry::getRequest()->getRequestEscapedParameter('editlocalecode');

        $sPrompt = sprintf(
            Prompt::load()->get('TRANSLATION_LONG_TRANSLATION', $sEditLocaleCode),
            $this->_optimizePromptValue($this->_kussinLoadArticle(true)->oxarticles__oxtitle->value),
            Prompt::load()->get('LABEL___' . $sBaseLocaleCode, $sEditLocaleCode),
            $this->_kussinLoadArticle()->getLongDescription()
        );

        // LOG
        $this->_info(array(
            'method' => __CLASS__ . '::' . __FUNCTION__,
            'prompt' => $sPrompt,
            'params' => array(
                'title' => $this->_kussinLoadArticle()->oxarticles__oxtitle->value,
                'language' => Prompt::load()->get('LABEL___' . $sBaseLocaleCode, $sEditLocaleCode),
                'longdesc' => $this->_kussinLoadArticle()->getLongDescription(),
            ),
        ));

        // GET CHATGPT TRANSALTION
        $aResponse = $this->_translate($sPrompt);

        // TODO: SAVE TRANSLATION
    }

    public function kussinchatgpttranslateshortdesc()
    {
        // LOAD PARAMS
        $sBaseLocaleCode = Registry::getRequest()->getRequestEscapedParameter('baselocalecode');
        $sEditLocaleCode = Registry::getRequest()->getRequestEscapedParameter('editlocalecode');

        $sPrompt = sprintf(
            Prompt::load()->get('TRANSLATION_SHORT_DESCRIPTION', $sEditLocaleCode),
            $this->_optimizePromptValue($this->_kussinLoadArticle(true)->oxarticles__oxtitle->value),
            Prompt::load()->get('LABEL___' . $sBaseLocaleCode, $sEditLocaleCode),
            $this->_kussinLoadArticle()->oxarticles__oxshortdesc->value
        );

        // LOG
        $this->_info(array(
            'method' => __CLASS__ . '::' . __FUNCTION__,
            'prompt' => $sPrompt,
            'params' => array(
                'title' => $this->_kussinLoadArticle()->oxarticles__oxtitle->value,
                'language' => Prompt::load()->get('LABEL___' . $sBaseLocaleCode, $sEditLocaleCode),
                'shortdesc' => $this->_kussinLoadArticle()->oxarticles__oxshortdesc->value,
            ),
        ));

        // GET CHATGPT TRANSALTION
        $aResponse = $this->_translate($sPrompt);

        if ($aResponse['error'] == NULL) {

            try {
                // SAVE ARTICLE
                parent::save();

                // SAVE DESCRIPTION
                $oArticle = oxNew(Article::class);
                $oArticle->loadInLang( $iEditLanguage, $this->_kussinLoadArticle()->getId() );

                $oArticle->oxarticles__oxshortdesc = new Field(trim($aResponse['data']));
                $oArticle->oxarticles__kussinchatgptgenerated = new Field(1);

                $oArticle->save();

            } catch (\Exception $oException) {
                // ERROR
                $this->_error(array(
                    'method' => __CLASS__ . '::' . __FUNCTION__,
                    'response' => $oException,
                ));
            }
        }
    }
}
