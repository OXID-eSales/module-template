<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tests\Integration\Greeting\Service;

use OxidEsales\Eshop\Application\Model\User as EshopModelUser;
use OxidEsales\Eshop\Core\Request as CoreRequest;
use OxidEsales\ModuleTemplate\Core\Module as ModuleCore;
use OxidEsales\ModuleTemplate\Greeting\Service\GreetingMessageService;
use OxidEsales\ModuleTemplate\Settings\Service\ModuleSettingsServiceInterface;
use OxidEsales\ModuleTemplate\Tests\Integration\IntegrationTestCase;

final class GreetingMessageServiceTest extends IntegrationTestCase
{
    public function testModuleGenericGreetingModeEmptyUser(): void
    {
        $service = new GreetingMessageService(
            $this->getSettingsMock(ModuleSettingsServiceInterface::GREETING_MODE_GENERIC),
            oxNew(CoreRequest::class)
        );
        $user = oxNew(EshopModelUser::class);

        $this->assertSame(ModuleCore::DEFAULT_PERSONAL_GREETING_LANGUAGE_CONST, $service->getGreeting($user));
    }

    public function testModulePersonalGreetingModeEmptyUser(): void
    {
        $service = new GreetingMessageService(
            $this->getSettingsMock(),
            oxNew(CoreRequest::class)
        );
        $user = oxNew(EshopModelUser::class);

        $this->assertSame('', $service->getGreeting($user));
    }

    public function testModuleGenericGreeting(): void
    {
        $service = new GreetingMessageService(
            $this->getSettingsMock(ModuleSettingsServiceInterface::GREETING_MODE_GENERIC),
            oxNew(CoreRequest::class)
        );
        $user = oxNew(EshopModelUser::class);
        $user->setPersonalGreeting('Hi sweetie!');

        $this->assertSame(ModuleCore::DEFAULT_PERSONAL_GREETING_LANGUAGE_CONST, $service->getGreeting($user));
    }

    public function testModulePersonalGreeting(): void
    {
        $service = new GreetingMessageService(
            $this->getSettingsMock(),
            oxNew(CoreRequest::class)
        );
        $user = oxNew(EshopModelUser::class);
        $user->setPersonalGreeting('Hi sweetie!');

        $this->assertSame('Hi sweetie!', $service->getGreeting($user));
    }

    private function getSettingsMock(
        string $mode = ModuleSettingsServiceInterface::GREETING_MODE_PERSONAL
    ): ModuleSettingsServiceInterface {
        $moduleSettingsStub = $this->createMock(ModuleSettingsServiceInterface::class);
        $moduleSettingsStub->method('getGreetingMode')->willReturn($mode);

        return $moduleSettingsStub;
    }
}
