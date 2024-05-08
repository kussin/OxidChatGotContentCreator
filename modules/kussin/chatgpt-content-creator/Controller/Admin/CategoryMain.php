<?php

namespace Kussin\ChatGpt\Controller\Admin;

use Kussin\ChatGpt\Traits\ChatGPTClientTrait;
use Kussin\ChatGpt\Traits\LoggerTrait;
use OxidEsales\Eshop\Application\Model\Category;
use OxidEsales\Eshop\Core\Field;
use OxidEsales\Eshop\Core\Registry;

class CategoryMain extends CategoryMain_parent
{
    use ChatGPTClientTrait;
    use LoggerTrait;

    private $_oCategory = null;

    private function _kussinLoadCategory()
    {
        if ($this->_oCategory === null) {
            $this->_oCategory = oxNew(Category::class);
            $this->_oCategory->load($this->getEditObjectId());
        }

        return $this->_oCategory;
    }

    public function kussinchatgptlongdesc()
    {
        $iMaxTokens = (int) Registry::getConfig()->getConfigParam('iKussinChatGptApiMaxTokens');

        // PROMPT
        $oLang = Registry::getLang();
        $sPrompt = $oLang->translateString('KUSSIN_CHATGPT_CATGEORY_LONG_DESCRIPTION_PROMPT', $oLang->getBaseLanguage());

        $this->_info(array(
            'method' => __CLASS__ . '::' . __FUNCTION__,
            'prompt' => $oException,
            'params' => array(
                'category' => $this->_kussinLoadCategory()->oxcategories__oxtitle->value,
                'url' => $this->_kussinLoadCategory()->getLink(),
                'max_tokens' => $iMaxTokens,
            ),
        ));

        // GET PROMPT
        $sPrompt = sprintf(
            $sPrompt,
            $this->_kussinLoadCategory()->oxcategories__oxtitle->value,
            $this->_kussinLoadCategory()->getLink(),
            $iMaxTokens
        );

        // GET CHATGPT CONTENT
        $aResponse = $this->_kussinGetChatGptContent($sPrompt, FALSE, FALSE, floor($iMaxTokens * 1.1), TRUE);

        if ($aResponse['error'] == NULL) {

            try {
                // SAVE CATEGORY
                parent::save();

                // SAVE DESCRIPTION
                $oCategory = oxNew(Category::class);
                $oCategory->load( $this->_kussinLoadCategory()->getId() );

                $oCategory->oxcategories__oxlongdesc = new Field(trim($aResponse['data']));
                $oCategory->oxcategories__kussinchatgptgenerated = new Field(1);

                $oCategory->save();

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
        $iMaxTokens = 150;

        // PROMPT
        $oLang = Registry::getLang();
        $sPrompt = $oLang->translateString('KUSSIN_CHATGPT_CATGEORY_SHORT_DESCRIPTION_PROMPT', $oLang->getBaseLanguage());

        $this->_info(array(
            'method' => __CLASS__ . '::' . __FUNCTION__,
            'prompt' => $oException,
            'params' => array(
                'category' => $this->_kussinLoadCategory()->oxcategories__oxtitle->value,
                'url' => $this->_kussinLoadCategory()->getLink(),
                'max_tokens' => $iMaxTokens,
            ),
        ));

        // GET PROMPT
        $sPrompt = sprintf(
            $sPrompt,
            $this->_kussinLoadCategory()->oxcategories__oxtitle->value,
            $this->_kussinLoadCategory()->getLink()
        );

        // GET CHATGPT CONTENT
        $aResponse = $this->_kussinGetChatGptContent($sPrompt, FALSE, FALSE, floor($iMaxTokens * 0.9));

        if ($aResponse['error'] == NULL) {

            try {
                // SAVE CATEGORY
                parent::save();

                // SAVE DESCRIPTION
                $oCategory = oxNew(Category::class);
                $oCategory->load( $this->_kussinLoadCategory()->getId() );

                $oCategory->oxcategories__oxdesc = new Field(trim($aResponse['data']));
                $oCategory->oxcategories__kussinchatgptgenerated = new Field(1);

                $oCategory->save();

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
