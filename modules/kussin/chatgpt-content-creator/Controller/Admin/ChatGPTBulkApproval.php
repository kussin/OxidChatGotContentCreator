<?php

namespace Kussin\ChatGpt\Controller\Admin;

use Kussin\ChatGpt\Traits\OxidObjectsTrait;
use OxidEsales\Eshop\Core\DatabaseProvider;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\EshopCommunity\Application\Controller\Admin\AdminController;

class ChatGPTBulkApproval extends AdminController
{
    use OxidObjectsTrait;

    protected $_sThisTemplate = 'chatgpt_bulk_approval.tpl';

    public function render()
    {
        parent::render();

        $this->_aViewData['grid'] =  $this->_getGrid();

        return $this->_sThisTemplate;
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
        return " LIMIT 20";
    }
}
