[{$smarty.block.parent}]

<tr>
    <td class="edittext" valign="top">
        [{oxmultilang ident="KUSSIN_CHATGPT_CONTENT_CREATOR_LONG_DESCRIPTION"}]
    </td>
    <td class="edittext">
        <textarea name="editval[oxmanufacturers__kussinlongdesc]"  class="editinput" rows="4" cols="50" [{$readonly}]>
        [{$edit->oxmanufacturers__kussinlongdesc->value}]
        </textarea>
    </td>
</tr>
<tr>
    <td class="edittext" colspan="2"><br><br>
        <fieldset class="kussin-chatgpt-fieldset">
            <legend>[{oxmultilang ident="KUSSIN_CHATGPT_CONTENT_CREATOR_LEGEND"}]</legend>

            <input type="submit" class="edittext" id="oGenerateKussinChatGptLongDescriptionButton" name="generateKussinChatGptLongDescription" value="[{oxmultilang ident="KUSSIN_ARTICLE_MAIN_CHATGPT_LONG_DESCRIPTION"}]" onClick="Javascript:document.myedit.fnc.value='kussinchatgptlongdesc'" [{$readonly}]>
			<input type="submit" class="edittext" id="oGenerateKussinChatGptShortDescriptionButton" name="generateKussinChatGptShortDescription" value="[{oxmultilang ident="KUSSIN_ARTICLE_MAIN_CHATGPT_SHORT_DESCRIPTION"}]" onClick="Javascript:document.myedit.fnc.value='kussinchatgptshortdesc'" [{$readonly}] [{if !$edit->oxmanufacturers__oxtitle->value && !$oxparentid}]disabled[{/if}] [{$readonly}]><br>
        </fieldset>
        [{include file="loader.tpl"}]
    </td>
</tr>