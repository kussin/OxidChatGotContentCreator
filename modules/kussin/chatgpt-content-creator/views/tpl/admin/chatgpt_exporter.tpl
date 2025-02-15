[{include file="headitem.tpl" title="GENERAL_ADMIN_TITLE"|oxmultilangassign}]
[{include file="materialize.tpl"}]
<link type="text/css" rel="stylesheet" href="[{$oViewConf->getModuleUrl('kussin','chatgpt-content-creator/out/src/css/admin.css')}]"  media="screen,projection"/>

<div class="kussin-chatgpt-wrapper materialize-overrides" id="kussin-article-chatgpt-bulk-approval">
    <h2>[{oxmultilang ident="KUSSIN_CHATGPT_CONTENT_CREATOR"}] - [{oxmultilang ident="KUSSIN_CHATGPT_EXPORTER"}]</h2>

    <form name="myedit" id="myedit" action="[{ $oViewConf->getSelfLink() }]" method="post">
        [{$oViewConf->getHiddenSid()}]
        <input type="hidden" name="cl" value="chatgpt_exporter">
        <input type="hidden" name="fnc" value="">
        <input type="hidden" name="editlanguage" value="[{$editlanguage}]">

        <div class="kussin-chatgpt-bulk-actions">
            [{*include file="chatgpt_exporter_actions.tpl"*}]
        </div>

        <table border="0" cellpadding="2" cellspacing="4" class="kussin-chatgpt-grid">
            <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th>[{oxmultilang ident="KUSSIN_CHATGPT_EXPORTER_TABLE_HEADER_ID"}]</th>
                    <th>[{oxmultilang ident="KUSSIN_CHATGPT_EXPORTER_TABLE_HEADER_TITLE"}]</th>
                    <th>[{oxmultilang ident="KUSSIN_CHATGPT_EXPORTER_TABLE_HEADER_FILE"}]</th>
                    <th>[{oxmultilang ident="KUSSIN_CHATGPT_EXPORTER_TABLE_HEADER_PROCESS_IP"}]</th>
                    <th>[{oxmultilang ident="KUSSIN_CHATGPT_EXPORTER_TABLE_HEADER_STATUS"}]</th>
                    <th>[{oxmultilang ident="KUSSIN_CHATGPT_EXPORTER_TABLE_HEADER_CREATED_AT"}]</th>
                    <th>[{oxmultilang ident="KUSSIN_CHATGPT_EXPORTER_TABLE_HEADER_UPDATED_AT"}]</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                [{foreach from=$grid item=aRow}]
                    <tr>
                        <td>
                            <label for="editval[[{$aRow.id}]]">
                                <input class="edittext" type="checkbox" name="editval[[{$aRow.id}]]" id="editval[[{$aRow.id}]]" value="1">
                                <span>[{oxmultilang ident="KUSSIN_CHATGPT_BULK_ACTION_ACTIONS_CHECKBOX_LABEL"}]</span>
                            </label>
                        </td>
                        <td>[{$aRow.id}]</td>
                        <td>[{$aRow.title}]</td>
                        <td>[{$aRow.file}]</td>
                        <td>[{$aRow.process_ip}]</td>
                        <td>[{$aRow.status}]</td>
                        <td>[{$aRow.created_at}]</td>
                        <td>[{$aRow.updated_at}]</td>
                        <td>
                            [{if $aRow.has_preview}]
                                <a href="[{$aRow.link}]" target="_blank" title="[{oxmultilang ident="KUSSIN_CHATGPT_EXPORTER_TABLE_PREVIEW_TITLE"}]">
                                    <i class="material-icons">search</i>
                                </a>
                            [{/if}]
                        </td>
                    </tr>
                [{/foreach}]
            </tbody>
        </table>

    </form>
</div>