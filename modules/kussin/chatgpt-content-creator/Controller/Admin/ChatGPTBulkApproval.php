<?php

namespace Kussin\ChatGpt\Controller\Admin;

use OxidEsales\Eshop\Core\Registry;
use OxidEsales\EshopCommunity\Application\Controller\Admin\AdminController;

class ChatGPTBulkApproval extends AdminController
{
    protected $_sThisTemplate = 'chatgpt_bulk_approval.tpl';

    public function render()
    {
        parent::render();

        return $this->_sThisTemplate;
    }
}
