<?php

namespace Kussin\ChatGpt\Controller\Admin;

use Kussin\ChatGpt\Traits\GridUtilitiesTrait;
use Kussin\ChatGpt\Traits\OxidObjectsTrait;
use Kussin\ChatGpt\Traits\StorageTrait;
use OxidEsales\EshopCommunity\Application\Controller\Admin\AdminController;

class ChatGPTBulkApproval extends AdminController
{
    use GridUtilitiesTrait;
    use OxidObjectsTrait;
    use StorageTrait;

    protected $_sThisTemplate = 'chatgpt_bulk_approval.tpl';

    public function render()
    {
        parent::render();

        // ACTIONS
        $this->_aViewData['page_limits'] =  $this->_getStorageKey('admin')['chatgpt_bulk_approval']['chatgpt_bulk_actions']['page_limits'];
        $this->_aViewData['sorting'] =  $this->_getStorageKey('admin')['chatgpt_bulk_approval']['chatgpt_bulk_actions']['sorting'];

        $this->_aViewData['grid'] =  $this->_getGrid();

        return $this->_sThisTemplate;
    }
}
