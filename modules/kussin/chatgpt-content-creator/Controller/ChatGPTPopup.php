<?php

namespace Kussin\ChatGpt\Controller;

use Kussin\ChatGpt\Traits\OxidObjectsTrait;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\EshopCommunity\Application\Controller\Admin\AdminController;

class ChatGPTPopup extends AdminController
{
    use OxidObjectsTrait;

    protected $_blAproved = false;
    protected $_blButtonsDisabled = false;

    protected $_sThisTemplate = 'chatgpt_popup.tpl';

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

        // LOAD OBJECT
        $oObject = $this->_getOxidObject($aData['object']);

        $this->_aViewData['title'] = $this->_getObjectTitle($oObject, $aData['object_id']);
        $this->_aViewData['cgptid'] = $iChatGPTId;
        $this->_aViewData['approved'] = ($this->_blAproved) ? 'true' : 'false';
        $this->_aViewData['btn_disabled'] = ($this->_blButtonsDisabled) ? 1 : 0;

        return $this->_sThisTemplate;
    }

    public function regenerate()
    {
        // TODO: Implement regenerate() method.
    }

    public function optimize()
    {
        // TODO: Implement optimize() method.
    }

    public function approve()
    {
        // TODO: Implement approve() method.
        $this->_blAproved = true;
        $this->_blButtonsDisabled = true;
    }
}
