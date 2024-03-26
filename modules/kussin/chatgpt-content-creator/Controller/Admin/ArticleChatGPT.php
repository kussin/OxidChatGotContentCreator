<?php

namespace Kussin\ChatGpt\Controller\Admin;

use OxidEsales\Eshop\Application\Controller\Admin\AdminDetailsController;
use OxidEsales\Eshop\Core\Registry;

class ArticleChatGPT extends AdminDetailsController
{
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

        $this->_aViewData['oxid'] =  $sOxid;

        return $this->_sThisTemplate;
    }
}
