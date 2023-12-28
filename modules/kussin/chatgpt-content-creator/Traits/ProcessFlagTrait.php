<?php

namespace Kussin\ChatGpt\Traits;

use OxidEsales\Eshop\Core\Registry;

trait ProcessFlagTrait
{
    protected string $_sFlagName = '.kussin-chatgpt-process-flag';
    protected int $_iFlagExpires = 14400;

    private function _hasFlag(): bool
    {
        $sFilename = Registry::getConfig()->getConfigParam('sCompileDir') . '/' . $this->_sFlagName;

        if (file_exists($sFilename)) {
            $iFilemtime = filemtime($sFilename);
            $iTime = time();

            if (($iTime - $iFilemtime) > $this->_iFlagExpires) {
                $this->_removeFlag();
            }

            return true;
        }

        return false;
    }

    private function _setFlag(): bool
    {
        $sFilename = Registry::getConfig()->getConfigParam('sCompileDir') . '/' . $this->_sFlagName;

        if (!file_exists($sFilename)) {
            return touch($sFilename);
        }

        return false;
    }

    private function _removeFlag(): bool
    {
        $sFilename = Registry::getConfig()->getConfigParam('sCompileDir') . '/' . $this->_sFlagName;

        if (file_exists($sFilename)) {
            return unlink($sFilename);
        }

        return true;
    }
}