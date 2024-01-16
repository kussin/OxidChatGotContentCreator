<?php

namespace Kussin\ChatGpt\Traits;

trait JsonTrait
{
    protected function _getJsonContent($sJson)
    {
        if (!$this->_validateJsonContent($sJson)) {
            // FIX JSON
            $sJson = $this->_extractJsonContent($sJson);
        }

        $aData = json_decode($sJson, TRUE);

        return is_array($aData) ? $aData : FALSE;
    }

    private function _validateJsonContent($sJson)
    {
        // CHECK JSON
        $aData = json_decode($sJson);

        return (json_last_error() === JSON_ERROR_NONE);
    }

    private function _extractJsonContent($sJson)
    {
        preg_match('~\{(?:[^{}]|(?R))*\}~', $sJson, $aJsons);

        return count($aJsons) > 0 ? $aJsons[0] : FALSE;
    }
}