<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tests\Unit\Service;

use OxidEsales\Eshop\Application\Model\User as EshopModelUser;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\Request as CoreRequest;
use OxidEsales\Eshop\Core\UtilsObject;
use OxidEsales\ModuleTemplate\Core\Module as ModuleCore;
use OxidEsales\ModuleTemplate\Service\GreetingMessage;
use OxidEsales\ModuleTemplate\Service\ModuleSettings;
use PHPUnit\Framework\MockObject\MockBuilder;
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

    public function testModuleGenericGreetingModeEmptyUser(): void
    {
        $service = new GreetingMessage(
            $this->getSettingsMock(ModuleSettings::GREETING_MODE_GENERIC),
            $this->getMockBuilder(CoreRequest::class)->getMock()
        );
        $user    = $this->getMockBuilderEdition(EshopModelUser::class)->getMock();

        $this->assertSame(ModuleCore::DEFAULT_PERSONAL_GREETING_LANGUAGE_CONST, $service->getGreeting($user));
    }

    public function testModulePersonalGreetingModeEmptyUser(): void
    {
        $service = new GreetingMessage(
            $this->getSettingsMock(),
            $this->getMockBuilder(CoreRequest::class)->getMock()
        );
        $user    = $this->getMockBuilderEdition(EshopModelUser::class)->getMock();

        $this->assertSame('', $service->getGreeting($user));
    }

    public function testModuleGenericGreeting(): void
    {
        $service = new GreetingMessage(
            $this->getSettingsMock(ModuleSettings::GREETING_MODE_GENERIC),
            $this->getMockBuilder(CoreRequest::class)->getMock()
        );
        $user    = $this->getMockBuilderEdition(EshopModelUser::class)
            ->onlyMethods(['getPersonalGreeting'])
            ->getMock();
        $user->expects($this->any())
            ->method('getPersonalGreeting')
            ->willReturn('Hi sweetie!');

        $this->assertSame(ModuleCore::DEFAULT_PERSONAL_GREETING_LANGUAGE_CONST, $service->getGreeting($user));
    }

    public function testModulePersonalGreeting(): void
    {
        $service = new GreetingMessage(
            $this->getSettingsMock(),
            $this->getMockBuilder(CoreRequest::class)->getMock()
        );
        $user    = $this->getMockBuilderEdition(EshopModelUser::class)
            ->onlyMethods(['getPersonalGreeting'])
            ->getMock();
        $user->expects($this->any())
            ->method('getPersonalGreeting')
            ->willReturn('Hi sweetie!');

        $this->assertSame('Hi sweetie!', $service->getGreeting($user));
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

    /**
     * Creates a mock builder for the edition file of the class name given
     *
     * @psalm-template RealInstanceType of object
     *
     * @psalm-param class-string<RealInstanceType> $className
     *
     * @psalm-return MockBuilder<RealInstanceType>
     */
    private function getMockBuilderEdition($className): MockBuilder
    {
        $editionClassName = Registry::get(UtilsObject::class)->getClassName($className);

        return parent::getMockBuilder($editionClassName);
    }
}
