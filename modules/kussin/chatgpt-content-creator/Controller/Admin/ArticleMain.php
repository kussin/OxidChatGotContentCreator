<?php

namespace Kussin\ChatGpt\Controller\Admin;

use OxidEsales\Eshop\Application\Model\Article;
use OxidEsales\Eshop\Core\DatabaseProvider;

class ArticleMain extends ArticleMain_parent
{
    private $_oArticle = null;

    private function _kussinLoadArticle()
    {
        if ($this->_oArticle === null) {
            // SAVE ARTICLE
            parent::save();

            $this->_oArticle = oxNew(Article::class);
            $this->_oArticle->load($this->getEditObjectId());
        }

        return $this->_oArticle;
    }

    public function kussinchatgptlongdesc()
    {
        // LOAD ARTICLE
        $this->_kussinLoadArticle();

        // TODO: Generate long description from ChatGPT API
    }

    public function kussinchatgptshortdesc()
    {
        // LOAD ARTICLE
        $this->_kussinLoadArticle();

        // TODO: Generate short description from ChatGPT API
    }
}
