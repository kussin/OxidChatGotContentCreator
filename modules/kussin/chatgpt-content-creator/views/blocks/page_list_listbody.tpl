[{$smarty.block.parent}]

[{if $oView->getListType() == 'manufacturer'}]

	[{if $actCategory->oxmanufacturers__kussinlongdesc->value && $oPageNavigation->actPage == 1}]

		<hr/>
		<div id="catLongDescLocator" class="categoryDescription">[{$actCategory->oxmanufacturers__kussinlongdesc->rawValue}]</div>

	[{/if}]

[{/if}]