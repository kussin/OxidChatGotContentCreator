<?php

namespace Kussin\ChatGpt\Controller;

use Kussin\ChatGpt\Traits\ChatGPTProcessPromptsTrait;
use Kussin\ChatGpt\Traits\OxidObjectsTrait;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\EshopCommunity\Application\Controller\Admin\AdminController;

class ChatGPTPreview extends AdminController
{

    use ChatGPTProcessPromptsTrait;
    use OxidObjectsTrait;
    protected $_sThisTemplate = 'chatgpt_preview.tpl';

    public function render()
    {
        parent::render();

        // DATASET ID
        $iChatGPTId = (int) Registry::getRequest()->getRequestEscapedParameter('cgptid');

        // LOAD DATA
        $aData = $this->_getChatGPTData($iChatGPTId);

        if (
            !is_array($aData)
            || (isset($aData['id']) != $iChatGPTId)
        ) {
            // ERROR
            die('Invalid ChatGPT ID');
        }

        $this->_aViewData['generated'] = $this->_decodeProcessContent($aData['generated']);

        return $this->_sThisTemplate;
    }
}
