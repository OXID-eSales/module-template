<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tests\Unit\Core;

use OxidEsales\ModuleTemplate\Core\ModuleEvents;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ModuleEvents::class)]
class ModuleEventsTest extends TestCase
{
    public function testEventsExecutable(): void
    {
        ModuleEvents::onActivate();
        ModuleEvents::onDeactivate();

        $this->addToAssertionCount(2);
    }
}
