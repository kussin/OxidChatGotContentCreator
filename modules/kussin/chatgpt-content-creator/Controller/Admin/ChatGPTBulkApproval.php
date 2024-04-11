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

    private $_sSearchTerm = false;
    private $_bActions = false;

    protected $_sThisTemplate = 'chatgpt_bulk_approval.tpl';

    public function render()
    {
        parent::render();

        // ACTIONS
        $aActions = $this->_getStorageKey('admin')['chatgpt_bulk_approval']['chatgpt_bulk_actions']['actions'];
        $this->_bActions = (count($aActions) > 0);

        // VIEW DATA
        $this->_aViewData['searchterm'] = $this->_getStorageKey('admin')['chatgpt_bulk_approval']['chatgpt_bulk_actions']['searchterm'];
        $this->_aViewData['manufacturer'] = $this->_getManufacturerList();
        $this->_aViewData['categories'] = $this->_getCategoryList();
        $this->_aViewData['has_actions'] = $this->_bActions;
        $this->_aViewData['actions'] = $aActions;
        $this->_aViewData['page_limits'] =  $this->_getStorageKey('admin')['chatgpt_bulk_approval']['chatgpt_bulk_actions']['page_limits'];
        $this->_aViewData['sorting'] =  $this->_getStorageKey('admin')['chatgpt_bulk_approval']['chatgpt_bulk_actions']['sorting'];
        $this->_aViewData['page'] = ($this->_getStorageKey('admin')['chatgpt_bulk_approval']['chatgpt_bulk_actions']['page'] + 1);
        $this->_aViewData['pages'] = $this->_getNumberOfPages();

        $this->_aViewData['grid'] =  $this->_getGrid();

        return $this->_sThisTemplate;
    }

    public function search()
    {
        $sSearchTerm = trim(Registry::getRequest()->getRequestEscapedParameter('searchterm'));

        // SAVE SEARCH TERM
        $this->_setStorageKey('admin/chatgpt_bulk_approval/chatgpt_bulk_actions/searchterm', $sSearchTerm);
    }

    public function manufacturer()
    {
        $sManufacturerId = trim(Registry::getRequest()->getRequestEscapedParameter('asn_manufacturer'));

        // SAVE MANUFACTURER ID
        $this->_setStorageKey('admin/chatgpt_bulk_approval/chatgpt_bulk_actions/manufacturer', $sManufacturerId);

        // TODO: Add manufacturer functionality
    }

    private function _getManufacturerList() : array
    {
        $aManufacturerList = array();

        // CURRENT SELECTED MANUFACTURER
        $sCurrentSelectedManufacturerId = $this->_getStorageKey('admin')['chatgpt_bulk_approval']['chatgpt_bulk_actions']['manufacturer'];

        // BUILD SQL QUERY
        $sQuery  = "SELECT DISTINCT `OXID`, `OXACTIVE`, `OXTITLE` FROM oxmanufacturers ORDER BY `OXTITLE` ASC";

        $oResult = DatabaseProvider::getDb(DatabaseProvider::FETCH_MODE_ASSOC)->select($sQuery);

        if ($oResult != false && $oResult->count() > 0) {
            while (!$oResult->EOF) {
                $aData = $oResult->getFields();

                $aManufacturerList[] = array(
                    'value' => $aData['OXID'],
                    'selected' => ($sCurrentSelectedManufacturerId === $aData['OXID']),
                    'status' => (int) $aData['OXACTIVE'] === 1 ? '1' : '0',
                    'label' => $aData['OXTITLE'],
                );

                //do something
                $oResult->fetchRow();
            }
        }

        return $aManufacturerList;
    }

    public function category()
    {
        $sCategoryId = trim(Registry::getRequest()->getRequestEscapedParameter('asn_category'));

        // SAVE CATEGORY ID
        $this->_setStorageKey('admin/chatgpt_bulk_approval/chatgpt_bulk_actions/category', $sCategoryId);

        // TODO: Add category functionality
    }

    private function _getCategoryList()
    {
        $aCategoryList = array();

        // CURRENT SELECTED CATEGORY
        $sCurrentSelectedCategoryId = $this->_getStorageKey('admin')['chatgpt_bulk_approval']['chatgpt_bulk_actions']['category'];

        // BUILD SQL QUERY
        $sQuery  = "SELECT DISTINCT `OXID`, `OXPARENTID`, `OXACTIVE`, `OXHIDDEN`, `OXTITLE` FROM oxcategories WHERE (`OXPARENTID` LIKE 'oxrootid') ORDER BY `OXSORT` ASC";

        $oResult = DatabaseProvider::getDb(DatabaseProvider::FETCH_MODE_ASSOC)->select($sQuery);

        if ($oResult != false && $oResult->count() > 0) {
            while (!$oResult->EOF) {
                $aData = $oResult->getFields();

                $aCategoryList[] = array(
                    'value' => $aData['OXID'],
                    'selected' => ($sCurrentSelectedCategoryId === $aData['OXID']),
                    'status' => (int) $aData['OXACTIVE'] === 1 ? '1' : '0',
                    'hidden' => (int) $aData['OXHIDDEN'] === 1 ? '1' : '0',
                    'label' => $aData['OXTITLE'],
                );

                //do something
                $oResult->fetchRow();
            }
        }

        return $aCategoryList;
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
