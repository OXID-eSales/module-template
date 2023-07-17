<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tests\Unit\Model;;

use Monolog\Logger;
use OxidEsales\ModuleTemplate\Model\BasketItemLogger;
use PHPUnit\Framework\TestCase;

class BasketItemLoggerTest extends TestCase
{
    private $logsPath;
    private $loggerMock;

    protected function setUp(): void
    {
        $this->logsPath = '/path/to/logs';
        $this->loggerMock = $this->getMockBuilder(Logger::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testLogItemToBasket()
    {
        $itemId = '123';
        $expectedMessage = sprintf(BasketItemLogger::MESSAGE, $itemId);

        $this->loggerMock->expects($this->once())
            ->method('addInfo')
            ->with($expectedMessage);

        $logger = new BasketItemLogger($this->logsPath);
        $logger->setLogger($this->loggerMock);
        $logger->logItemToBasket($itemId);
    }
}