<?php
/**
 * Metadata version
 */
$sMetadataVersion = '2.0';

use OxidEsales\Eshop\Application\Controller\Admin\ArticleMain;
use OxidEsales\Eshop\Application\Controller\Admin\CategoryMain;
use OxidEsales\Eshop\Application\Controller\Admin\CategoryText;
use OxidEsales\Eshop\Application\Controller\Admin\ManufacturerMain;
use OxidEsales\Eshop\Application\Controller\Admin\VendorMain;

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
        CategoryMain::class => Kussin\ChatGpt\Controller\Admin\CategoryMain::class,
//        CategoryText::class => Kussin\ChatGpt\Controller\Admin\CategoryText::class,
        ManufacturerMain::class => Kussin\ChatGpt\Controller\Admin\ManufacturerMain::class,
        VendorMain::class => Kussin\ChatGpt\Controller\Admin\VendorMain::class,
    ),

    'blocks' => array(
        array(
            'template' => 'article_main.tpl',
            'block' => 'admin_article_main_form',
            'file' => 'views/blocks/admin/admin_article_main_form.tpl',
        ),
        array(
            'template' => 'include/category_main_form.tpl',
            'block' => 'admin_category_main_form',
            'file' => 'views/blocks/admin/admin_category_main_form.tpl',
        ),
        array(
            'template' => 'manufacturer_main.tpl',
            'block' => 'admin_manufacturer_main_form',
            'file' => 'views/blocks/admin/admin_manufacturer_main_form.tpl',
        ),
        array(
            'template' => 'vendor_main.tpl',
            'block' => 'admin_vendor_main_form',
            'file' => 'views/blocks/admin/admin_vendor_main_form.tpl',
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
            'group' => 'sKussinChatGptPromptSettings',
            'name' => 'sKussinChatGptPromptLongDescriptionDE',
            'type' => 'str',
            'value' => 'Erstelle eine Artikel-Langbeschreibung für "%s" von "%s". - Und bitte ohne Intro und mit max. %s Wörtern.',
        ),
        array(
            'group' => 'sKussinChatGptPromptSettings',
            'name' => 'sKussinChatGptPromptLongDescriptionEN',
            'type' => 'str',
            'value' => 'Create an article long description for "%s" from "%s". - And please without an intro and with max. %s words.',
        ),
        array(
            'group' => 'sKussinChatGptPromptSettings',
            'name' => 'sKussinChatGptPromptShortDescriptionDE',
            'type' => 'str',
            'value' => 'Erstelle eine Artikel-Kurzbeschreibung für "%s" von "%s". - Und bitte ohne Intro und mit max. %s Wörtern.',
        ),
        array(
            'group' => 'sKussinChatGptPromptSettings',
            'name' => 'sKussinChatGptPromptShortDescriptionEN',
            'type' => 'str',
            'value' => 'Create an article short description for "%s" from "%s". - And please without an intro and with max. %s words.',
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