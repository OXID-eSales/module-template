<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tests\Service;

use OxidEsales\EshopCommunity\Internal\Framework\Module\Facade\ModuleSettingServiceInterface;
use OxidEsales\ModuleTemplate\Core\Module;
use OxidEsales\ModuleTemplate\Service\BasketItemLogger;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

final class BasketItemLoggerTest extends TestCase
{
    public function testLogItemToBasketWhenEnabled(): void
    {
        $loggerMock = $this->createMock(LoggerInterface::class);
        $loggerMock->expects($this->once())
            ->method('info')
            ->with($this->equalTo('Adding item with id \'testItemId\'.'));

        $moduleSettings = $this->createMock(ModuleSettingServiceInterface::class);
        $moduleSettings->expects($this->once())
            ->method('getBoolean')
            ->with(BasketItemLogger::LOGGER_STATUS, Module::MODULE_ID)
            ->willReturn(true);

        $basketItemLogger = new BasketItemLogger($loggerMock, $moduleSettings);
        $basketItemLogger->logItemToBasket('testItemId');
    }

    public function testLogItemToBasketWhenDisabled()
    {
        $loggerMock = $this->createMock(LoggerInterface::class);
        $loggerMock->expects($this->never())
            ->method('info')
            ->with($this->equalTo('Adding item with id \'testItemId\'.'));

        $moduleSettings = $this->createMock(ModuleSettingServiceInterface::class);
        $moduleSettings->expects($this->once())
            ->method('getBoolean')
            ->with(BasketItemLogger::LOGGER_STATUS, Module::MODULE_ID)
            ->willReturn(false);

        $basketItemLogger = new BasketItemLogger($loggerMock, $moduleSettings);
        $basketItemLogger->logItemToBasket('itemId');
    }
}
