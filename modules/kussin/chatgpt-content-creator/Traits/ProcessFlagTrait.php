<?php

namespace Kussin\ChatGpt\Traits;

use OxidEsales\Eshop\Core\Registry;

trait ProcessFlagTrait
{
    protected const FLAG_NAME = '.kussin-chatgpt-process-flag';
    protected const FLAG_EXPIRE = 14400;

    private function _hasFlag(): bool
    {
        $sFilename = Registry::getConfig()->getConfigParam('sCompileDir') . '/' . self::FLAG_NAME;

        if (file_exists($sFilename)) {
            $iFilemtime = filemtime($sFilename);
            $iTime = time();

            if (($iTime - $iFilemtime) > self::FLAG_EXPIRE) {
                $this->_removeFlag();
            }

            return true;
        }

        return false;
    }

    private function _setFlag(): bool
    {
        $sFilename = Registry::getConfig()->getConfigParam('sCompileDir') . '/' . self::FLAG_NAME;

        if (!file_exists($sFilename)) {
            return touch($sFilename);
        }

        return false;
    }

    private function _removeFlag(): bool
    {
        $sFilename = Registry::getConfig()->getConfigParam('sCompileDir') . '/' . self::FLAG_NAME;

        if (file_exists($sFilename)) {
            return unlink($sFilename);
        }

        return true;
    }
}