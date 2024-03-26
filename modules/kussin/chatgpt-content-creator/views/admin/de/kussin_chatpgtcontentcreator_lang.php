<?php
$sLangName = 'Deutsch';

$aLang = array(
    'charset' => 'utf-8',

    // ADMIN MENU
    'KUSSIN_CHATGPT_CONTENT_CREATOR' => 'KUSSIN | ChatGPT Content Creator',
    'KUSSIN_CHATGPT_BULK_APPROVAL' => 'Massen-Publikationsfreigabe',
    'KUSSIN_CHATGPT_ARTICLE_APPROVAL' => 'ChatGPT Publikationsfreigabe',

    'KUSSIN_CHATGPT_CONTENT_CREATOR_LEGEND' => 'KUSSIN | ChatGPT Content Creator',
    'KUSSIN_CHATGPT_CONTENT_CREATOR_LONG_DESCRIPTION' => 'Langbeschreibung',
    'KUSSIN_ARTICLE_MAIN_CHATGPT_LONG_DESCRIPTION' => 'Neue Langbeschreibung erstellen',
    'KUSSIN_ARTICLE_MAIN_CHATGPT_OPTIMIZE_LONG_DESCRIPTION' => 'Optimierte Langbeschreibung erstellen',
    'KUSSIN_ARTICLE_MAIN_CHATGPT_SHORT_DESCRIPTION' => 'Neue Kurzbeschreibung erstellen',

    'KUSSIN_CHATGPT_LONG_DESCRIPTION_PROMPT' => 'Erstelle eine Artikel-Langbeschreibung für "%s" von "%s". - Und bitte ohne Intro und mit max. %s Wörtern.',
    'KUSSIN_CHATGPT_SHORT_DESCRIPTION_PROMPT' => 'Erstelle eine Artikel-Kurzbeschreibung für "%s" von "%s". - Und bitte ohne Intro und mit max. %s Wörtern.',
    'KUSSIN_CHATGPT_PRODUCT_SEARCHKEYS_PROMPT' => 'Erstelle eine kommaseparierte CSV-Liste von Synonymen für "%s" vom "%s" ohne Größen-, Volumen, Liter- oder Mengenangaben, ohne Marke/Hersteller oder individuelle Produktmerkmale wie Farbe und ohne Dopplungen.',
    'KUSSIN_CHATGPT_PRODUCT_ATTRIBUTES_PROMPT' => 'Versuche für die folgenden Attribute, für den Artikel "%s" (Hersteller-SKU: %s) von "%s", Werten zu ermitteln und erstelle ein daraus einen JSON; Werte, die "unbekannt" sind als `null` zurückgeben: ',
    'KUSSIN_CHATGPT_CATGEORY_LONG_DESCRIPTION_PROMPT' => 'Erstelle eine Kategorie-Langbeschreibung für "%s" von "%s". - Und bitte ohne Intro und mit max. %s Wörtern.',
    'KUSSIN_CHATGPT_CATGEORY_SHORT_DESCRIPTION_PROMPT' => 'Erstelle eine Kategorie-Kurzbeschreibung für "%s" von "%s". - Und bitte ohne Intro und mit max. 255 Zeichen.',
    'KUSSIN_CHATGPT_MANUFACTURER_LONG_DESCRIPTION_PROMPT' => 'Erstelle eine Marken-Langbeschreibung für "%s" von "%s". - Und bitte ohne Intro und mit max. %s Wörtern.',
    'KUSSIN_CHATGPT_MANUFACTURER_SHORT_DESCRIPTION_PROMPT' => 'Erstelle eine Marken-Kurzbeschreibung für "%s" von "%s". - Und bitte ohne Intro und mit max. 255 Zeichen.',
    'KUSSIN_CHATGPT_VENDOR_SHORT_DESCRIPTION_PROMPT' => 'Erstelle eine Hersteller-Kurzbeschreibung für "%s" von "%s". - Und bitte ohne Intro und mit max. 255 Zeichen.',

    'KUSSIN_CHATGPT_OPTIMIZE_CONTENT_PROMPT' => 'Optimiere den folgenden Inhalte für unserer Website: %s',

    'KUSSIN_CHATGPT_LONG_DESCRIPTION_INSTRUCTION_PROMPT' => implode(PHP_EOL, array(
        'Aufbau wie folgt:',
        '1. Hauptvorteil in einem kurzen Satz möglichst prägnant und konkret in `<p>` Formatierung.',
        '2. Listenelemente mit Features und dem Vorteil, den das Feature bringt.',
        '3. Pro Feature ein Absatz bestehend aus einer `<h2>` Überschrift (Vorteil des Features + Metapher)',
        'und einem kurzen Text, der das Feature mit alltagsnahem Storytelling untermauert.',
        'Wichtig: Keine `<h1>` Überschrift.',
        '4. Verwende keine HTML Entities wie `&uuml;` oder `&auml;` und auch keine einfachen oder doppelten Anführungszeichen.',
    )),
    'KUSSIN_CHATGPT_LONG_DESCRIPTION_CONTINUE_PROMPT' => 'Setzen bitte deine vorherige Antwort fort.',

    'KUSSIN_CHATGPT_BULK_APPROVAL_TABLE_HEADER_ID' => 'ID',
    'KUSSIN_CHATGPT_BULK_APPROVAL_TABLE_HEADER_OBJECT' => 'Objekt',
    'KUSSIN_CHATGPT_BULK_APPROVAL_TABLE_HEADER_OBJECT_ID' => 'Objekt (ID)',
    'KUSSIN_CHATGPT_BULK_APPROVAL_TABLE_HEADER_FIELD' => 'Feld',
    'KUSSIN_CHATGPT_BULK_APPROVAL_TABLE_HEADER_SHOP_ID' => 'Shop (ID)',
    'KUSSIN_CHATGPT_BULK_APPROVAL_TABLE_HEADER_LANG_ID' => 'Sprache (ID)',
    'KUSSIN_CHATGPT_BULK_APPROVAL_TABLE_HEADER_MODE' => 'Modus',
    'KUSSIN_CHATGPT_BULK_APPROVAL_TABLE_HEADER_MODEL' => 'ChatGPT Modell',
    'KUSSIN_CHATGPT_BULK_APPROVAL_TABLE_HEADER_MAX_TOKENS' => 'ChatGPT Max Tokens',
    'KUSSIN_CHATGPT_BULK_APPROVAL_TABLE_HEADER_TEMPERATURE' => 'ChatGPT Temperatur',
    'KUSSIN_CHATGPT_BULK_APPROVAL_TABLE_HEADER_PROCESS_IP' => 'IP',
    'KUSSIN_CHATGPT_BULK_APPROVAL_TABLE_HEADER_STATUS' => 'Status',
    'KUSSIN_CHATGPT_BULK_APPROVAL_TABLE_HEADER_CREATED_AT' => 'Hinzugefügt',
    'KUSSIN_CHATGPT_BULK_APPROVAL_TABLE_HEADER_UPDATED_AT' => 'Aktualisiert',
);
