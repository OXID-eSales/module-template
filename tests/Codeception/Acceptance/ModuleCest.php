<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tests\Codeception\Acceptance;

use OxidEsales\Codeception\Module\Translation\Translator;
use OxidEsales\ModuleTemplate\Core\Module;
use OxidEsales\ModuleTemplate\Tests\Codeception\Support\AcceptanceTester;

/**
 * @group oe_moduletemplate
 * @group oe_moduletemplate_module
 */
final class ModuleCest
{
    public function testCanDeactivateModule(AcceptanceTester $I): void
    {
        $I->wantToTest('that deactivating the module does not destroy the shop');

        $I->openShop();
        $I->waitForText(Translator::translate('OEMODULETEMPLATE_GREETING'));

        $I->deactivateModule(Module::MODULE_ID);
        $I->reloadPage();

        $I->waitForPageLoad();
        $I->dontSee(Translator::translate('OEMODULETEMPLATE_GREETING'));
    }
}
