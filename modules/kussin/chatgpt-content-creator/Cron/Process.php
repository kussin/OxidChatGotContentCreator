<?php

namespace Kussin\ChatGpt\Cron;

use Kussin\ChatGpt\Traits\ChatGPTProcessPromptsTrait;
use Kussin\ChatGpt\Traits\CustomDbTrait;
use Kussin\ChatGpt\Traits\LoggerTrait;
use Kussin\ChatGpt\Traits\OxidObjectsTrait;
use Kussin\ChatGpt\Traits\ProcessFlagTrait;
use OxidEsales\Eshop\Application\Controller\FrontendController;
use OxidEsales\Eshop\Core\DatabaseProvider;
use OxidEsales\Eshop\Core\Registry;

class Process extends FrontendController
{
    use ChatGPTProcessPromptsTrait;
    use CustomDbTrait;
    use LoggerTrait;
    use OxidObjectsTrait;
    use ProcessFlagTrait;

    protected const PROCESS_NEW_STATUS = 'pending';
    protected const PROCESS_PROCESSING_STATUS = 'processing';
    protected const PROCESS_GENERATED_STATUS = 'generated';
    protected const PROCESS_COMPLETE_STATUS = 'complete';
    protected const PROCESS_CANCELED_STATUS = 'cancaled';
    protected const PROCESS_ERROR_STATUS = 'error';

    private $_sProcessSelectionQueryVarname = 'sKussinChatGptProcessSelectionQuery';
    
    /**
     * @return string
     */
    public function render() {
        $this->_cron();
        exit;
    }
    
    private function _cron() {
        if (!$this->_hasFlag()) {
            $this->_setFlag();

            // PROCESS STEPS
            $this->_fillQueue();
            $this->_preparePrompt();

            $this->_removeFlag();

        } else {
            $this->_info('Process already running.');
        }
    }

    protected function _fillQueue() {
        if ($this->_isNewProcessDefined()) {
            $sSelectQuery = trim(Registry::getConfig()->getConfigParam('sKussinChatGptProcessSelectionQuery'));

            if (strlen($sSelectQuery) > '') {
                $this->_info('Queue filled with new processes.');

                $sQuery = implode(' ', array(
                    'INSERT IGNORE INTO `kussin_chatgpt_content_creator_queue` (`object`, `object_id`, `field`, `shop_id`, `lang_id`, `status`)',
                    $sSelectQuery,
                ));

                DatabaseProvider::getDb()->execute($sQuery);
            }
        }
    }

    protected function _preparePrompt($sLimit = 10) {
        $sQuery = 'SELECT `id`, `object`, `object_id`, `field`, `shop_id`, `lang_id`, `max_tokens` FROM kussin_chatgpt_content_creator_queue WHERE (`status` = "' . self::PROCESS_NEW_STATUS . '") ORDER BY `updated_at` ASC LIMIT ' . $sLimit . ';';

        foreach ($this->_getCustomDbResult($sQuery) as $aItem) {
            $oObject = $this->_getOxidObject($aItem[1]);
            $sOxid = $this->_getOxidObject($aItem[2]);
            $SFieldId = $this->_getOxidFieldId($aItem[1], $aItem[3], $aItem[5]);

            // LOAD OBJECT
            $oObject->load($sOxid);

            // GET PROMPT
            $sPrompt = $this->_getProcessPrompts($oObject, $SFieldId, $aItem[5], $aItem[6]);

            // SAVE PROMPT
            $sUpdateQuery = 'UPDATE kussin_chatgpt_content_creator_queue SET `prompt` = "' . $sPrompt . '", `status` = "' . self::PROCESS_PROCESSING_STATUS . '" WHERE (`id` = "' . $aItem[0] . '");';
            DatabaseProvider::getDb()->execute($sUpdateQuery);

            // CLEAR
            $oObject = null;
            $SFieldId = null;
        }
    }

    protected function _generateContent($sLimit = 1) {
        $sQuery = 'SELECT `id`, `object`, `object_id`, `field`, `shop_id`, `lang_id`, `prompt`, `model`, `max_tokens`, `max_tokens`, `temperature` FROM kussin_chatgpt_content_creator_queue WHERE (`status` = "' . self::PROCESS_PROCESSING_STATUS . '") ORDER BY `updated_at` ASC LIMIT ' . $sLimit . ';';

        foreach ($this->_getCustomDbResult($sQuery) as $aItem) {
            $oObject = $this->_getOxidObject($aItem[1]);
            $sOxid = $this->_getOxidObject($aItem[2]);
            $SFieldId = $this->_getOxidFieldId($aItem[1], $aItem[3], $aItem[5]);
            $sPrompt = $aItem[6];
            $sModel = $aItem[7];
            $iMaxTokens = (int) $aItem[8];
            $dTemperature = (double) $aItem[9];

            // LOAD OBJECT
            $oObject->load($sOxid);

            // TODO: GENERATE CONTENT
            $sGenerated = null;

            // TODO: BACKUP CONTENT
            $sContent = null;

            // SAVE PROMPT
            $sUpdateQuery = 'UPDATE kussin_chatgpt_content_creator_queue SET `content` = "' . $sContent . '", `generated` = "' . $sGenerated . '", `status` = "' . self::PROCESS_GENERATED_STATUS . '" WHERE (`id` = "' . $aItem[0] . '");';
            DatabaseProvider::getDb()->execute($sUpdateQuery);

            // CLEAR
            $oObject = null;
            $SFieldId = null;
        }
    }

    protected function _isNewProcessDefined(): bool
    {
        $sQuery = 'SELECT OXTIMESTAMP FROM oxconfig WHERE (OXVARNAME LIKE "' . $this->_sProcessSelectionQueryVarname . '");';
        $iLastProcessTimestamp = strtotime($this->_getCustomDbValue($sQuery));

        return ((time() - (15*60)) < $iLastProcessTimestamp);
    }
}