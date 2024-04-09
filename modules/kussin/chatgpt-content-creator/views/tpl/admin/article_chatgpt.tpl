[{include file="headitem.tpl" title="GENERAL_ADMIN_TITLE"|oxmultilangassign}]
<link type="text/css" rel="stylesheet" href="[{$oViewConf->getModuleUrl('kussin','chatgpt-content-creator/out/src/css/admin.css')}]"  media="screen,projection"/>


[{if $readonly}]
    [{assign var="readonly" value="readonly disabled"}]
[{else}]
    [{assign var="readonly" value=""}]
[{/if}]

<script type="text/javascript">
<!--
window.onload = function ()
{
    [{if $updatelist == 1}]
    top.oxid.admin.updateList('[{$oxid}]');
    [{/if}]
    top.reloadEditFrame();
}
function editThis( sID )
{
    var oTransfer = top.basefrm.edit.document.getElementById( "transfer" );
    oTransfer.oxid.value = sID;
    oTransfer.cl.value = top.basefrm.list.sDefClass;

    //forcing edit frame to reload after submit
    top.forceReloadingEditFrame();

    var oSearch = top.basefrm.list.document.getElementById( "search" );
    oSearch.oxid.value = sID;
    oSearch.actedit.value = 0;
    oSearch.submit();
}
//-->
</script>

<form name="transfer" id="transfer" action="[{$oViewConf->getSelfLink()}]" method="post">
    [{$oViewConf->getHiddenSid()}]
    <input type="hidden" name="oxid" value="[{$oxid}]">
    <input type="hidden" name="cl" value="article_chatgpt">
    <input type="hidden" name="editlanguage" value="[{$editlanguage}]">
</form>

<form name="myedit" id="myedit" action="[{$oViewConf->getSelfLink()}]" enctype="multipart/form-data" method="post">
    [{$oViewConf->getHiddenSid()}]
    <input type="hidden" name="cl" value="article_chatgpt">
    <input type="hidden" name="fnc" value="">
    <input type="hidden" name="oxid" value="[{$oxid}]">
    <input type="hidden" name="voxid" value="[{$oxid}]">
    <input type="hidden" name="oxparentid" value="[{$oxparentid}]">
    <input type="hidden" name="editval[article__oxid]" value="[{$oxid}]">
    <input type="hidden" name="cgptid" value="[{$cgptid}]">

    <div class="kussin-chatgpt-wrapper materialize-overrides" id="kussin-article-chatgpt-tab">
        <h2>[{oxmultilang ident="KUSSIN_CHATGPT_CONTENT_CREATOR"}] - [{oxmultilang ident="KUSSIN_CHATGPT_ARTICLE_APPROVAL"}]</h2>
        <iframe class="kussin-chatgpt-preview-iframe" id="kussin-chatgpt-preview-iframe" src="[{$oViewConf->getSelfLink()|cat:"cl=chatgpt_preview"|cat:"&cgptid="|cat:$cgptid}]" approved="[{$approved}]" allowfullscreen></iframe>
        <fieldset>
            <legend>[{oxmultilang ident="KUSSIN_CHATGPT_CONTENT_CREATOR_LEGEND"}]</legend>

            <input type="submit" class="edittext" id="oRegenerateKussinChatGptButton" name="regenerateKussinChatGptButton" value="[{oxmultilang ident="KUSSIN_CHATGPT_POPUP_REGENERATE_CONTENT"}]" onClick="Javascript:document.myedit.fnc.value='regenerate'" [{if $btn_disabled}]disabled="disabled"[{/if}]>
            <input type="submit" class="edittext" id="oOptimizeKussinChatGptButton" name="optimizeKussinChatGptButton" value="[{oxmultilang ident="KUSSIN_CHATGPT_POPUP_OPTIMIZE_CONTENT"}]" onClick="Javascript:document.myedit.fnc.value='optimize'" [{if $btn_disabled}]disabled="disabled"[{/if}]>
            <input type="submit" class="edittext" id="oApproveKussinChatGptButton" name="approveKussinChatGptButton" value="[{oxmultilang ident="KUSSIN_CHATGPT_POPUP_APPROVE_CONTENT"}]" onClick="Javascript:document.myedit.fnc.value='approve'" [{if $btn_disabled}]disabled="disabled"[{/if}]>
        </fieldset>
    </div>
</form>

[{* include file="bottomnaviitem.tpl" *}]
[{include file="bottomitem.tpl"}]

