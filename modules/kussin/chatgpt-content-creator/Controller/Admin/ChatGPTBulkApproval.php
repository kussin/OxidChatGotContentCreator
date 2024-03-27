<?php

namespace Kussin\ChatGpt\Controller\Admin;

use Kussin\ChatGpt\Traits\OxidObjectsTrait;
use Kussin\ChatGpt\Traits\StorageTrait;
use OxidEsales\Eshop\Core\DatabaseProvider;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\EshopCommunity\Application\Controller\Admin\AdminController;

class ChatGPTBulkApproval extends AdminController
{
    use OxidObjectsTrait;
    use StorageTrait;

    protected $_sThisTemplate = 'chatgpt_bulk_approval.tpl';

    public function render()
    {
        parent::render();

        $this->_aViewData['page_limits'] =  $this->_getStorageKey('admin')['chatgpt_bulk_approval']['chatgpt_bulk_actions']['page_limits'];;
        $this->_aViewData['grid'] =  $this->_getGrid();

        return $this->_sThisTemplate;
    }

    public function page_limit()
    {
        // GET PAGE LIMIT
        $iPageLimit = (int) Registry::getRequest()->getRequestEscapedParameter('page_limit');

        // GET PAGE LIMITS
        $aPageLimits = $this->_getStorageKey('admin')['chatgpt_bulk_approval']['chatgpt_bulk_actions']['page_limits'];

        foreach ($aPageLimits as $iKey => $aPageLimit) {
            if ($aPageLimit['value'] == $iPageLimit) {
                $aPageLimits[$iKey]['selected'] = true;
            } else {
                $aPageLimits[$iKey]['selected'] = false;
            }
        }

        // SAVE PAGE LIMITS
        $this->_setStorageKey('admin/chatgpt_bulk_approval/chatgpt_bulk_actions/page_limits', $aPageLimits);
    }

    private function _getGrid()
    {
        $aGrid = array();

        // BUILD SQL QUERY
        $sQuery  = "SELECT * FROM kussin_chatgpt_content_creator_queue";
        $sQuery .= $this->_getSqlWhere();
        $sQuery .= $this->_getSqlOrderBy();
        $sQuery .= $this->_getSqlLimit();

        $oResult = DatabaseProvider::getDb(DatabaseProvider::FETCH_MODE_ASSOC)->select($sQuery);

        if ($oResult != false && $oResult->count() > 0) {
            while (!$oResult->EOF) {
                $aData = $oResult->getFields();

                $aGrid[] = array_merge(
                    $aData,
                    $this->_getAdditionalData($aData['object'], $aData['object_id'])
                );

                //do something
                $oResult->fetchRow();
            }
        }

        return $aGrid;
    }

    protected function _getAdditionalData($sObject, $sObjectId)
    {
        $aAdditionalData = array(
            'name' => $sObjectId,
        );

        // LOAD OBJECT
        $oObject = $this->_getOxidObject($sObject);
        $oObject->load($sObjectId);

        switch ($sObject) {
            case 'oxarticles':
                $aAdditionalData['name'] = $oObject->oxarticles__oxtitle->value;
                break;

            default:
                break;
        }

        return $aAdditionalData;
    }

    private function _getSqlWhere()
    {
        return " ";
    }

    private function _getSqlOrderBy()
    {
        return " ORDER BY updated_at DESC";
    }

    private function _getSqlLimit()
    {
        $_aPageLimits = $this->_getStorageKey('admin')['chatgpt_bulk_approval']['chatgpt_bulk_actions']['page_limits'];

        foreach ($_aPageLimits as $aPageLimit) {
            if ($aPageLimit['selected']) {
                return " LIMIT " . $aPageLimit['value'];
            }
        }

        return " LIMIT 20";
    }
}
