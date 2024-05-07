<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tests\Unit\Greeting\Service;

use OxidEsales\Eshop\Core\Language as CoreLanguage;
use OxidEsales\Eshop\Core\Request as CoreRequest;
use OxidEsales\ModuleTemplate\Core\Module as ModuleCore;
use OxidEsales\ModuleTemplate\Greeting\Service\GreetingMessageService;
use OxidEsales\ModuleTemplate\Settings\Service\ModuleSettingsServiceInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(GreetingMessageService::class)]
final class GreetingMessageServiceTest extends TestCase
{
    public function testGenericGreetingNoUserForGenericMode(): void
    {
        $service = new GreetingMessageService(
            moduleSettings: $moduleSettingsStub = $this->createMock(ModuleSettingsServiceInterface::class),
            shopRequest: $this->createStub(CoreRequest::class),
            shopLanguage: $langStub = $this->createStub(CoreLanguage::class),
        );

        $moduleSettingsStub->method('getGreetingMode')
            ->willReturn(ModuleSettingsServiceInterface::GREETING_MODE_GENERIC);

        $expectedTranslation = 'translatedGreeting';
        $langStub->method('translateString')
            ->with(ModuleCore::DEFAULT_PERSONAL_GREETING_LANGUAGE_CONST)
            ->willReturn($expectedTranslation);

        $this->assertSame($expectedTranslation, $service->getGreeting(null));
    }

    public function testGenericGreetingWithUserForGenericMode(): void
    {
        $service = new GreetingMessageService(
            moduleSettings: $moduleSettingsStub = $this->createMock(ModuleSettingsServiceInterface::class),
            shopRequest: $this->createStub(CoreRequest::class),
            shopLanguage: $langStub = $this->createStub(CoreLanguage::class),
        );

        $moduleSettingsStub->method('getGreetingMode')
            ->willReturn(ModuleSettingsServiceInterface::GREETING_MODE_GENERIC);

        $expectedTranslation = 'translatedGreeting';
        $langStub->method('translateString')
            ->with(ModuleCore::DEFAULT_PERSONAL_GREETING_LANGUAGE_CONST)
            ->willReturn($expectedTranslation);

        $this->assertSame($expectedTranslation, $service->getGreeting(null));
    }

    public function testGenericGreetingNoUserForPersonalMode(): void
    {
        $service = new GreetingMessageService(
            moduleSettings: $moduleSettingsStub = $this->createMock(ModuleSettingsServiceInterface::class),
            shopRequest: $this->createStub(CoreRequest::class),
            shopLanguage: $this->createStub(CoreLanguage::class),
        );

        $moduleSettingsStub->method('getGreetingMode')
            ->willReturn(ModuleSettingsServiceInterface::GREETING_MODE_PERSONAL);

        $this->assertSame('', $service->getGreeting(null));
    }
}
