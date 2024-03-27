<?php

namespace Kussin\ChatGpt\Traits;

use OxidEsales\Eshop\Core\Module\Module;

trait StorageTrait
{
    private $_sCookieName = 'kussin_chatgpt_admin';
    private $_iCookieLifetime = 30;

    private $_aStorage = NULL;

    private function _getStorage()
    {
        if ($this->_aStorage === NULL) {
            $this->_loadStorage();
        }

        return $this->_aStorage;
    }

    private function _loadStorage()
    {
        // Check if COOKIE $_sCookieName is set
        if (!isset($_COOKIE[$this->_sCookieName])) {
            $this->_initStorage();
        }

        // LOAD STORAGE
        if ($this->_aStorage === NULL) {
            $this->_aStorage = json_decode(base64_decode($_COOKIE[$this->_sCookieName]), TRUE);
        }
    }

    private function _initStorage()
    {
        // INIT STORAGE
        $aStorageDefaults = array();

        // LOAD DEFAULTS
        $sModule = oxNew(Module::class);

        if ($sModule->load('kussin/chatgpt-content-creator')) {
            $sStoragePath = $sModule->getModuleFullPath() . '/storage.php';

            if (file_exists($sStoragePath)) {
                require_once $sStoragePath;

                // SET STORAGE DEFAULTS
                $this->_aStorage = $aStorageDefaults;
            }
        }

        // SET STORAGE COOKIE
        setcookie($this->_sCookieName, base64_encode(json_encode($this->_aStorage)), time() + 60 * 60 * 24 * $this->_iCookieLifetime, '/');
    }

    private function _resetStorage()
    {
        // DELETE STORAGE COOKIE
        setcookie($this->_sCookieName, '', time() - 3600, '/');

        // RESET STORAGE
        $this->_initStorage();
    }

    protected function _getStorageKey($sKey)
    {
        $aStorage = $this->_getStorage();

        return $aStorage[$sKey] ?? false;
    }

    protected function _setStorageKey($sXPath, $value)
    {
        $aStorage = $this->_getStorage();

        $aKeys = explode('/', $sXPath);

        switch (count($aKeys)) {
            case 5:
                $aStorage[$aKeys[0]][$aKeys[1]][$aKeys[2]][$aKeys[3]][$aKeys[4]] = $value;
                break;

            case 4:
                $aStorage[$aKeys[0]][$aKeys[1]][$aKeys[2]][$aKeys[3]] = $value;
                break;

            case 3:
                $aStorage[$aKeys[0]][$aKeys[1]][$aKeys[2]] = $value;
                break;

            case 2:
                $aStorage[$aKeys[0]][$aKeys[1]] = $value;
                break;

            case 1:
            default:
                $aStorage[$aKeys[0]] = $value;
                break;
        }

        // UPDATE STORAGE
        $this->_aStorage = $aStorage;

        // UPDATE STORAGE COOKIE
        setcookie($this->_sCookieName, base64_encode(json_encode($this->_aStorage)), time() + 60 * 60 * 24 * $this->_iCookieLifetime, '/');
    }
}