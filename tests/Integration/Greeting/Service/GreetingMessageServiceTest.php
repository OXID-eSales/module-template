<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tests\Integration\Greeting\Service;

use OxidEsales\Eshop\Core\Language as CoreLanguage;
use OxidEsales\Eshop\Core\Request as CoreRequest;
use OxidEsales\ModuleTemplate\Extension\Model\User;
use OxidEsales\ModuleTemplate\Greeting\Service\GreetingMessageService;
use OxidEsales\ModuleTemplate\Settings\Service\ModuleSettingsServiceInterface;
use OxidEsales\ModuleTemplate\Tests\Integration\IntegrationTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(GreetingMessageService::class)]
final class GreetingMessageServiceTest extends IntegrationTestCase
{
    public function testGenericGreetingWithUserForPersonalMode(): void
    {
        $service = new GreetingMessageService(
            moduleSettings: $moduleSettingsStub = $this->createMock(ModuleSettingsServiceInterface::class),
            shopRequest: $this->createStub(CoreRequest::class),
            shopLanguage: $langStub = $this->createStub(CoreLanguage::class),
        );

        $moduleSettingsStub->method('getGreetingMode')
            ->willReturn(ModuleSettingsServiceInterface::GREETING_MODE_PERSONAL);

        $personalGreeting = 'someUserPersonalGreeting';
        /** @var User $userStub */
        $userStub = $this->createStub(User::class);
        $userStub->method('getPersonalGreeting')->willReturn($personalGreeting);

        $expectedTranslation = 'translatedGreeting';
        $langStub->method('translateString')
            ->with($personalGreeting)
            ->willReturn($expectedTranslation);

        $this->assertSame($expectedTranslation, $service->getGreeting($userStub));
    }

    private function getSut(
        ModuleSettingsServiceInterface $moduleSettings = null,
        CoreRequest $shopRequest = null,
    ): GreetingMessageService {
        return new GreetingMessageService(
            moduleSettings: $moduleSettings ?? $this->createStub(ModuleSettingsServiceInterface::class),
            shopRequest: $shopRequest ?? $this->createStub(CoreRequest::class),
            shopLanguage: $shopLanguage ?? $this->createStub(CoreLanguage::class),
        );
    }
}
