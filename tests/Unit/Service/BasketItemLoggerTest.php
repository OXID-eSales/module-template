<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tests\Service;

use OxidEsales\ModuleTemplate\Service\BasketItemLogger;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

final class BasketItemLoggerTest extends TestCase
{
    public function testLogItemToBasket(): void
    {
        $loggerMock = $this->createMock(LoggerInterface::class);
        $loggerMock->expects($this->once())
            ->method('info')
            ->with($this->equalTo('Adding item with id \'testItemId\'.'));

        $basketItemLogger = new BasketItemLogger($loggerMock);
        $basketItemLogger->logItemToBasket('testItemId');
    }
}
