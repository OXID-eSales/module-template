[{include file="headitem.tpl" title="GENERAL_ADMIN_TITLE"|oxmultilangassign box="list"}]

<form name="transfer" id="transfer" action="[{$oViewConf->getSelfLink()}]" method="post">
    [{$oViewConf->getHiddenSid()}]
    <input type="hidden" name="oxid" value="[{$oxid}]">
    <input type="hidden" name="cl" value="oemt_admin_greeting">
</form>

<h1 class="page-header">[{oxmultilang ident="OEMODULETEMPLATE_GREETING_TITLE"}]</h1>

[{if $greeting_message}]
    <div>[{oxmultilang ident="OEMODULETEMPLATE_GREETING_MESSAGE_TEXT"}] [{$greeting_message}]</div>
[{else}]
    <div>[{oxmultilang ident="OEMODULETEMPLATE_NO_GREETING_TEXT"}]</div>
[{/if}]

[{include file="bottomnaviitem.tpl"}]
[{include file="bottomitem.tpl"}]
