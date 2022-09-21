<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tests\Integration\Service;

use OxidEsales\Eshop\Application\Controller\StartController as EshopStartController;
use PHPUnit\Framework\TestCase;

/*
 * Integration test example
 */
final class ExampleTest extends TestCase
{
    public function testRender(): void
    {
        $controller = oxNew(EshopStartController::class);

        $this->assertSame('page/shop/start', $controller->render());
    }
}
