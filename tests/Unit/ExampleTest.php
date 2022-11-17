<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tests\Unit;

use OxidEsales\Eshop\Application\Controller\StartController as EshopStartController;
use PHPUnit\Framework\TestCase;

/*
 * Unit
 */
final class ExampleTest extends TestCase
{
    public function testControllerRender(): void
    {
        $controller = $this->getMockBuilder(EshopStartController::class)
            ->getMock();
        $controller->method('render')
            ->willReturn('mock.tpl');

        $this->assertSame('mock.tpl', $controller->render());
    }
}
