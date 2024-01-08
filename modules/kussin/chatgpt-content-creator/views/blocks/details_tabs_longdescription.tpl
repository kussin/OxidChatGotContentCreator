[{assign var="oConf" value=$oViewConf->getConfig()}]

[{assign var="blEnabled" value=$oConf->getConfigParam('blKussinChatGptFrontendDisclaimerEnabled')}]
[{assign var="sCmsId" value=$oConf->getConfigParam('sKussinChatGptFrontendDisclaimerCmsId')}]

[{oxhasrights ident="SHOWLONGDESCRIPTION"}]
	[{assign var="oLongdesc" value=$oDetailsProduct->getLongDescription()}]
	[{if $oLongdesc->value}]
		[{capture append="tabs"}]<a href="#description" data-toggle="tab">[{oxmultilang ident="DESCRIPTION"}]</a>[{/capture}]
		[{capture append="tabsContent"}]
			<div id="description" class="tab-pane[{if $blFirstTab}] active[{/if}]" itemprop="description">
				[{oxeval var=$oLongdesc}]
				[{if $oDetailsProduct->oxarticles__oxexturl->value}]
					<a id="productExturl" class="js-external" href="[{$oDetailsProduct->oxarticles__oxexturl->value}]">
					[{if $oDetailsProduct->oxarticles__oxurldesc->value}]
						[{$oDetailsProduct->oxarticles__oxurldesc->value}]
					[{else}]
						[{$oDetailsProduct->oxarticles__oxexturl->value}]
					[{/if}]
					</a>
				[{/if}]
				
				[{* Disclaimer for AI-generated Content *}]
				[{if $blEnabled && $sCmsId && $oDetailsProduct->oxarticles__kussinchatgptgenerated->value}]
					[{oxifcontent ident=$sCmsId object="oCont"}]
						<div class="kussin-chatgpt-disclaimer link">
							<a href="[{$oCont->getLink()}]" target="_blank">[{oxmultilang ident="KUSSIN_CHATGPT_DISCLAIMER_LINK"}]</a>
						</div>
					[{/oxifcontent}]
				[{/if}]
			</div>
		[{/capture}]
		[{assign var="blFirstTab" value=false}]
	[{/if}]
[{/oxhasrights}]