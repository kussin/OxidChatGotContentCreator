<?php

namespace Kussin\ChatGpt\Traits;

use OxidEsales\Eshop\Core\Registry;

trait LoggerTrait
{
    private $_sFilename = null;

    private function _getLogger()
    {
        if ($this->_oLogger === null) {
            $this->_oLogger = Registry::getLogger();

            // SET LOG FILENAME
            $sLogfilePath = trim(Registry::getConfig()->getConfigParam('sKussinChatGptDebugLogFilename'));

            if ($sLogfilePath != '') {
                $this->_oLogger->setFilename(str_replace('//', '/', implode('/', array(
                    Registry::getConfig()->getConfigParam('sShopDir'),
                    $sLogfilePath,
                ))));
            }
        }

        return $this->_oLogger;
    }

    private function _log($sMessage, $sLevel = 'INFO')
    {
        // DEBUG MODE
        $bDebugMode = (bool) Registry::getConfig()->getConfigParam('blKussinChatGptDebugEnabled');

        if ($bDebugMode && ($sLevel == 'DEBUG' || $sLevel == 'INFO' || $sLevel == 'WARNING')) {
            $this->_log2file($sMessage, $sLevel);

        } else if ($sLevel == 'ERROR') {
            // ERROR
            $this->_log2file($sMessage, $sLevel);
        }
    }

    protected function _log2file($sMessage, $sLevel = 'INFO')
    {
        $sLogfilePath = trim(Registry::getConfig()->getConfigParam('sKussinChatGptDebugLogFilename'));

        if (($sLogfilePath != '') && ($this->_sFilename === null)) {
            $this->_sFilename = str_replace('//', '/', implode('/', array(
                Registry::getConfig()->getConfigParam('sShopDir'),
                $sLogfilePath,
            )));
        }

        if ($this->_sFilename != null) {
            $aLogEntry = array(
                '[' . date('Y-m-d H:i:s') . ']',
                '[type ' . $sLevel . ']',
                print_r($sMessage, true),
            );

            $rFile = fopen($this->_sFilename, 'a');
            fputs($rFile, implode(' ', $aLogEntry) . PHP_EOL);
            return fclose($rFile);
        }
    }

    protected function _info($sMessage)
    {
        $this->_log($sMessage);
    }

    protected function _debug($sMessage)
    {
        $this->_log($sMessage, 'DEBUG');
    }

    protected function _warning($sMessage)
    {
        $this->_log($sMessage, 'WARNING');
    }

    protected function _error($sMessage)
    {
        $this->_log($sMessage, 'ERROR');
    }

    private function _getClientIp($sIp = FALSE) {
        $sClientIp = NULL;

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $sClientIp = $_SERVER['HTTP_CLIENT_IP'];

        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $sClientIp = $_SERVER['HTTP_X_FORWARDED_FOR'];

        } else {
            $sClientIp = $_SERVER['REMOTE_ADDR'];
        }

        return ($sIp != FALSE) ? $sIp : $sClientIp;
    }
}