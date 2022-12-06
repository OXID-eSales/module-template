<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tests\Unit\Service;

use OxidEsales\Eshop\Core\Request as CoreRequest;
use OxidEsales\ModuleTemplate\Core\Module as ModuleCore;
use OxidEsales\ModuleTemplate\Service\GreetingMessage;
use OxidEsales\ModuleTemplate\Service\ModuleSettings;
use PHPUnit\Framework\TestCase;

final class GreetingMessageTest extends TestCase
{
    public function testGenericGreetingNoUser(): void
    {
        $service = new GreetingMessage(
            $this->getSettingsMock(ModuleSettings::GREETING_MODE_GENERIC),
            $this->getMockBuilder(CoreRequest::class)->getMock()
        );

        $this->assertSame(ModuleCore::DEFAULT_PERSONAL_GREETING_LANGUAGE_CONST, $service->getGreeting());
    }

    public function testPersonalGreetingNoUser(): void
    {
        $service = new GreetingMessage(
            $this->getSettingsMock(),
            $this->getMockBuilder(CoreRequest::class)->getMock()
        );

        $this->assertSame('', $service->getGreeting());
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
