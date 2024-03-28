<?php
/**
 * Metadata version
 */
$sMetadataVersion = '2.0';

use Kussin\ChatGpt\Core\ModuleEvents;
use OxidEsales\Eshop\Application\Controller\Admin\ArticleMain;
use OxidEsales\Eshop\Application\Controller\Admin\CategoryMain;
use OxidEsales\Eshop\Application\Controller\Admin\CategoryText;
use OxidEsales\Eshop\Application\Controller\Admin\ManufacturerMain;
use OxidEsales\Eshop\Application\Controller\Admin\VendorMain;

// FILE PATH
$sModulePath = dirname(__FILE__);

/**
 * Module information
 */
$aModule = array(
    'id'           => 'kussin/chatgpt-content-creator',
    'title'        => 'Kussin | ChatGPT Content Creator for OXID eShop',
    'description'  => 'ChatGPT Integration for OXID eShop',
    'thumbnail'    => 'module.png',
    'version'      => '0.0.5',
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

    'events' => array(
        'onActivate' => ModuleEvents::class . '::onActivate',
    ),

    'controllers' => array(
        'article_chatgpt' => Kussin\ChatGpt\Controller\Admin\ArticleChatGPT::class,
        'chatgpt_bulk_approval' => Kussin\ChatGpt\Controller\Admin\ChatGPTBulkApproval::class,
        'process' => Kussin\ChatGpt\Cron\Process::class,
    ),

    'templates' => array(
        'chatgpt_bulk_approval.tpl' => 'kussin/chatgpt-content-creator/views/tpl/admin/chatgpt_bulk_approval.tpl',
        'article_chatgpt.tpl' => 'kussin/chatgpt-content-creator/views/tpl/admin/article_chatgpt.tpl',

        // INCLUDES
        'materialize.tpl' => 'kussin/chatgpt-content-creator/views/tpl/admin/inc/materialize.tpl',
        'chatgpt_bulk_actions.tpl' => 'kussin/chatgpt-content-creator/views/tpl/admin/inc/chatgpt_bulk_actions.tpl',
    ),

    'blocks' => array(
        array(
            'template' => 'article_main.tpl',
            'block' => 'admin_article_main_form',
            'file' => 'views/blocks/admin/admin_article_main_form.tpl',
        ),
        array(
            'template' => 'headitem.tpl',
            'block' => 'admin_headitem_inccss',
            'file' => 'views/blocks/admin/admin_headitem_inccss.tpl',
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

        array(
            'template' => 'layout/base.tpl',
            'block' => 'base_style',
            'file' => 'views/blocks/base_style.tpl',
        ),
        array(
            'template' => 'page/details/inc/tabs.tpl',
            'block' => 'details_tabs_longdescription',
            'file' => 'views/blocks/details_tabs_longdescription.tpl',
        ),
        array(
            'template' => 'page/list/list.tpl',
            'block' => 'page_list_listbody',
            'file' => 'views/blocks/page_list_listbody.tpl',
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
            'group' => 'sKussinChatGptFrontendSettings',
            'name' => 'blKussinChatGptFrontendDisclaimerEnabled',
            'type' => 'bool',
            'value' => 1,
        ),
        array(
            'group' => 'sKussinChatGptFrontendSettings',
            'name' => 'sKussinChatGptFrontendDisclaimerCmsId',
            'type' => 'str',
            'value' => 'kussin_chatgpt_disclaimer',
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
            'group' => 'sKussinChatGptPromptSettings',
            'name' => 'sKussinChatGptPromptProductSearchKeysDE',
            'type' => 'str',
            'value' => 'Erstelle eine kommaseparierte CSV-Liste von Synonymen für "%s" vom "%s" ohne Größen-, Volumen, Liter- oder Mengenangaben, ohne Marke/Hersteller oder individuelle Produktmerkmale wie Farbe und ohne Dopplungen.',
        ),
        array(
            'group' => 'sKussinChatGptPromptSettings',
            'name' => 'sKussinChatGptPromptProductSearchKeysEN',
            'type' => 'str',
            'value' => 'Create a comma-separated CSV list of synonyms for "%s" from "%s" without size, volume, liter, or quantity indications, without brand/manufacturer or individual product features such as color, and without duplicates.',
        ),
        array(
            'group' => 'sKussinChatGptPromptSettings',
            'name' => 'sKussinChatGptPromptProductAttributesDE',
            'type' => 'str',
            'value' => 'Versuche für die folgenden Attribute, für den Artikel "%s" (Hersteller-SKU: %s) von "%s", Werten zu ermitteln und erstelle ein daraus einen JSON; Werte, die "unbekannt" sind als `null` zurückgeben: ',
        ),
        array(
            'group' => 'sKussinChatGptPromptSettings',
            'name' => 'sKussinChatGptPromptProductAttributesEN',
            'type' => 'str',
            'value' => 'Try to determine values for the following attributes for the article "%s" (Manufacturer SKU: %s) from "%s" and create a JSON from it; return values that are `null` as null: ',
        ),
        array(
            'group' => 'sKussinChatGptPromptSettings',
            'name' => 'sKussinChatGptPromptOptimizeContentDE',
            'type' => 'str',
            'value' => 'Optimiere den folgenden Inhalte für unserer Website: %s',
        ),
        array(
            'group' => 'sKussinChatGptPromptSettings',
            'name' => 'sKussinChatGptPromptOptimizeContentEN',
            'type' => 'str',
            'value' => 'Optimize the following content for our website: %s',
        ),
        array(
            'group' => 'sKussinChatGptProcessSettings',
            'name' => 'blKussinChatGptProcessQueueEnabled',
            'type' => 'bool',
            'value' => 0,
        ),
        array(
            'group' => 'sKussinChatGptProcessSettings',
            'name' => 'sKussinChatGptProcessSelectionQuery',
            'type' => 'str',
            'value' => file_get_contents($sModulePath . '/sql/oxartextends.example.sql'),
        ),
        array(
            'group' => 'sKussinChatGptProcessSettings',
            'name' => 'sKussinChatGptProcessModel',
            'type' => 'str',
            'value' => 'gpt-3.5-turbo-instruct',
        ),
        array(
            'group' => 'sKussinChatGptProcessSettings',
            'name' => 'dKussinChatGptProcessTemperature',
            'type' => 'str',
            'value' => 0.7,
        ),
        array(
            'group' => 'sKussinChatGptProcessSettings',
            'name' => 'iKussinChatGptProcessMaxTokens',
            'type' => 'str',
            'value' => 350,
        ),
        array(
            'group' => 'sKussinChatGptProcessSettings',
            'name' => 'iKussinChatGptProcessLimitMaxPrompts',
            'type' => 'str',
            'value' => 10,
        ),
        array(
            'group' => 'sKussinChatGptProcessSettings',
            'name' => 'iKussinChatGptProcessLimitMaxGenerations',
            'type' => 'str',
            'value' => 1,
        ),
        array(
            'group' => 'sKussinChatGptProcessSettings',
            'name' => 'iKussinChatGptProcessLimitMaxReplacements',
            'type' => 'str',
            'value' => 10,
        ),
        array(
            'group' => 'sKussinChatGptProcessSettings',
            'name' => 'sKussinChatGptProcessProductAttributesForbiddenValues',
            'type' => 'str',
            'value' => 'unknown',
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