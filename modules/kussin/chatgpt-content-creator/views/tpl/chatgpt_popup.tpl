<link type="text/css" rel="stylesheet" href="[{$oViewConf->getModuleUrl('kussin','chatgpt-content-creator/out/src/css/popup.css')}]"  media="screen,projection"/>

<div class="kussin-chatgpt-wrapper" id="kussin-chatgpt-popup">
    <h2>[{oxmultilang ident="KUSSIN_CHATGPT_CONTENT_CREATOR"}] - [{oxmultilang ident="KUSSIN_CHATGPT_PREVIEW"}]: &quot;[{$title}]&quot;</h2>
    <iframe class="kussin-chatgpt-preview-iframe" id="kussin-chatgpt-preview-iframe" src="[{$oViewConf->getSelfLink()|cat:"cl=chatgpt_preview"|cat:"&cgptid="|cat:$cgptid}]" approved="[{$approved}]" allowfullscreen></iframe>
    <form name="myedit" id="myedit" action="[{ $oViewConf->getSelfLink() }]" method="post">
        [{$oViewConf->getHiddenSid()}]
        <input type="hidden" name="cl" value="chatgpt_popup">
        <input type="hidden" name="fnc" value="">
        <input type="hidden" name="cgptid" value="[{$cgptid}]">
        <input type="hidden" name="editlanguage" value="[{$editlanguage}]">

        <fieldset>
            <legend>[{oxmultilang ident="KUSSIN_CHATGPT_CONTENT_CREATOR_LEGEND"}]</legend>

            <input type="submit" class="edittext" id="oRegenerateKussinChatGptButton" name="regenerateKussinChatGptButton" value="[{oxmultilang ident="KUSSIN_CHATGPT_POPUP_REGENERATE_CONTENT"}]" onClick="Javascript:document.myedit.fnc.value='regenerate'" [{if $btn_disabled}]disabled="disabled"[{/if}]>
            <input type="submit" class="edittext" id="oOptimizeKussinChatGptButton" name="optimizeKussinChatGptButton" value="[{oxmultilang ident="KUSSIN_CHATGPT_POPUP_OPTIMIZE_CONTENT"}]" onClick="Javascript:document.myedit.fnc.value='optimize'" [{if $btn_disabled}]disabled="disabled"[{/if}]>
            <input type="submit" class="edittext" id="oApproveKussinChatGptButton" name="approveKussinChatGptButton" value="[{oxmultilang ident="KUSSIN_CHATGPT_POPUP_APPROVE_CONTENT"}]" onClick="Javascript:document.myedit.fnc.value='approve'" [{if $btn_disabled}]disabled="disabled"[{/if}]>
        </fieldset>
    </form>
</div>