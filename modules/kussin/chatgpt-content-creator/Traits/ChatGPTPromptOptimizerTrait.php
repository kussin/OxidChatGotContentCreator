<?php

namespace Kussin\ChatGpt\Traits;

trait ChatGPTPromptOptimizerTrait
{
    protected function _optimizePrompt($sPrompt): string
    {
        // OPTIMIZATION
        $sOptimizedPrompt = $this->_removeBlankLines($sPrompt);
        $sOptimizedPrompt = $this->_removeQuoteWrapper($sOptimizedPrompt);

        return $sOptimizedPrompt;
    }

    protected function _optimizeResponse($sData): string
    {
        return $this->_optimizePrompt($sData);
    }

    protected function _optimizePromptValue($sValue): string
    {
        // OPTIMIZATION
        $sOptimizedValue = $this->_removeHtmlEntities($sValue);

        return $sOptimizedValue;
    }

    protected function _removeBlankLines($sValue): string
    {
        return trim(preg_replace('/^\s*|\s*$/m', '', $sValue));
    }

    protected function _removeQuoteWrapper($sValue): string
    {
        $sFirstChar = substr($sValue, 0, 1);
        $sLastChar = substr($sValue, -1);

        if ($sFirstChar === '"' && $sLastChar === '"') {
            $sValue = substr($sValue, 1, -1);
        }

        return $sValue;
    }

    protected function _removeHtmlEntities($sValue): string
    {
        // HOTFIX: &amp;quot;
        $sValue = str_replace(array('&quot;', '&amp;quot;'), "'", $sValue);

        return html_entity_decode($sValue, ENT_QUOTES, 'UTF-8');
    }
}