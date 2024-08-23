<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tests\Codeception\Acceptance\Admin;

use OxidEsales\Codeception\Module\Translation\Translator;
use OxidEsales\ModuleTemplate\Tests\Codeception\Support\AcceptanceTester;

/**
 * @group oe_moduletemplate
 * @group oe_moduletemplate_admin
 */
final class GreetingAdminCest
{
    public function _before(AcceptanceTester $I): void
    {
        //ensure each test start from same environment
        $I->setGreetingModeGeneric();
        $this->setUserPersonalGreeting($I, 'Hello there!');
    }

    public function _after(AcceptanceTester $I): void
    {
        //clean up after each test
        $I->setGreetingModeGeneric();
    }

    /** @param AcceptanceTester $I */
    public function seeGreetingOptionsForUser(AcceptanceTester $I): void
    {
        $I->openAdmin();
        $adminPage = $I->loginAdmin();

        $userList = $adminPage->openUsers();
        $userList->find("where[oxuser][oxusername]", $I->getDemoUserName());

        $I->selectEditFrame();
        $I->see(Translator::translate('OEMODULETEMPLATE_ALLOW_GREETING'));

        $I->selectListFrame();
        $I->click(Translator::translate('tbcluser_greetings'));

        $I->selectEditFrame();
        $I->see(Translator::translate('OEMODULETEMPLATE_GREETING_TITLE'));
        $I->see('Hello there!');
    }

    private function setUserPersonalGreeting(AcceptanceTester $I, string $value = ''): void
    {
        $I->updateInDatabase(
            'oxuser',
            [
                'oemtgreeting' => $value,
            ],
            [
                'oxusername' => $I->getDemoUserName(),
            ]
        );
    }
}
