<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tests\Settings\Service;

use OxidEsales\EshopCommunity\Internal\Framework\Module\Facade\ModuleSettingService;
use OxidEsales\ModuleTemplate\Core\Module;
use OxidEsales\ModuleTemplate\Settings\Service\ModuleSettingsService;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\String\UnicodeString;

#[CoversClass(ModuleSettingsService::class)]
final class ModuleSettingsTest extends TestCase
{
    /**
     * @dataProvider getGreetingModeDataProvider
     */
    public function testGetGreetingMode(string $value, string $expected): void
    {
        $mssMock = $this->createPartialMock(ModuleSettingService::class, ['getString']);
        $mssMock->method('getString')->willReturnMap([
            [ModuleSettingsService::GREETING_MODE, Module::MODULE_ID, new UnicodeString($value)]
        ]);

        $sut = new ModuleSettingsService($mssMock);
        $this->assertSame($expected, $sut->getGreetingMode());
    }

    public static function getGreetingModeDataProvider(): array
    {
        return [
            [
                'value' => '',
                'expected' => ModuleSettingsService::GREETING_MODE_GENERIC
            ],
            [
                'value' => 'someUnpredictable',
                'expected' => ModuleSettingsService::GREETING_MODE_GENERIC
            ],
            [
                'value' => ModuleSettingsService::GREETING_MODE_GENERIC,
                'expected' => \OxidEsales\ModuleTemplate\Settings\Service\ModuleSettingsService::GREETING_MODE_GENERIC
            ],
            [
                'value' => ModuleSettingsService::GREETING_MODE_PERSONAL,
                'expected' => ModuleSettingsService::GREETING_MODE_PERSONAL
            ],
        ];
    }

    /**
     * @dataProvider isPersonalGreetingModeDataProvider
     */
    public function testIsPersonalGreetingMode(string $value, bool $expected): void
    {
        $mssMock = $this->createPartialMock(ModuleSettingService::class, ['getString']);
        $mssMock->method('getString')->willReturnMap([
            [ModuleSettingsService::GREETING_MODE, Module::MODULE_ID, new UnicodeString($value)]
        ]);

        $sut = new ModuleSettingsService($mssMock);
        $this->assertSame($expected, $sut->isPersonalGreetingMode());
    }

    public static function isPersonalGreetingModeDataProvider(): array
    {
        return [
            [
                'value' => \OxidEsales\ModuleTemplate\Settings\Service\ModuleSettingsService::GREETING_MODE_GENERIC,
                'expected' => false
            ],
            [
                'value' => ModuleSettingsService::GREETING_MODE_PERSONAL,
                'expected' => true
            ],
        ];
    }

    public function testSaveGreetingMode(): void
    {
        $value = 'someValue';

        $mssMock = $this->createPartialMock(ModuleSettingService::class, ['saveString']);
        $mssMock->expects($this->atLeastOnce())->method('saveString')->with(
            ModuleSettingsService::GREETING_MODE,
            $value,
            Module::MODULE_ID
        );

        $sut = new ModuleSettingsService($mssMock);
        $sut->saveGreetingMode($value);
    }

    public function testIsLoggingEnabledReturnsTrue(): void
    {
        $mssMock = $this->createPartialMock(ModuleSettingService::class, ['getBoolean']);
        $mssMock->method('getBoolean')->willReturnMap([
            [\OxidEsales\ModuleTemplate\Settings\Service\ModuleSettingsService::LOGGER_STATUS, Module::MODULE_ID, true]
        ]);

        $sut = new ModuleSettingsService($mssMock);
        $result = $sut->isLoggingEnabled();

        $this->assertTrue($result);
    }

    public function testIsLoggingEnabledReturnsFalse(): void
    {
        $mssMock = $this->createPartialMock(ModuleSettingService::class, ['getBoolean']);
        $mssMock->method('getBoolean')->willReturnMap([
            [ModuleSettingsService::LOGGER_STATUS, Module::MODULE_ID, false]
        ]);

        $sut = new ModuleSettingsService($mssMock);
        $result = $sut->isLoggingEnabled();

        $this->assertFalse($result);
    }
}
