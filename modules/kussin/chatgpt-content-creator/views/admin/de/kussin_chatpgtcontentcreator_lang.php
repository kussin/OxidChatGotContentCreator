<?php
$sLangName = 'Deutsch';

$aLang = array(
    'charset' => 'utf-8',

    // ADMIN MENU
    'KUSSIN_CHATGPT_CONTENT_CREATOR' => 'KUSSIN | ChatGPT Content Creator',
    'KUSSIN_CHATGPT_BULK_APPROVAL' => 'Massen-Publikationsfreigabe',
    'KUSSIN_CHATGPT_EXPORTER' => 'Content Exporter',
    'KUSSIN_CHATGPT_ARTICLE_APPROVAL' => 'ChatGPT Publikationsfreigabe',

    'KUSSIN_CHATGPT_CONTENT_CREATOR_LEGEND' => 'KUSSIN | ChatGPT Content Creator',
    'KUSSIN_CHATGPT_CONTENT_CREATOR_LONG_DESCRIPTION' => 'Langbeschreibung',
    'KUSSIN_ARTICLE_MAIN_CHATGPT_LONG_DESCRIPTION' => 'Neue Langbeschreibung erstellen',
    'KUSSIN_ARTICLE_MAIN_CHATGPT_OPTIMIZE_LONG_DESCRIPTION' => 'Optimierte Langbeschreibung erstellen',
    'KUSSIN_ARTICLE_MAIN_CHATGPT_SHORT_DESCRIPTION' => 'Neue Kurzbeschreibung erstellen',

    'KUSSIN_CHATGPT_LOADING_TEXT' => 'Generierung des KI-Contents ...',

    'KUSSIN_CHATGPT_BULK_ACTION_SEARCH_LEGEND' => 'Suche',
    'KUSSIN_CHATGPT_BULK_ACTION_SEARCHTERM_TITLE' => 'Suchbegriff (z.B. OXID, Artikelnummer, Name)',
    'KUSSIN_CHATGPT_BULK_ACTION_SEARCH_FIELD_PLACEHOLDER' => 'Suchbegriff eingeben',
    'KUSSIN_CHATGPT_BULK_ACTION_SEARCH_BUTTON_LABEL' => 'Suchen',
    'KUSSIN_CHATGPT_BULK_ACTION_ASN_LEGEND' => 'Filter',
    'KUSSIN_CHATGPT_BULK_ACTION_ASN_MANUFACTURER_TITLE' => 'Hersteller',
    'KUSSIN_CHATGPT_BULK_ACTION_ASN_MANUFACTURER_OPTION_DEFAULT' => 'Alle Hersteller',
    'KUSSIN_CHATGPT_BULK_ACTION_ASN_MANUFACTURER_LABEL' => 'Hersteller',
    'KUSSIN_CHATGPT_BULK_ACTION_ASN_CATEGORY_TITLE' => 'Kategorie',
    'KUSSIN_CHATGPT_BULK_ACTION_ASN_CATEGORY_OPTION_DEFAULT' => 'Alle Kategorien',
    'KUSSIN_CHATGPT_BULK_ACTION_ASN_CATEGORY_OPTGROUP_LABEL' => 'Unterkategorien',
    'KUSSIN_CHATGPT_BULK_ACTION_ASN_CATEGORY_LABEL' => 'Kategorie',
    'KUSSIN_CHATGPT_BULK_ACTION_RESET_LABEL' => 'Alles zurücksetzen',
    'KUSSIN_CHATGPT_BULK_ACTION_ACTIONS_TITLE' => 'Welche Aktion soll ausgeführt werden?',
    'KUSSIN_CHATGPT_BULK_ACTION_ACTIONS_LABEL' => 'Aktion',
    'KUSSIN_CHATGPT_BULK_ACTION_ACTIONS_CHECKBOX_LABEL' => 'Datensatz auswählen',
    'KUSSIN_CHATGPT_BULK_ACTION_ACTIONS_' => 'Aktion auswählen',
    'KUSSIN_CHATGPT_BULK_ACTION_ACTIONS_status__pending' => 'Status auf "Pending" setzen',
    'KUSSIN_CHATGPT_BULK_ACTION_ACTIONS_status__processing' => 'Status auf "Processing" setzen',
    'KUSSIN_CHATGPT_BULK_ACTION_ACTIONS_status__generated' => 'Status auf "Generated" setzen',
    'KUSSIN_CHATGPT_BULK_ACTION_ACTIONS_status__approved' => 'Status auf "Approved" setzen',
    'KUSSIN_CHATGPT_BULK_ACTION_ACTIONS_status__canceled' => 'Status auf "Canceled" setzen',
    'KUSSIN_CHATGPT_BULK_ACTION_ACTIONS_status__skipped' => 'Status auf "Skipped" setzen',
    'KUSSIN_CHATGPT_BULK_ACTION_PAGE_LIMIT_TITLE' => 'Datensätze pro Seite',
    'KUSSIN_CHATGPT_BULK_ACTION_PAGE_LIMIT_LABEL' => 'pro Seite',
    'KUSSIN_CHATGPT_BULK_ACTION_SORTING_TITLE' => 'Sortierung nach',
    'KUSSIN_CHATGPT_BULK_ACTION_SORTING_LABEL' => 'Sortierung',
    'KUSSIN_CHATGPT_BULK_ACTION_SORTING_id__asc' => 'ID aufsteigend',
    'KUSSIN_CHATGPT_BULK_ACTION_SORTING_id__desc' => 'ID absteigend',
    'KUSSIN_CHATGPT_BULK_ACTION_SORTING_object__asc' => 'Objekt aufsteigend',
    'KUSSIN_CHATGPT_BULK_ACTION_SORTING_object__desc' => 'Objekt absteigend',
    'KUSSIN_CHATGPT_BULK_ACTION_SORTING_field__asc' => 'Feld aufsteigend',
    'KUSSIN_CHATGPT_BULK_ACTION_SORTING_field__desc' => 'Feld absteigend',
    'KUSSIN_CHATGPT_BULK_ACTION_SORTING_status__asc' => 'Status aufsteigend',
    'KUSSIN_CHATGPT_BULK_ACTION_SORTING_status__desc' => 'Status absteigend',
    'KUSSIN_CHATGPT_BULK_ACTION_SORTING_created_at__asc' => 'Hinzugefügt aufsteigend',
    'KUSSIN_CHATGPT_BULK_ACTION_SORTING_created_at__desc' => 'Hinzugefügt absteigend',
    'KUSSIN_CHATGPT_BULK_ACTION_SORTING_updated_at__asc' => 'Aktualisiert aufsteigend',
    'KUSSIN_CHATGPT_BULK_ACTION_SORTING_updated_at__desc' => 'Aktualisiert absteigend',
    'KUSSIN_CHATGPT_BULK_ACTION_PREVIOUS_PAGE_TITLE' => 'Zurück',
    'KUSSIN_CHATGPT_BULK_ACTION_PREVIOUS_PAGE_LABEL' => 'Zurück',
    'KUSSIN_CHATGPT_BULK_ACTION_GOTO_PAGE_TITLE' => 'Gehe zu Seite',
    'KUSSIN_CHATGPT_BULK_ACTION_PAGE_OF_PAGES_LABEL' => 'von',
    'KUSSIN_CHATGPT_BULK_ACTION_NEXT_PAGE_TITLE' => 'Weiter',
    'KUSSIN_CHATGPT_BULK_ACTION_NEXT_PAGE_LABEL' => 'Weiter',
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
    'KUSSIN_CHATGPT_BULK_APPROVAL_TABLE_PREVIEW_TITLE' => 'Artikel anzeigen',
    'KUSSIN_CHATGPT_PREVIEW' => 'Vorschau',
    'KUSSIN_CHATGPT_POPUP_REGENERATE_CONTENT' => 'Inhalt neu generieren',
    'KUSSIN_CHATGPT_POPUP_OPTIMIZE_CONTENT' => 'Inhalt optimieren',
    'KUSSIN_CHATGPT_POPUP_APPROVE_CONTENT' => 'Inhalt freigeben',
);