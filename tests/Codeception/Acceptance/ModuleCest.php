<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tests\Codeception\Helper;

use OxidEsales\Codeception\Module\Translation\Translator;
use OxidEsales\ModuleTemplate\Tests\Codeception\AcceptanceTester;

/**
 * @group oe_moduletemplate
 * @group oe_moduletemplate_module
 */
final class ModuleCest
{
    public function _after(AcceptanceTester $I): void
    {
        $I->setModuleActive();
    }

    public function testCanDeactivateModule(AcceptanceTester $I): void
    {
        $I->wantToTest('that deactivating the module does not destroy the shop');

        $I->openShop();
        $I->waitForText(Translator::translate('HOME'));
        $I->see(Translator::translate('OEMODULETEMPLATE_GREETING'));

        $I->setModuleActive(false);
        $I->reloadPage();

        $I->waitForText(Translator::translate('HOME'));
        $I->dontSee(Translator::translate('OEMODULETEMPLATE_GREETING'));
    }
}
