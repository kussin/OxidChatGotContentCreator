<?php
$sLangName = 'English';

$aLang = array(
    'charset' => 'utf-8',

    'KUSSIN_CHATGPT_CONTENT_CREATOR_LEGEND' => 'KUSSIN | ChatGPT Content Creator',
    'KUSSIN_ARTICLE_MAIN_CHATGPT_LONG_DESCRIPTION' => 'Create new Long Description',
    'KUSSIN_ARTICLE_MAIN_CHATGPT_SHORT_DESCRIPTION' => 'Create new Short Description',

    'KUSSIN_CHATGPT_LONG_DESCRIPTION_PROMPT' => 'Create an article long description for "%s" from "%s". - And please without an intro and with max. %s words.',
    'KUSSIN_CHATGPT_SHORT_DESCRIPTION_PROMPT' => 'Create an article short description for "%s" from "%s". - And please without an intro and with max. %s words.',
    'KUSSIN_CHATGPT_PRODUCT_SEARCHKEYS_PROMPT' => 'Create a comma-separated CSV list of synonyms for "%s" from "%s" without size, volume, liter, or quantity indications, without brand/manufacturer or individual product features such as color, and without duplicates.',
    'KUSSIN_CHATGPT_PRODUCT_ATTRIBUTES_PROMPT' => 'Try to determine values for the following attributes for the article "%s" (Manufacturer SKU: %s) from "%s" and create a JSON from it; return values that are `null` as null: %s',
    'KUSSIN_CHATGPT_CATGEORY_LONG_DESCRIPTION_PROMPT' => 'Create an category long description for "%s" of "%s". - And please without an intro and with max. %s words.',
    'KUSSIN_CHATGPT_CATGEORY_SHORT_DESCRIPTION_PROMPT' => 'Create an category short description for "%s" of "%s". - And please without an intro and with max. 255 characters.',
    'KUSSIN_CHATGPT_MANUFACTURER_SHORT_DESCRIPTION_PROMPT' => 'Create an manufacturer short description for "%s" of "%s". - And please without an intro and with max. 255 characters.',
    'KUSSIN_CHATGPT_VENDOR_SHORT_DESCRIPTION_PROMPT' => 'Create an vendor short description for "%s" of "%s". - And please without an intro and with max. 255 characters.',

    'KUSSIN_CHATGPT_LONG_DESCRIPTION_INSTRUCTION_PROMPT' => implode(PHP_EOL, array(
        'Structure as follows:',
        '1. Main advantage in a short sentence as concise and concrete as possible in `<p>` formatting.',
        '2. List items with features and the benefit that the feature brings.',
        '3. One paragraph per feature consisting of a `<h2>` heading (advantage of the feature + metaphor)',
        'and a short text that underpins the feature with everyday storytelling.',
        'Important: No `<h1>` heading.',
        '4. Do not use any HTML entities like `&uuml;` or `&auml;` and also no single or double quotes.',
    )),
    'KUSSIN_CHATGPT_LONG_DESCRIPTION_CONTINUE_PROMPT' => 'Continue from your previous response.',

    'KUSSIN_CHATGPT_DISCLAIMER_LINK' => 'KI-generated content',
);
