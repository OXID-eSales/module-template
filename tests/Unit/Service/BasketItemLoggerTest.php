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
use Psr\Log\LoggerInterface;

final class BasketItemLoggerTest extends TestCase
{
    public function testLogItemToBasketWhenEnabled(): void
    {
        $loggerMock = $this->createMock(LoggerInterface::class);
        $loggerMock->expects($this->once())
            ->method('info');

        $moduleSettings = $this->createMock(ModuleSettings::class);
        $moduleSettings->expects($this->once())
            ->method('isLoggingEnabled')
            ->willReturn(true);

        $basketItemLogger = new BasketItemLogger($loggerMock, $moduleSettings);
        $basketItemLogger->logItemToBasket('itemId');
    }

    public function testLogItemToBasketWhenDisabled()
    {
        $loggerMock = $this->createMock(LoggerInterface::class);
        $loggerMock->expects($this->never())
            ->method('info');

        $moduleSettings = $this->createMock(ModuleSettings::class);
        $moduleSettings->expects($this->once())
            ->method('isLoggingEnabled')
            ->willReturn(false);

        $basketItemLogger = new BasketItemLogger($loggerMock, $moduleSettings);
        $basketItemLogger->logItemToBasket('itemId');
    }
}
