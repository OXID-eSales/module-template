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
use OxidEsales\ModuleTemplate\Settings\Service\ModuleSettingsServiceInterface;
use OxidEsales\ModuleTemplate\Tests\Integration\IntegrationTestCase;

/*
 * Here we have full integration test cases for a what we call 'chain extended' shop class.
 * Current module might not be the only one extending the same class/method.
 * Always use the unified namespace name of the class instantiated with oxNew()
 * when testing.
 */

final class StartControllerTest extends IntegrationTestCase
{
    public const TEST_USER_ID = '_testuser';

    public const TEST_GREETING = 'oh dear';

    /**
     * @dataProvider providerCanUpdateOemtGreeting
     */
    public function testCanUpdateOemtGreeting(bool $hasUser, string $mode, string $expect): void
    {
        $moduleSettings = $this->get(ModuleSettingsServiceInterface::class);
        $moduleSettings->saveGreetingMode($mode);

        $controller = oxNew(EshopStartController::class);

        if ($hasUser) {
            $controller->setUser($this->getTestUser());
        }

        $this->$expect($controller->canUpdateOemtGreeting());
    }

    /**
     * @dataProvider providerGetOemtGreeting
     *
     * @param mixed $expect
     */
    public function testGetOemtGreeting(bool $hasUser, string $mode, $expect): void
    {
        $moduleSettings = $this->get(ModuleSettingsServiceInterface::class);
        $moduleSettings->saveGreetingMode($mode);

        $controller = oxNew(EshopStartController::class);

        if ($hasUser) {
            $controller->setUser($this->getTestUser());
        }

        $this->assertSame(
            (string)EshopRegistry::getLang()->translateString($expect),
            $controller->getOemtGreeting()
        );
    }

    public static function providerCanUpdateOemtGreeting(): array
    {
        return [
            'without_user_generic' => [
                'hasUser' => false,
                'mode' => ModuleSettingsServiceInterface::GREETING_MODE_GENERIC,
                'expect' => 'assertFalse',
            ],
            'without_user_personal' => [
                'hasUser' => false,
                'mode' => ModuleSettingsServiceInterface::GREETING_MODE_PERSONAL,
                'expect' => 'assertFalse',
            ],
            'with_user_generic' => [
                'hasUser' => true,
                'mode' => ModuleSettingsServiceInterface::GREETING_MODE_GENERIC,
                'expect' => 'assertFalse',
            ],
            'with_user_personal' => [
                'hasUser' => true,
                'mode' => ModuleSettingsServiceInterface::GREETING_MODE_PERSONAL,
                'expect' => 'assertTrue',
            ],
        ];
    }

    public static function providerGetOemtGreeting(): array
    {
        return [
            'without_user_generic' => [
                'hasUser' => false,
                'mode' => ModuleSettingsServiceInterface::GREETING_MODE_GENERIC,
                'expect' => 'OEMODULETEMPLATE_GREETING_GENERIC',
            ],
            'without_user_personal' => [
                'hasUser' => false,
                'mode' => ModuleSettingsServiceInterface::GREETING_MODE_PERSONAL,
                'expect' => '',
            ],
            'with_user_generic' => [
                'hasUser' => true,
                'mode' => ModuleSettingsServiceInterface::GREETING_MODE_GENERIC,
                'expect' => 'OEMODULETEMPLATE_GREETING_GENERIC',
            ],
            'with_user_personal' => [
                'hasUser' => true,
                'mode' => ModuleSettingsServiceInterface::GREETING_MODE_PERSONAL,
                'expect' => self::TEST_GREETING,
            ],
        ];
    }

    private function getTestUser(): EshopModelUser
    {
        $user = oxNew(EshopModelUser::class);
        $user->assign(
            [
                'oxid' => self::TEST_USER_ID,
                'oemtgreeting' => self::TEST_GREETING,
            ]
        );
        $user->save();

        return $user;
    }
}
