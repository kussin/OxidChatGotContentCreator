<?php

namespace Kussin\ChatGpt\Traits;

use OxidEsales\Eshop\Core\DatabaseProvider;
use OxidEsales\Eshop\Core\Registry;

trait GridUtilitiesTrait
{
    use LoggerTrait;
    use OxidObjectsTrait;
    use StorageTrait;

    private $_iPageLimit = NULL;
    private $_iNumberOfPages = NULL;

    public function reset()
    {
        // RESET
        $this->_resetStorage();
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

    public function sorting()
    {
        // GET PAGE SORTING
        $sSorting = trim(Registry::getRequest()->getRequestEscapedParameter('sorting'));

        // GET PAGE SORTING
        $aSortings = $this->_getStorageKey('admin')['chatgpt_bulk_approval']['chatgpt_bulk_actions']['sorting'];

        foreach ($aSortings as $iKey => $aSorting) {
            if ($aSorting['value'] == $sSorting) {
                $aSortings[$iKey]['selected'] = true;
            } else {
                $aSortings[$iKey]['selected'] = false;
            }
        }

        // SAVE PAGE SORTING
        $this->_setStorageKey('admin/chatgpt_bulk_approval/chatgpt_bulk_actions/sorting', $aSortings);
    }

    public function previous_page()
    {
        // GET PAGE
        $iPage = $this->_getStorageKey('admin')['chatgpt_bulk_approval']['chatgpt_bulk_actions']['page'];

        // DECREMENT PAGE
        $iPage--;

        $iPage = ($iPage < 0) ? 0 : $iPage;

        // SAVE PAGE SORTING
        $this->_setStorageKey('admin/chatgpt_bulk_approval/chatgpt_bulk_actions/page', $iPage);
    }

    public function next_page()
    {
        // GET PAGE
        $iPage = $this->_getStorageKey('admin')['chatgpt_bulk_approval']['chatgpt_bulk_actions']['page'];

        // INCREMENT PAGE
        $iPage++;

        $iPage = ($iPage > $this->_getNumberOfPages()) ? $this->_getNumberOfPages() : $iPage;

        // SAVE PAGE SORTING
        $this->_setStorageKey('admin/chatgpt_bulk_approval/chatgpt_bulk_actions/page', $iPage);
    }

    public function go_to_page()
    {
        // GET PAGE SORTING
        $iPage = (int) Registry::getRequest()->getRequestEscapedParameter('goto');

        // TODO: Validate page number

        // SAVE PAGE SORTING
        $this->_setStorageKey('admin/chatgpt_bulk_approval/chatgpt_bulk_actions/page', $iPage);
    }

    private function _getGrid(): array
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
                    $this->_getAdditionalData($aData['object'], $aData['object_id'], $aData['lang_id'])
                );

                //do something
                $oResult->fetchRow();
            }
        }

        return $aGrid;
    }

    protected function _getAdditionalData($sObject, $sObjectId, $iLang = 0): array
    {
        $aAdditionalData = array(
            'name' => $sObjectId,
            'has_preview' => false,
            'link' => '',
        );

        // LOAD OBJECT
        $oObject = $this->_getOxidObject($sObject);
        $oObject->load($sObjectId);

        switch ($sObject) {
            case 'oxarticles':
            case 'oxartextends':
                $aAdditionalData['name'] = $this->_getObjectTitle($oObject, $sObjectId, $sObject, $iLang);
                $aAdditionalData['has_preview'] = ((bool) $oObject->oxarticles__oxactive->value && ($oObject->oxarticles__oxstock->value > 0));
                $aAdditionalData['link'] = $oObject->getLink(NULL, true);
                break;

            default:
                break;
        }

        return $aAdditionalData;
    }

    private function _getSqlWhere() : string
    {
        // LOAD SEARCH TERM
        $sSearchTerm = $this->_getStorageKey('admin')['chatgpt_bulk_approval']['chatgpt_bulk_actions']['searchterm'];

        // LOAD MANUFACTURER ID
        $sManufacturerId = $this->_getStorageKey('admin')['chatgpt_bulk_approval']['chatgpt_bulk_actions']['manufacturer'];

        // LOAD CATEGORY ID
        $sCategoryId = $this->_getStorageKey('admin')['chatgpt_bulk_approval']['chatgpt_bulk_actions']['category'];

        if (
            ($sSearchTerm !== '')
            || ($sManufacturerId !== false)
            || ($sCategoryId !== false)
        ) {
            // INIT
            $aObjectIds = array();

            if ($sSearchTerm !== ''){
                $aObjectIdsFromOxarticles = $this->_searchIn(
                    'oxarticles',
                    ['OXID', 'OXARTNUM', 'OXEAN', 'OXMPN', 'OXTITLE', ],
                    $sSearchTerm
                );

                // HANDOVER
                $aObjectIds = $aObjectIdsFromOxarticles;
            }

            // TODO: Add addtional search db tables & fields


            // TODO: Add search functionality for manufacturer
            if ($sManufacturerId !== false) {
                $aObjectIdsFromOxmanufacturer = $this->_searchIn(
                    'oxarticles',
                    ['OXMANUFACTURERID'],
                    $sManufacturerId
                );

                // HANDOVER
                $aObjectIds = (count($aObjectIds) > 0) ? array_intersect($aObjectIds, $aObjectIdsFromOxmanufacturer) : $aObjectIdsFromOxmanufacturer;
            }

            // TODO: Add search functionality for categories
            if ($sCategoryId !== false) {
//                $aObjectIdsFromOxobject2category = $this->_searchIn(
//                    'oxobject2category',
//                    ['OXCATNID'],
//                    $sCategoryId,
//                    'OXOBJECTID'
//                );

                // HANDOVER
//                $aObjectIds = (count($aObjectIds) > 0) ? array_intersect($aObjectIds, $aObjectIdsFromOxobject2category) : $aObjectIdsFromOxobject2category;
            }

            // BUILD WHERE CLAUSE
            return " WHERE `object_id` IN ('" . implode("', '", $aObjectIds) . "')";
        }

        return " ";
    }

    protected function _searchIn($sTable, $aFields, $sSearchTerm, $sReturnedFiled = 'OXID') : array
    {
        $aOxids = array();

        // PEPARE WHERE CLAUSE
        $aWhere = array();
        foreach ($aFields as $sField) {
            $aWhere[] = $sField . " LIKE '%" . $sSearchTerm . "%'";
        }

        // BUILD SQL QUERY
        $sQuery = "SELECT " . $sReturnedFiled . " FROM " . $sTable . " WHERE " . implode(" OR ", $aWhere);

        $oResult = DatabaseProvider::getDb(DatabaseProvider::FETCH_MODE_ASSOC)->select($sQuery);

        if ($oResult != false && $oResult->count() > 0) {
            while (!$oResult->EOF) {
                $aData = $oResult->getFields();

                $aOxids[] = $aData[$sReturnedFiled];

                //do something
                $oResult->fetchRow();
            }
        }

        return $aOxids;
    }

    private function _getSqlOrderBy() : string
    {
        $aSortings = $this->_getStorageKey('admin')['chatgpt_bulk_approval']['chatgpt_bulk_actions']['sorting'];

        foreach ($aSortings as $aSorting) {
            if ($aSorting['selected']) {
                $aValues = explode("__", $aSorting['value']);

                return " ORDER BY " . $aValues[0] . " " . $aValues[1];
            }
        }

        // FALLBACK
        return " ORDER BY updated_at DESC";
    }

    private function _getSqlLimit() : string
    {
        $iPage = $this->_getStorageKey('admin')['chatgpt_bulk_approval']['chatgpt_bulk_actions']['page'];
        $iPageLimit = $this->_getPageLimit();
        $iOffset = $iPage * $iPageLimit;

        // FALLBACK
        return " LIMIT " . $iOffset . ", " . $iPageLimit;
    }

    private function _getPageLimit() : int
    {
        if ($this->_iPageLimit === NULL) {
            // FALLBACK
            $this->_iPageLimit = 20;

            // GET PAGE LIMITS
            $aPageLimits = $this->_getStorageKey('admin')['chatgpt_bulk_approval']['chatgpt_bulk_actions']['page_limits'];

            foreach ($aPageLimits as $aPageLimit) {
                if ($aPageLimit['selected']) {
                    $this->_iPageLimit = $aPageLimit['value'];
                    break;
                }
            }
        }

        return $this->_iPageLimit;
    }

    private function _getNumberOfPages() : int
    {
        if ($this->_iNumberOfPages === NULL) {
            $this->_iNumberOfPages = 0;

            // BUILD SQL QUERY
            $sQuery  = "SELECT COUNT(*) AS count FROM kussin_chatgpt_content_creator_queue";
            $sQuery .= $this->_getSqlWhere();

            $oResult = DatabaseProvider::getDb(DatabaseProvider::FETCH_MODE_ASSOC)->select($sQuery);

            if ($oResult != false && $oResult->count() > 0) {
                $aData = $oResult->getFields();

                $this->_iNumberOfPages = ceil($aData['count'] / $this->_getPageLimit());
            }
        }

        return $this->_iNumberOfPages;
    }
}