[{include file="headitem.tpl" title="GENERAL_ADMIN_TITLE"|oxmultilangassign}]
<link rel="stylesheet" href="[{$oViewConf->getModuleUrl('kussin','chatgpt-content-creator/out/src/css/admin.css')}]">

<div class="kussin-chatgpt-wrapper" id="kussin-article-chatgpt-tab">
    <h2>[{oxmultilang ident="KUSSIN_CHATGPT_CONTENT_CREATOR"}] - [{oxmultilang ident="KUSSIN_CHATGPT_BULK_APPROVAL"}]</h2>

    <form name="myedit" id="myedit" action="[{ $oViewConf->getSelfLink() }]" method="post">
        [{$oViewConf->getHiddenSid()}]
        <input type="hidden" name="cl" value="chatgpt_bulk_approval">
        <input type="hidden" name="fnc" value="">
        <input type="hidden" name="editlanguage" value="[{$editlanguage}]">

        <div class="kussin-chatgpt-bulk-actions">
            [{include file="chatgpt_bulk_actions.tpl"}]
        </div>

        <table border="0" cellpadding="2" cellspacing="4" class="kussin-chatgpt-grid">
            <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th>[{oxmultilang ident="KUSSIN_CHATGPT_BULK_APPROVAL_TABLE_HEADER_ID"}]</th>
                    <th>[{oxmultilang ident="KUSSIN_CHATGPT_BULK_APPROVAL_TABLE_HEADER_OBJECT"}]</th>
                    <th>[{oxmultilang ident="KUSSIN_CHATGPT_BULK_APPROVAL_TABLE_HEADER_OBJECT_ID"}]</th>
                    <th>[{oxmultilang ident="KUSSIN_CHATGPT_BULK_APPROVAL_TABLE_HEADER_FIELD"}]</th>
                    <th>[{oxmultilang ident="KUSSIN_CHATGPT_BULK_APPROVAL_TABLE_HEADER_SHOP_ID"}]</th>
                    <th>[{oxmultilang ident="KUSSIN_CHATGPT_BULK_APPROVAL_TABLE_HEADER_LANG_ID"}]</th>
                    <th>[{oxmultilang ident="KUSSIN_CHATGPT_BULK_APPROVAL_TABLE_HEADER_MODE"}]</th>
                    <th>[{oxmultilang ident="KUSSIN_CHATGPT_BULK_APPROVAL_TABLE_HEADER_MODEL"}]</th>
                    <th>[{oxmultilang ident="KUSSIN_CHATGPT_BULK_APPROVAL_TABLE_HEADER_MAX_TOKENS"}]</th>
                    <th>[{oxmultilang ident="KUSSIN_CHATGPT_BULK_APPROVAL_TABLE_HEADER_TEMPERATURE"}]</th>
                    <th>[{oxmultilang ident="KUSSIN_CHATGPT_BULK_APPROVAL_TABLE_HEADER_PROCESS_IP"}]</th>
                    <th>[{oxmultilang ident="KUSSIN_CHATGPT_BULK_APPROVAL_TABLE_HEADER_STATUS"}]</th>
                    <th>[{oxmultilang ident="KUSSIN_CHATGPT_BULK_APPROVAL_TABLE_HEADER_CREATED_AT"}]</th>
                    <th>[{oxmultilang ident="KUSSIN_CHATGPT_BULK_APPROVAL_TABLE_HEADER_UPDATED_AT"}]</th>
                </tr>
            </thead>
            <tbody>
                [{foreach from=$grid item=aRow}]
                    <tr>
                        <td><input class="edittext" type="checkbox" name="editval[[{$aRow.id}]]" value="1"></td>
                        <td>[{$aRow.id}]</td>
                        <td>[{$aRow.object}]</td>
                        <td>[{$aRow.name}]</td>
                        <td>[{$aRow.field}]</td>
                        <td>[{$aRow.shop_id}]</td>
                        <td>[{$aRow.lang_id}]</td>
                        <td>[{$aRow.mode}]</td>
                        <td>[{$aRow.model}]</td>
                        <td>[{$aRow.max_tokens}]</td>
                        <td>[{$aRow.temperature}]</td>
                        <td>[{$aRow.process_ip}]</td>
                        <td>[{$aRow.status}]</td>
                        <td>[{$aRow.created_at}]</td>
                        <td>[{$aRow.updated_at}]</td>
                    </tr>
                [{/foreach}]
            </tbody>
        </table>

    </form>
</div>