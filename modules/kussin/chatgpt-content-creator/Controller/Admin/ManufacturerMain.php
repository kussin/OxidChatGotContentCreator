<?php

namespace Kussin\ChatGpt\Controller\Admin;

use Kussin\ChatGpt\Traits\ChatGPTClientTrait;
use Kussin\ChatGpt\Traits\LoggerTrait;
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
                // SAVE CATEGORY
                parent::save();

                // SAVE DESCRIPTION
                $oManufacturer = oxNew(Manufacturer::class);
                $oManufacturer->load( $this->_kussinLoadManufacturer()->getId() );

                $oContent = new Field($aResponse['data']);
                $oManufacturer->oxmanufacturers__oxshortdesc = $oContent;

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
