<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tests\Unit\Infrastructure;

use OxidEsales\Eshop\Application\Model\User;
use OxidEsales\ModuleTemplate\Infrastructure\UserModelFactory;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OxidEsales\ModuleTemplate\Infrastructure\UserModelFactory
 */
class UserModelFactoryTest extends TestCase
{
    public function testCreateProducesCorrectTypeOfObjects(): void
    {
        $coreRequestFactoryMock = $this->getMockBuilder(UserModelFactory::class)
            ->onlyMethods(['create'])
            ->getMock();

        $this->assertInstanceOf(User::class, $coreRequestFactoryMock->create());
    }
}
