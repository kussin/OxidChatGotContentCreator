[{$smarty.block.parent}]

<tr>
    <td class="edittext" colspan="2"><br><br>
        <fieldset>
            <legend>[{oxmultilang ident="KUSSIN_CHATGPT_CONTENT_CREATOR_LEGEND"}]</legend>

            <input type="submit" class="edittext" id="oGeneratKussinChatGptLongDescriptionButton" name="generatKussinChatGptLongDescription" value="[{oxmultilang ident="KUSSIN_ARTICLE_MAIN_CHATGPT_LONG_DESCRIPTION"}]" onClick="Javascript:document.myedit.fnc.value='kussinchatgptlongdesc'" [{if !$edit->oxarticles__oxtitle->value && !$oxparentid}]disabled[{/if}] [{$readonly}]>
            [{if $oxid!=-1 && !$readonly}]
                <input type="submit" class="edittext" id="oGeneratKussinChatGptShortDescriptionButton" name="generatKussinChatGptShortDescription" value="[{oxmultilang ident="KUSSIN_ARTICLE_MAIN_CHATGPT_SHORT_DESCRIPTION"}]" onClick="Javascript:document.myedit.fnc.value='kussinchatgptshortdesc'" [{if !$edit->oxarticles__oxtitle->value && !$oxparentid}]disabled[{/if}] [{$readonly}]>
            [{/if}]
        </fieldset>
    </td>
</tr>