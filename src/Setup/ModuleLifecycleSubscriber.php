<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Setup;

use OxidEsales\EshopCommunity\Internal\Framework\Module\Setup\Event\FinalizingModuleActivationEvent;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Setup\Event\FinalizingModuleDeactivationEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class ModuleLifecycleSubscriber implements EventSubscriberInterface
{
    private const MODULE_ID = 'oe_moduletemplate';

    public function __construct(private readonly LoggerInterface $logger)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            FinalizingModuleActivationEvent::class => 'onActivate',
            FinalizingModuleDeactivationEvent::class => 'onDeactivate',
        ];
    }

    public function onActivate(FinalizingModuleActivationEvent $event): void
    {
        if ($event->getModuleId() !== self::MODULE_ID) {
            return;
        }

        $this->logger->info(sprintf('Module %s activated for shop %d', self::MODULE_ID, $event->getShopId()));
    }

    public function onDeactivate(FinalizingModuleDeactivationEvent $event): void
    {
        if ($event->getModuleId() !== self::MODULE_ID) {
            return;
        }

        $this->logger->info(sprintf('Module %s deactivated for shop %d', self::MODULE_ID, $event->getShopId()));
    }
}
