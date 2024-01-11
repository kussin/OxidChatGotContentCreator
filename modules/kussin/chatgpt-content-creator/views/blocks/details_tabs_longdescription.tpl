[{$smarty.block.parent}]

[{assign var="oConf" value=$oViewConf->getConfig()}]

[{assign var="blEnabled" value=$oConf->getConfigParam('blKussinChatGptFrontendDisclaimerEnabled')}]
[{assign var="sCmsId" value=$oConf->getConfigParam('sKussinChatGptFrontendDisclaimerCmsId')}]

[{oxhasrights ident="SHOWLONGDESCRIPTION"}]
	[{assign var="oLongdesc" value=$oDetailsProduct->getLongDescription()}]
	[{if $oLongdesc->value}]
		<div style="display: none !important;">
			[{* Disclaimer for AI-generated Content *}]
			[{if $blEnabled && $sCmsId && $oDetailsProduct->oxarticles__kussinchatgptgenerated->value}]
				[{oxifcontent ident=$sCmsId object="oCont"}]
					<div class="kussin-chatgpt-disclaimer link">
						<a href="[{$oCont->getLink()}]" target="_blank">[{oxmultilang ident="KUSSIN_CHATGPT_DISCLAIMER_LINK"}]</a>
					</div>

					[{oxscript include=$oViewConf->getModuleUrl('kussin','chatgpt-content-creator/out/src/js/details.js')}]
				[{/oxifcontent}]
			[{/if}]
		</div>
	[{/if}]
[{/oxhasrights}]