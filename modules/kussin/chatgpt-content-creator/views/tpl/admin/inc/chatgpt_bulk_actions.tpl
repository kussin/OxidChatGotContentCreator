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
        [{* TODO: Add pager *}]
    </div>
</div>