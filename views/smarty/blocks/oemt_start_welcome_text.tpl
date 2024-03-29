
<p>
    <!-- If the module is active, the template block will be extended and this line is shown -->
    [{oxmultilang ident="OEMODULETEMPLATE_GREETING"}]
    <!-- And in case we have the module setting and a logged in user, we might see some additional text-->
    [{$oView->getOemtGreeting()}]
    <!-- Allow logged in user to change his greeting text -->
    [{if $oView->canUpdateOemtGreeting()}]
        <button class="btn btn-primary submitButton largeButton">
            <!-- Use oxgetseourl smarty function to output SEO style url -->
            <a id='oemt_update_greeting' class="submitButton largeButton" href="[{oxgetseourl ident=$oViewConf->getSelfLink()|cat:"cl=oemtgreeting"}]">[{oxmultilang ident="OEMODULETEMPLATE_GREETING_UPDATE"}]</a>
        </button>
    [{/if}]
</p>

[{$smarty.block.parent}]
