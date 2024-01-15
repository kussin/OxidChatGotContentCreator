<?php

namespace Kussin\ChatGpt\Traits;

trait JsonTrait
{
    protected function _getJsonContent($sJson)
    {
        $aData = json_decode($this->_prepareJsonContent($sJson), true);

        return is_array($aData) ? $aData : FALSE;
    }

    private function _prepareJsonContent($sJson)
    {
        // TODO: https://support.kussin.de/issues/63375#note-4

        return $sJson;
    }
}