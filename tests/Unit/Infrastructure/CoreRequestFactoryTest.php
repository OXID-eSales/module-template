<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tests\Unit\Infrastructure;

use OxidEsales\ModuleTemplate\Infrastructure\CoreRequestFactory;
use PHPUnit\Framework\TestCase;
use OxidEsales\Eshop\Core\Request;

/**
 * @covers \OxidEsales\ModuleTemplate\Infrastructure\CoreRequestFactory
 */
class CoreRequestFactoryTest extends TestCase
{
    public function testCreateProducesCorrectTypeOfObjects(): void
    {
        $coreRequestFactoryMock = $this->getMockBuilder(CoreRequestFactory::class)
            ->onlyMethods(['create'])
            ->getMock();

        $this->assertInstanceOf(Request::class, $coreRequestFactoryMock->create());
    }
}
