<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tests\Logging\Service;

use OxidEsales\ModuleTemplate\Logging\Service\BasketProductLoggerService;
use OxidEsales\ModuleTemplate\Settings\Service\ModuleSettingsServiceInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface as PsrLoggerInterface;

#[CoversClass(BasketProductLoggerService::class)]
final class BasketProductLoggerServiceTest extends TestCase
{
    private const TEST_PRODUCT_ID = 'itemId';

    public function testLogWhenEnabled(): void
    {
        $psrLoggerMock = $this->createMock(PsrLoggerInterface::class);
        $psrLoggerMock->expects($this->once())
            ->method('info')
            ->with(
                sprintf(BasketProductLoggerService::MESSAGE, self::TEST_PRODUCT_ID)
            );

        $moduleSettings = $this->createMock(ModuleSettingsServiceInterface::class);
        $moduleSettings->expects($this->once())
            ->method('isLoggingEnabled')
            ->willReturn(true);

        $basketItemLogger = new BasketProductLoggerService($psrLoggerMock, $moduleSettings);
        $basketItemLogger->log(self::TEST_PRODUCT_ID);
    }

    public function testLogWhenDisabled()
    {
        $psrLoggerMock = $this->createMock(PsrLoggerInterface::class);
        $psrLoggerMock->expects($this->never())
            ->method('info');

        $moduleSettings = $this->createMock(ModuleSettingsServiceInterface::class);
        $moduleSettings->expects($this->once())
            ->method('isLoggingEnabled')
            ->willReturn(false);

        $basketItemLogger = new BasketProductLoggerService($psrLoggerMock, $moduleSettings);
        $basketItemLogger->log(self::TEST_PRODUCT_ID);
    }
}
