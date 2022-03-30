<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tests\Unit\Service;

use OxidEsales\Eshop\Application\Model\User as EshopModelUser;
use OxidEsales\Eshop\Core\Request as CoreRequest;
use OxidEsales\ModuleTemplate\Core\Module as ModuleCore;
use OxidEsales\ModuleTemplate\Service\GreetingMessage;
use OxidEsales\ModuleTemplate\Service\ModuleSettings;
use OxidEsales\ModuleTemplate\Service\ServiceLocator;
use OxidEsales\TestingLibrary\UnitTestCase;

final class GreetingMessageTest extends UnitTestCase
{
    public function testGenericGreetingNoUser(): void
    {
        $service = new GreetingMessage(
            $this->getServiceLocatorMock(ModuleSettings::GREETING_MODE_GENERIC)
        );

        $this->assertSame(ModuleCore::DEFAULT_PERSONAL_GREETING_LANGUAGE_CONST, $service->getOetmGreeting());
    }

    public function testPersonalGreetingNoUser(): void
    {
        $service = new GreetingMessage(
            $this->getServiceLocatorMock()
        );

        $this->assertSame('', $service->getOetmGreeting());
    }

    public function testModuleGenricGreetingModeEmptyUser(): void
    {
        $service = new GreetingMessage(
            $this->getServiceLocatorMock(ModuleSettings::GREETING_MODE_GENERIC)
        );
        $user    = oxNew(EshopModelUser::class);

        $this->assertSame(ModuleCore::DEFAULT_PERSONAL_GREETING_LANGUAGE_CONST, $service->getOetmGreeting($user));
    }

    public function testModulePersonalGreetingModeEmptyUser(): void
    {
        $service = new GreetingMessage(
            $this->getServiceLocatorMock()
        );
        $user    = oxNew(EshopModelUser::class);

        $this->assertSame('', $service->getOetmGreeting($user));
    }

    public function testModuleGenericGreeting(): void
    {
        $service = new GreetingMessage(
            $this->getServiceLocatorMock(ModuleSettings::GREETING_MODE_GENERIC)
        );
        $user    = oxNew(EshopModelUser::class);
        $user->setPersonalGreeting('Hi sweetie!');

        $this->assertSame(ModuleCore::DEFAULT_PERSONAL_GREETING_LANGUAGE_CONST, $service->getOetmGreeting($user));
    }

    public function testModulePersonalGreeting(): void
    {
        $service = new GreetingMessage(
            $this->getServiceLocatorMock()
        );
        $user    = oxNew(EshopModelUser::class);
        $user->setPersonalGreeting('Hi sweetie!');

        $this->assertSame('Hi sweetie!', $service->getOetmGreeting($user));
    }

    private function getServiceLocatorMock(string $mode = ModuleSettings::GREETING_MODE_PERSONAL): ServiceLocator
    {
        $locator = $this->getMockBuilder(ServiceLocator::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getService'])
            ->getMock();

        $locator->expects($this->any())
            ->method('getService')
            ->willReturn($this->getSettingsMock($mode));

        return $locator;
    }

    private function getSettingsMock(string $mode = ModuleSettings::GREETING_MODE_PERSONAL): ModuleSettings
    {
        $settings = $this->getMockBuilder(ModuleSettings::class)
            ->disableOriginalConstructor()
            ->getMock();
        $settings->expects($this->any())
            ->method('getGreetingMode')->willReturn($mode);

        return $settings;
    }
}
