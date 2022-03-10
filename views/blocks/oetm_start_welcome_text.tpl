
<p>
    <!-- If the module is active, the template block will be extended and this line is shown -->
    [{oxmultilang ident="OEMODULETEMPLATE_GREETING"}]
    <!-- And in case we have the module setting and a logged in user, we might see some additional text-->
    [{$oView->getOetmGreeting()}]
</p>

[{$smarty.block.parent}]
