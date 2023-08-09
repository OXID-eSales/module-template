<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tests\Service;

use OxidEsales\ModuleTemplate\Service\BasketItemLogger;
use OxidEsales\ModuleTemplate\Service\ModuleSettings;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface as PsrLoggerInterface;

final class BasketItemLoggerTest extends TestCase
{
    public function testLogWhenEnabled(): void
    {
        $psrLoggerMock = $this->createMock(PsrLoggerInterface::class);
        $psrLoggerMock->expects($this->once())
            ->method('info');

        $moduleSettings = $this->createMock(ModuleSettings::class);
        $moduleSettings->expects($this->once())
            ->method('isLoggingEnabled')
            ->willReturn(true);

        $basketItemLogger = new BasketItemLogger($psrLoggerMock, $moduleSettings);
        $basketItemLogger->log('itemId');
    }

    public function testLogWhenDisabled()
    {
        $psrLoggerMock = $this->createMock(PsrLoggerInterface::class);
        $psrLoggerMock->expects($this->never())
            ->method('info');

        $moduleSettings = $this->createMock(ModuleSettings::class);
        $moduleSettings->expects($this->once())
            ->method('isLoggingEnabled')
            ->willReturn(false);

        $basketItemLogger = new BasketItemLogger($psrLoggerMock, $moduleSettings);
        $basketItemLogger->log('itemId');
    }
}
