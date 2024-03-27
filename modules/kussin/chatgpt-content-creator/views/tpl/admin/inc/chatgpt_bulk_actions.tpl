<div class="kussin-chatgpt-filtering">
    <div class="kussin-chatgpt-pagination-search">
        [{* TODO: Add fulltext search *}]

    </div>
    <div class="kussin-chatgpt-pagination-asn">
        [{* TODO: Add asn *}]

    </div>
    <div class="kussin-chatgpt-pagination-reset">
        <button type="button" onclick="Javascript:document.myedit.fnc.value='reset';Javascript:document.myedit.submit();">
            [{oxmultilang ident="KUSSIN_CHATGPT_BULK_ACTION_RESET_LABEL"}]
        </button>
    </div>
</div>

<div class="kussin-chatgpt-pagination">
    <div class="kussin-chatgpt-pagination-limits">
        <select name="page_limit" id="page_limit" title="[{oxmultilang ident="KUSSIN_CHATGPT_BULK_ACTION_PAGE_LIMIT_TITLE"}]" onchange="Javascript:document.myedit.fnc.value='page_limit';Javascript:document.myedit.submit();">
            [{foreach from=$page_limits item=aPageLimit}]
                <option value="[{$aPageLimit.value}]" [{if $aPageLimit.selected}]selected="SELECTED"[{/if}]>[{$aPageLimit.label}]</option>
            [{/foreach}]
        </select>
        <label for="page_limit">[{oxmultilang ident="KUSSIN_CHATGPT_BULK_ACTION_PAGE_LIMIT_LABEL"}]</label>
    </div>
    <div class="kussin-chatgpt-pagination-sorting">
        <select name="sorting" id="sorting" title="[{oxmultilang ident="KUSSIN_CHATGPT_BULK_ACTION_SORTING_TITLE"}]" onchange="Javascript:document.myedit.fnc.value='sorting';Javascript:document.myedit.submit();">
            [{foreach from=$sorting item=aSorting}]
                [{assign var="sLabel" value="KUSSIN_CHATGPT_BULK_ACTION_SORTING_`$aSorting.value`"}]
                <option value="[{$aSorting.value}]" [{if $aSorting.selected}]selected="SELECTED"[{/if}]>[{oxmultilang ident=$sLabel}]</option>
            [{/foreach}]
        </select>
        <label for="sorting">[{oxmultilang ident="KUSSIN_CHATGPT_BULK_ACTION_SORTING_LABEL"}]</label>
    </div>
    <div class="kussin-chatgpt-pagination-pager">
        <ul>
            <li class="kussin-chatgpt-pagination-pager-previous">
                <a href="Javascript:document.myedit.fnc.value='previous_page';Javascript:document.myedit.submit();" title="[{oxmultilang ident="KUSSIN_CHATGPT_BULK_ACTION_PREVIOUS_PAGE_TITLE"}]">
                    [{oxmultilang ident="KUSSIN_CHATGPT_BULK_ACTION_PREVIOUS_PAGE_LABEL"}]
                </a>
            </li>
            <li class="kussin-chatgpt-pagination-pager-goto">
                <input type="number" name="goto" id="goto" min="0" max="[{$pages}]" value="[{$page}]" title="[{oxmultilang ident="KUSSIN_CHATGPT_BULK_ACTION_GOTO_PAGE_TITLE"}]" onblur="Javascript:document.myedit.fnc.value='go_to_page';Javascript:document.myedit.submit();"> [{oxmultilang ident="KUSSIN_CHATGPT_BULK_ACTION_PAGE_OF_PAGES_LABEL"}] [{$pages}]
            </li>
            <li class="kussin-chatgpt-pagination-pager-next">
                <a href="Javascript:document.myedit.fnc.value='next_page';Javascript:document.myedit.submit();" title="[{oxmultilang ident="KUSSIN_CHATGPT_BULK_ACTION_NEXT_PAGE_TITLE"}]">
                    [{oxmultilang ident="KUSSIN_CHATGPT_BULK_ACTION_NEXT_PAGE_LABEL"}]
                </a>
            </li>
        </ul>
    </div>
</div>