<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>

[{*oxstyle include=$oViewConf->getModuleUrl('kussin','chatgpt-content-creator/out/src/css/loader.css')*}]
<link type="text/css" rel="stylesheet" href="[{$oViewConf->getModuleUrl('kussin','chatgpt-content-creator/out/src/css/loader.css')}]"  media="screen,projection"/>

[{*oxscript include=$oViewConf->getModuleUrl('kussin','chatgpt-content-creator/out/src/js/loader.js')*}]
<script type="text/javascript" src="[{$oViewConf->getModuleUrl('kussin','chatgpt-content-creator/out/src/js/loader.js')}]"></script>

<div id="kussin-chatgpt-loader" class="kussin-chatgpt-loader-wrapper" style="display: none;">
    <div class="kussin-chatgpt-loader-content">
        <div class="kussin-chatgpt-loader-spinner" style="background-image: url([{$oViewConf->getModuleUrl('kussin','chatgpt-content-creator/out/src/img/loader.png')}]);"></div>
        <div class="kussin-chatgpt-loader-text">[{oxmultilang ident="KUSSIN_CHATGPT_LOADING_TEXT"}]</div>
    </div>
</div>