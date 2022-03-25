<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tests\Integration\Controller;

use OxidEsales\Eshop\Application\Controller\StartController as EshopStartController;
use OxidEsales\Eshop\Application\Model\User as EshopModelUser;
use OxidEsales\Eshop\Core\Registry as EshopRegistry;
use OxidEsales\ModuleTemplate\Service\ModuleSettings;
use OxidEsales\ModuleTemplate\Traits\ServiceContainer;
use OxidEsales\TestingLibrary\UnitTestCase;

/*
 * Here we have full integration test cases for a what we call 'chain extended' shop class.
 */
final class StartControllerTest extends UnitTestCase
{
    use ServiceContainer;

    public const TEST_USER_ID = '_testuser';

    public const TEST_GREETING = 'oh dear';

    /**
     * @dataProvider providerCanUpdateOetmGreeting
     */
    public function testCanUpdateOetmGreeting(bool $hasUser, string $mode, string $expect): void
    {
        $moduleSettings = $this->getServiceFromContainer(ModuleSettings::class);
        $moduleSettings->saveGreetingMode($mode);

        $controller = oxNew(EshopStartController::class);

        if ($hasUser) {
            $controller->setUser($this->getTestUser());
        }

        $this->$expect($controller->canUpdateOetmGreeting());
    }

    /**
     * @dataProvider providerGetOetmGreeting
     *
     * @param mixed $expect
     */
    public function testGetOetmGreeting(bool $hasUser, string $mode, $expect): void
    {
        $moduleSettings = $this->getServiceFromContainer(ModuleSettings::class);
        $moduleSettings->saveGreetingMode($mode);

        $controller = oxNew(EshopStartController::class);

        if ($hasUser) {
            $controller->setUser($this->getTestUser());
        }

        $this->assertSame(
            (string) EshopRegistry::getLang()->translateString($expect),
            $controller->getOetmGreeting()
        );
    }

    public function providerCanUpdateOetmGreeting(): array
    {
        return [
            'without_user_generic' => [
                'user'          => false,
                'greeting_mode' => ModuleSettings::GREETING_MODE_GENERIC,
                'assert'        => 'assertFalse',
            ],
            'without_user_personal' => [
                'user'          => false,
                'greeting_mode' => ModuleSettings::GREETING_MODE_PERSONAL,
                'assert'        => 'assertFalse',
            ],
            'with_user_generic' => [
                'user'          => true,
                'greeting_mode' => ModuleSettings::GREETING_MODE_GENERIC,
                'assert'        => 'assertFalse',
            ],
            'with_user_personal' => [
                'user'          => true,
                'greeting_mode' => ModuleSettings::GREETING_MODE_PERSONAL,
                'assert'        => 'assertTrue',
            ],
        ];
    }

    public function providerGetOetmGreeting(): array
    {
        return [
            'without_user_generic' => [
                'user'                   => false,
                'greeting_mode'          => ModuleSettings::GREETING_MODE_GENERIC,
                'expect'                 => 'OEMODULETEMPLATE_GREETING_GENERIC',
            ],
            'without_user_personal' => [
                'user'                   => false,
                'greeting_mode'          => ModuleSettings::GREETING_MODE_PERSONAL,
                'expect'                 => '',
            ],
            'with_user_generic' => [
                'user'                   => true,
                'greeting_mode'          => ModuleSettings::GREETING_MODE_GENERIC,
                'expect'                 => 'OEMODULETEMPLATE_GREETING_GENERIC',
            ],
            'with_user_personal' => [
                'user'                   => true,
                'greeting_mode'          => ModuleSettings::GREETING_MODE_PERSONAL,
                'expect'                 => self::TEST_GREETING,
            ],
        ];
    }

    private function getTestUser(): EshopModelUser
    {
        $user = oxNew(EshopModelUser::class);
        $user->assign(
            [
                'oxid'         => self::TEST_USER_ID,
                'oetmgreeting' => self::TEST_GREETING,
            ]
        );
        $user->save();

        return $user;
    }
}
