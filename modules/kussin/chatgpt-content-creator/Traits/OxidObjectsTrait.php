<?php

namespace Kussin\ChatGpt\Traits;

use OxidEsales\Eshop\Application\Model\Article;
use OxidEsales\Eshop\Application\Model\Category;
use OxidEsales\Eshop\Application\Model\Manufacturer;
use OxidEsales\Eshop\Application\Model\Vendor;

trait OxidObjectsTrait
{
    private function _getOxidObject($sObject)
    {
        switch ($sObject) {
            case 'oxcategories':
                return oxNew(Category::class);

            case 'oxvendors':
                return oxNew(Vendor::class);

            case 'oxmanufacturers':
                return oxNew(Manufacturer::class);

            default:
            case 'oxarticles':
            case 'oxartextends':
                return oxNew(Article::class);
        }
    }

    private function _getOxidFieldId($sObjectId, $sFieldId, $iLang = 0): string
    {
        // SET LANG SUFFIX
        $sLangSuffix = ($iLang > 0) ? '_' . $iLang : '';

        return strtolower($sObjectId . '__' . $sFieldId . $sLangSuffix);
    }
}