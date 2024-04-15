<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tests\Unit\Greeting\Service;

use OxidEsales\Eshop\Core\Request as CoreRequest;
use OxidEsales\ModuleTemplate\Core\Module as ModuleCore;
use OxidEsales\ModuleTemplate\Greeting\Service\GreetingMessageService;
use OxidEsales\ModuleTemplate\Settings\Service\ModuleSettingsServiceInterface;
use PHPUnit\Framework\TestCase;

final class GreetingMessageTest extends TestCase
{
    /**
     * @dataProvider getGreetingDataProvider
     */
    public function testGenericGreetingNoUser(string $mode, string $expected): void
    {
        $moduleSettingsStub = $this->createMock(ModuleSettingsServiceInterface::class);
        $moduleSettingsStub->method('getGreetingMode')->willReturn($mode);

        $service = new GreetingMessageService(
            $moduleSettingsStub,
            $this->createStub(CoreRequest::class)
        );

        $this->assertSame($expected, $service->getGreeting());
    }

    public static function getGreetingDataProvider(): array
    {
        return [
            [
                'mode' => ModuleSettingsServiceInterface::GREETING_MODE_GENERIC,
                'expected' => ModuleCore::DEFAULT_PERSONAL_GREETING_LANGUAGE_CONST
            ],
            [
                'mode' => ModuleSettingsServiceInterface::GREETING_MODE_PERSONAL,
                'expected' => ''
            ]
        ];
    }
}
