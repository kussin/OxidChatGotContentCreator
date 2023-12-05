<?php
/**
 * Metadata version
 */
$sMetadataVersion = '2.0';

use OxidEsales\Eshop\Application\Controller\Admin\ArticleMain;

/**
 * Module information
 */
$aModule = array(
    'id'           => 'kussin/chatgpt-content-creator',
    'title'        => 'Kussin | ChatGPT Content Creator for OXID eShop',
    'description'  => 'ChatGPT Integration for OXID eShop',
    'thumbnail'    => 'module.png',
    'version'      => '0.0.1',
    'author'       => 'Daniel Kussin',
    'url'          => 'https://www.kussin.de',
    'email'        => 'daniel.kussin@kussin.de',

    'extend'       => array(
        ArticleMain::class => Kussin\ChatGpt\Controller\Admin\ArticleMain::class,
    ),

    'blocks' => array(
        array(
            'template' => 'article_main.tpl',
            'block' => 'admin_article_main_form',
            'file' => 'views/blocks/admin/admin_article_main_form.tpl',
        ),
    ),

    'settings' => array(
        array(
            'group' => 'sKussinChatGptSettings',
            'name' => 'sKussinChatGptApiKey',
            'type' => 'str',
            'value' => '',
        ),
        array(
            'group' => 'sKussinChatGptSettings',
            'name' => 'sKussinChatGptApiModel',
            'type' => 'str',
            'value' => 'gpt-3.5-turbo-instruct',
        ),
        array(
            'group' => 'sKussinChatGptSettings',
            'name' => 'dKussinChatGptApiTemperature',
            'type' => 'str',
            'value' => 0.7,
        ),
        array(
            'group' => 'sKussinChatGptSettings',
            'name' => 'iKussinPositionApiMaxTokens',
            'type' => 'str',
            'value' => 350,
        ),
        array(
            'group' => 'sKussinChatGptDebugSettings',
            'name' => 'blKussinChatGptDebugEnabled',
            'type' => 'bool',
            'value' => 0,
        ),
        array(
            'group' => 'sKussinChatGptDebugSettings',
            'name' => 'sKussinChatGptDebugLogFilename',
            'type' => 'str',
            'value' => 'log/KUSSIN_CHATGPT.log',
        ),
    )
);