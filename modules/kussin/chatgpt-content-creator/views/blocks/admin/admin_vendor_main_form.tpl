[{$smarty.block.parent}]

<tr>
    <td class="edittext" colspan="2"><br><br>
        <fieldset>
            <legend>[{oxmultilang ident="KUSSIN_CHATGPT_CONTENT_CREATOR_LEGEND"}]</legend>

			<input type="submit" class="edittext" id="oGeneratKussinChatGptShortDescriptionButton" name="generatKussinChatGptShortDescription" value="[{oxmultilang ident="KUSSIN_ARTICLE_MAIN_CHATGPT_SHORT_DESCRIPTION"}]" onClick="Javascript:document.myedit.fnc.value='kussinchatgptshortdesc'" [{$readonly}] [{if !$edit->oxvendor__oxtitle->value && !$oxparentid}]disabled[{/if}] [{$readonly}]><br>
        </fieldset>
    </td>
</tr>