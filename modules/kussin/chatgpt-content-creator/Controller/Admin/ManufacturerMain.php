<?php

namespace Kussin\ChatGpt\Controller\Admin;

use Kussin\ChatGpt\Traits\ChatGPTClientTrait;
use Kussin\ChatGpt\Traits\LoggerTrait;
use OxidEsales\Eshop\Application\Model\Category;
use OxidEsales\Eshop\Application\Model\Manufacturer;
use OxidEsales\Eshop\Core\Field;
use OxidEsales\Eshop\Core\Registry;

class ManufacturerMain extends ManufacturerMain_parent
{
    use ChatGPTClientTrait;
    use LoggerTrait;

    private $_oManufacturer = null;

    private function _kussinLoadManufacturer()
    {
        if ($this->_oManufacturer === null) {
            $this->_oManufacturer = oxNew(Manufacturer::class);
            $this->_oManufacturer->load($this->getEditObjectId());
        }

        return $this->_oManufacturer;
    }

    public function kussinchatgptlongdesc()
    {
        $iMaxTokens = (int) Registry::getConfig()->getConfigParam('iKussinChatGptApiMaxTokens');

        // PROMPT
        $oLang = Registry::getLang();
        $sPrompt = $oLang->translateString('KUSSIN_CHATGPT_MANUFACTURER_LONG_DESCRIPTION_PROMPT', $oLang->getBaseLanguage());

        $this->_info(array(
            'method' => __CLASS__ . '::' . __FUNCTION__,
            'prompt' => $oException,
            'params' => array(
                'category' => $this->_kussinLoadManufacturer()->oxmanufacturers__oxtitle->value,
                'url' => $this->_kussinLoadManufacturer()->getLink(),
                'max_tokens' => $iMaxTokens,
            ),
        ));

        // GET PROMPT
        $sPrompt = sprintf(
            $sPrompt,
            $this->_kussinLoadManufacturer()->oxmanufacturers__oxtitle->value,
            $this->_kussinLoadManufacturer()->getLink(),
            $iMaxTokens
        );

        // GET CHATGPT CONTENT
        $aResponse = $this->_kussinGetChatGptContent($sPrompt, FALSE, FALSE, floor($iMaxTokens * 1.1), TRUE);

        if ($aResponse['error'] == NULL) {

            try {
                // SAVE MANUFACTURER
                parent::save();

                // SAVE DESCRIPTION
                $oManufacturer = oxNew(Manufacturer::class);
                $oManufacturer->load( $this->_kussinLoadManufacturer()->getId() );

                $oManufacturer->oxmanufacturers__kussinlongdesc = new Field(trim($aResponse['data']));
                $oManufacturer->oxmanufacturers__kussinchatgptgenerated = new Field(1);

                $oManufacturer->save();

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
        $sPrompt = $oLang->translateString('KUSSIN_CHATGPT_MANUFACTURER_SHORT_DESCRIPTION_PROMPT', $oLang->getBaseLanguage());

        $this->_info(array(
            'method' => __CLASS__ . '::' . __FUNCTION__,
            'prompt' => $oException,
            'params' => array(
                'category' => $this->_kussinLoadManufacturer()->oxmanufacturers__oxtitle->value,
                'url' => $this->_kussinLoadManufacturer()->getLink(),
                'max_tokens' => $iMaxTokens,
            ),
        ));

        // GET PROMPT
        $sPrompt = sprintf(
            $sPrompt,
            $this->_kussinLoadManufacturer()->oxmanufacturers__oxtitle->value,
            $this->_kussinLoadManufacturer()->getLink()
        );

        // GET CHATGPT CONTENT
        $aResponse = $this->_kussinGetChatGptContent($sPrompt, FALSE, FALSE, floor($iMaxTokens * 0.9));

        if ($aResponse['error'] == NULL) {

            try {
                // SAVE MANUFACTURER
                parent::save();

                // SAVE DESCRIPTION
                $oManufacturer = oxNew(Manufacturer::class);
                $oManufacturer->load( $this->_kussinLoadManufacturer()->getId() );

                $oManufacturer->oxmanufacturers__oxshortdesc = new Field(trim($aResponse['data']));
                $oManufacturer->oxmanufacturers__kussinchatgptgenerated = new Field(1);

                $oManufacturer->save();

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
