<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tests\Unit\Setup;

use OxidEsales\EshopCommunity\Internal\Framework\Module\Setup\Event\BeforeModuleDeactivationEvent;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Setup\Event\FinalizingModuleActivationEvent;
use OxidEsales\ModuleTemplate\Setup\ModuleLifecycleSubscriber;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

final class ModuleLifecycleSubscriberTest extends TestCase
{
    private const MODULE_ID = 'oe_moduletemplate';

    public function testSubscribesToModuleActivationAndDeactivationEvents(): void
    {
        $this->assertSame(
            [
                FinalizingModuleActivationEvent::class => 'onActivate',
                BeforeModuleDeactivationEvent::class => 'onDeactivate',
            ],
            ModuleLifecycleSubscriber::getSubscribedEvents()
        );
    }

    public function testActivationIsHandledForThisModule(): void
    {
        $logger = $this->createMock(LoggerInterface::class);
        $logger->expects($this->once())->method('info');

        (new ModuleLifecycleSubscriber($logger))
            ->onActivate(new FinalizingModuleActivationEvent(1, self::MODULE_ID));
    }

    public function testActivationIsIgnoredForOtherModules(): void
    {
        $logger = $this->createMock(LoggerInterface::class);
        $logger->expects($this->never())->method('info');

        (new ModuleLifecycleSubscriber($logger))
            ->onActivate(new FinalizingModuleActivationEvent(1, 'other_module'));
    }

    public function testDeactivationIsHandledForThisModule(): void
    {
        $logger = $this->createMock(LoggerInterface::class);
        $logger->expects($this->once())->method('info');

        (new ModuleLifecycleSubscriber($logger))
            ->onDeactivate(new BeforeModuleDeactivationEvent(1, self::MODULE_ID));
    }

    public function testDeactivationIsIgnoredForOtherModules(): void
    {
        $logger = $this->createMock(LoggerInterface::class);
        $logger->expects($this->never())->method('info');

        (new ModuleLifecycleSubscriber($logger))
            ->onDeactivate(new BeforeModuleDeactivationEvent(1, 'other_module'));
    }
}
