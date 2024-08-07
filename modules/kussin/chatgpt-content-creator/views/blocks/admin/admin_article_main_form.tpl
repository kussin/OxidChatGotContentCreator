[{$smarty.block.parent}]

<tr>
    <td class="edittext" colspan="2"><br><br>
        [{* CHATGPT CONTENT CREATOR *}]
        <fieldset class="kussin-chatgpt-fieldset">
            <legend>[{oxmultilang ident="KUSSIN_CHATGPT_CONTENT_CREATOR_LEGEND"}]</legend>

            <input type="submit" class="edittext" id="oGenerateKussinChatGptLongDescriptionButton" name="generateKussinChatGptLongDescription" value="[{oxmultilang ident="KUSSIN_ARTICLE_MAIN_CHATGPT_LONG_DESCRIPTION"}]" onClick="Javascript:document.myedit.fnc.value='kussinchatgptlongdesc'" [{if !$edit->oxarticles__oxtitle->value && !$oxparentid}]disabled[{/if}] [{$readonly}]>
            [{if $oxid!=-1 && !$readonly}]
                <input type="submit" class="edittext" id="oOptimizeKussinChatGptLongDescriptionButton" name="optimizeKussinChatGptLongDescription" value="[{oxmultilang ident="KUSSIN_ARTICLE_MAIN_CHATGPT_OPTIMIZE_LONG_DESCRIPTION"}]" onClick="Javascript:document.myedit.fnc.value='kussinchatgptoptimizedesc'" [{if !$edit->oxarticles__oxtitle->value && !$oxparentid}]disabled[{/if}] [{$readonly}]>
                <input type="submit" class="edittext" id="oGenerateKussinChatGptShortDescriptionButton" name="generateKussinChatGptShortDescription" value="[{oxmultilang ident="KUSSIN_ARTICLE_MAIN_CHATGPT_SHORT_DESCRIPTION"}]" onClick="Javascript:document.myedit.fnc.value='kussinchatgptshortdesc'" [{if !$edit->oxarticles__oxtitle->value && !$oxparentid}]disabled[{/if}] [{$readonly}]>
            [{/if}]
        </fieldset><br>

        [{* CHATGPT TRANSLATOR *}]
        <fieldset class="kussin-chatgpt-fieldset">
            <legend>[{oxmultilang ident="KUSSIN_CHATGPT_TRANSLATER_LEGEND"}]</legend>

            <div style="display: none">
                <input type="hidden" name="baselocalecode" value="[{$baselocalecode}]">
                <input type="hidden" name="editlocalecode" value="[{$editlocalecode}]">
            </div>

            <input type="submit" class="edittext" id="oTranslateKussinChatGptTitleButton" name="translateKussinChatGptTitle" value="[{oxmultilang ident="KUSSIN_ARTICLE_MAIN_CHATGPT_TRANSLATE_TITLE"}]" onClick="Javascript:document.myedit.fnc.value='kussinchatgpttranslatetitle'" [{if $chatgpttranslatedisabled}]disabled[{/if}] [{$readonly}]>
            <input type="submit" class="edittext" id="oTranslateKussinChatGptLongDescriptionButton" name="translateKussinChatGptLongDescription" value="[{oxmultilang ident="KUSSIN_ARTICLE_MAIN_CHATGPT_TRANSLATE_LONG_DESCRIPTION"}]" onClick="Javascript:document.myedit.fnc.value='kussinchatgpttranslatelongdesc'"  [{if $chatgpttranslatedisabled}]disabled[{/if}] [{$readonly}]>
            <input type="submit" class="edittext" id="oTranslateKussinChatGptShortDescriptionButton" name="translateKussinChatGptShortDescription" value="[{oxmultilang ident="KUSSIN_ARTICLE_MAIN_CHATGPT_TRANSLATE_SHORT_DESCRIPTION"}]" onClick="Javascript:document.myedit.fnc.value='kussinchatgpttranslateshortdesc'" [{if $chatgpttranslatedisabled}]disabled[{/if}] [{$readonly}]>
        </fieldset>

        [{* CHATGPT LOADER *}]
        [{include file="loader.tpl"}]
    </td>
</tr>