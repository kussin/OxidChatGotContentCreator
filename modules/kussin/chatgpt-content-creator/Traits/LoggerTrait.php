<?php

namespace Kussin\ChatGpt\Traits;

use OxidEsales\Eshop\Core\Registry;

trait LoggerTrait
{
    private $_oLogger = null;

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

        // MESSAGE
        if (is_array($sMessage) || is_object($sMessage)) {
            $sMessage = json_encode($sMessage);
        }

        if ($bDebugMode && ($sLevel == 'DEBUG' || $sLevel == 'INFO' || $sLevel == 'WARNING')) {
            switch ($sLevel) {
                case 'DEBUG':
                    $this->_getLogger()->debug($sMessage);
                    break;
                case 'WARNING':
                    $this->_getLogger()->notice($sMessage);
                    break;
                case 'INFO':
                default:
                    $this->_getLogger()->info($sMessage);
                    break;
            }

        } else if ($sLevel == 'ERROR') {
            // ERROR
            $this->_getLogger()->error($sMessage);
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
}