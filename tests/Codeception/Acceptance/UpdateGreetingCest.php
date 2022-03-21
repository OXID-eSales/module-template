<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tests\Codeception\Helper;

use OxidEsales\Codeception\Module\Translation\Translator;
use OxidEsales\ModuleTemplate\Tests\Codeception\AcceptanceTester;
use OxidEsales\ModuleTemplate\Core\Module as ModuleCore;

/**
 * @group oe_moduletemplate
 * @group oe_moduletemplate_updategreeting
 */
final class UpdateGreetingCest
{
    public function _before(AcceptanceTester $I): void
    {
        //ensure each test start from same environment
        $I->setGreetingModePersonal();
    }

    public function _after(AcceptanceTester $I): void
    {
        //clean up after each test
        $I->setGreetingModeGeneric();
        $this->setUserPersonalGreeting($I, '');
    }

    public function testSetGreetingMode(AcceptanceTester $I): void
    {
        $I->wantToTest('user updates the personal greeting');

        $this->setUserPersonalGreeting($I, 'Hi there sweetie');

        $I->openShop()
            ->loginUser($I->getDemoUserName(), $I->getDemoUserPassword());
        $I->waitForText(Translator::translate('HOME'));
        $I->see(Translator::translate('OEMODULETEMPLATE_GREETING'));
        $I->dontSee(Translator::translate('OEMODULETEMPLATE_GREETING_GENERIC'));
        $I->see('Hi there sweetie');

        $I->seeElement('#oetm_update_greeting');
        $I->click('#oetm_update_greeting');
        $I->see(Translator::translate('OEMODULETEMPLATE_GREETING_UPDATE_TITLE'));

        $I->seeElement('#oetmgreeting_submit');
        $I->seeElement('#oetm_greeting_input');
        $I->fillField(ModuleCore::OETM_GREETING_TEMPLATE_VARNAME, 'Hello master of the filled cart');
        $I->click('#oetmgreeting_submit');

        //See changed greeting text on start page
        $I->openShop();
        $I->see('Hello master of the filled cart');
    }

    private function setUserPersonalGreeting(AcceptanceTester $I, string $value = ''): void
    {
        $I->updateInDatabase(
            'oxuser',
            [
                'oetmgreeting' => $value,
            ],
            [
                'oxusername' => $I->getDemoUserName(),
            ]
        );
    }
}
