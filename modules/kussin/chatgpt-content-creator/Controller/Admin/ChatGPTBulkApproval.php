<?php

namespace Kussin\ChatGpt\Controller\Admin;

use Kussin\ChatGpt\Traits\GridUtilitiesTrait;
use Kussin\ChatGpt\Traits\LoggerTrait;
use Kussin\ChatGpt\Traits\OxidObjectsTrait;
use Kussin\ChatGpt\Traits\StorageTrait;
use OxidEsales\Eshop\Core\DatabaseProvider;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\EshopCommunity\Application\Controller\Admin\AdminController;

class ChatGPTBulkApproval extends AdminController
{
    use GridUtilitiesTrait;
    use LoggerTrait;
    use OxidObjectsTrait;
    use StorageTrait;

    private $_bActions = false;

    protected $_sThisTemplate = 'chatgpt_bulk_approval.tpl';

    public function render()
    {
        parent::render();

        // ACTIONS
        $aActions = $this->_getStorageKey('admin')['chatgpt_bulk_approval']['chatgpt_bulk_actions']['actions'];
        $this->_bActions = (count($aActions) > 0);

        // VIEW DATA
        $this->_aViewData['has_actions'] = $this->_bActions;
        $this->_aViewData['actions'] = $aActions;
        $this->_aViewData['page_limits'] =  $this->_getStorageKey('admin')['chatgpt_bulk_approval']['chatgpt_bulk_actions']['page_limits'];
        $this->_aViewData['sorting'] =  $this->_getStorageKey('admin')['chatgpt_bulk_approval']['chatgpt_bulk_actions']['sorting'];
        $this->_aViewData['page'] = ($this->_getStorageKey('admin')['chatgpt_bulk_approval']['chatgpt_bulk_actions']['page'] + 1);
        $this->_aViewData['pages'] = $this->_getNumberOfPages();

        $this->_aViewData['grid'] =  $this->_getGrid();

        return $this->_sThisTemplate;
    }

    public function actions()
    {
        $sActionCode = trim(Registry::getRequest()->getRequestEscapedParameter('actions'));
        $aSelectedData = Registry::getRequest()->getRequestEscapedParameter('editval');

        // PEPARE ACTION
        $aAction = explode('__', $sActionCode);

        // PEPARE DATA
        $aIds = array();
        foreach ($aSelectedData as $iKey => $aSelected) {
            $aIds[] = (int) $iKey;
        }

        if (count($aIds) > 0) {
            // ACTIONS
            switch ($aAction[0]) {
                case 'status':
                    $this->_setStatus($aIds, $aAction[1]);
                    break;

                default:
                    break;
            }
        }
    }

    protected function _setStatus($aIds, $sStatus = 'skipped')
    {
        try {
            // BUILD SQL QUERY
            $sQuery = "UPDATE `kussin_chatgpt_content_creator_queue` SET `status` = ? WHERE `id` IN (" . implode(',', $aIds) . ")";

            $iUpdated = DatabaseProvider::getDb()->execute($sQuery, array($sStatus));
        } catch (\Exception $oEx) {
            // ERROR

        }

        // MESSAGE
        // TODO: Add notification
    }
}
