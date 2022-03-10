<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tests\Integration\Service;

use OxidEsales\Eshop\Application\Model\User as EshopModelUser;
use OxidEsales\ModuleTemplate\Service\GreetingMessage;
use OxidEsales\ModuleTemplate\Service\ModuleSettings;
use OxidEsales\TestingLibrary\UnitTestCase;

final class GreetingMessageTest extends UnitTestCase
{
    public function testGenericGreetingNoUser(): void
    {
        $service = new GreetingMessage($this->getSettingsMock(ModuleSettings::GREETING_MODE_GENERIC));

        $this->assertSame(GreetingMessage::DEFAULT_PERSONAL_GREETING_LANGUAGE_CONST, $service->getOetmGreeting());
    }

    public function testPersonalGreetingNoUser(): void
    {
        $service = new GreetingMessage($this->getSettingsMock());

        $this->assertSame('', $service->getOetmGreeting());
    }

    public function testModuleGenricGreetingModeEmptyUser(): void
    {
        $service = new GreetingMessage($this->getSettingsMock(ModuleSettings::GREETING_MODE_GENERIC));
        $user    = oxNew(EshopModelUser::class);

        $this->assertSame(GreetingMessage::DEFAULT_PERSONAL_GREETING_LANGUAGE_CONST, $service->getOetmGreeting($user));
    }

    public function testModulePersonalGreetingModeEmptyUser(): void
    {
        $service = new GreetingMessage($this->getSettingsMock());
        $user    = oxNew(EshopModelUser::class);

        $this->assertSame('', $service->getOetmGreeting($user));
    }

    public function testModuleGenericGreeting(): void
    {
        $service = new GreetingMessage($this->getSettingsMock(ModuleSettings::GREETING_MODE_GENERIC));
        $user    = oxNew(EshopModelUser::class);
        $user->setPersonalGreeting('Hi sweetie!');

        $this->assertSame(GreetingMessage::DEFAULT_PERSONAL_GREETING_LANGUAGE_CONST, $service->getOetmGreeting($user));
    }

    public function testModulePersonalGreeting(): void
    {
        $service = new GreetingMessage($this->getSettingsMock());
        $user    = oxNew(EshopModelUser::class);
        $user->setPersonalGreeting('Hi sweetie!');

        $this->assertSame('Hi sweetie!', $service->getOetmGreeting($user));
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
