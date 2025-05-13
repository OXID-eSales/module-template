<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tests\Unit;

use OxidEsales\ModuleTemplate\Example;
use PHPUnit\Framework\TestCase;

final class ExampleTest extends TestCase
{
    public function testUnitExample(): void
    {
        $example = new Example();
        $this->assertTrue($example->test());
    }
}
