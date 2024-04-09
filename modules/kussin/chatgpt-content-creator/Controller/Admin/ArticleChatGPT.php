<?php

namespace Kussin\ChatGpt\Controller\Admin;

use Kussin\ChatGpt\Traits\OxidObjectsTrait;
use Kussin\ChatGpt\Traits\StorageTrait;
use OxidEsales\Eshop\Application\Controller\Admin\AdminDetailsController;
use OxidEsales\Eshop\Application\Model\Article;
use OxidEsales\Eshop\Core\DatabaseProvider;
use OxidEsales\Eshop\Core\Registry;

class ArticleChatGPT extends AdminDetailsController
{
    use OxidObjectsTrait;
    use StorageTrait;

    protected $_blAproved = false;
    protected $_blButtonsDisabled = false;

    protected $_sThisTemplate = 'article_chatgpt.tpl';

    public function render()
    {
        parent::render();

        $aEdit = Registry::getConfig()->getRequestParameter( 'editval' );

        if($aEdit && $aEdit['oxid'] != '') {
            $sOxid = $aEdit['oxid'];

        } else {
            $sOxid = Registry::getConfig()->getRequestParameter( 'oxid');
        }

        // GET OBJECT ID
        $iChatGPTId = $this->_getChatGPTId($sOxid);

        $this->_aViewData['oxid'] = $sOxid;
        $this->_aViewData['cgptid'] = $iChatGPTId;
        $this->_aViewData['approved'] = ($this->_isObjectApproved($iChatGPTId)) ? 'true' : 'false';
        $this->_aViewData['btn_disabled'] = ($this->_areButtonsDisabled($iChatGPTId)) ? 1 : 0;

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

    protected function _getChatGPTId($sOxid = null, $iShopId = 1, $iLangId = 0) : int
    {
        if($sOxid == null) {
            return false;
        }

        // GET CHATGPT ID
        $sQuery  = 'SELECT `id` FROM `kussin_chatgpt_content_creator_queue` WHERE ' . implode(' AND ', array(
            '(`object` LIKE "oxartextends")',
            '(`field` LIKE "oxlongdesc")',
            '(`generated` IS NOT NULL)',
            '(`object_id` LIKE "' . $sOxid . '")',
            '(`shop_id` = ' . $iShopId . ')',
            '(`lang_id` = ' . $iLangId . ')',
        )) . ' ORDER BY `id` DESC LIMIT 1';

        $oResult = DatabaseProvider::getDb(DatabaseProvider::FETCH_MODE_ASSOC)->select($sQuery);

        if ($oResult != false && $oResult->count() > 0) {
            while (!$oResult->EOF) {
                $aData = $oResult->getFields();

                return (int) $aData['id'];

                //do something
                $oResult->fetchRow();
            }
        }

        return false;
    }
}
