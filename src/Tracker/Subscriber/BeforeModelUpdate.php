<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

#AfterModelUpdateEvent

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tracker\Subscriber;

use OxidEsales\Eshop\Application\Model\User as EshopModelUser;
use OxidEsales\EshopCommunity\Internal\Transition\ShopEvents\BeforeModelUpdateEvent;
use OxidEsales\ModuleTemplate\Greeting\Model\PersonalGreetingUserInterface;
use OxidEsales\ModuleTemplate\Tracker\Service\TrackerServiceInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * @extendable-class
 */
readonly class BeforeModelUpdate implements EventSubscriberInterface
{
    public function __construct(
        private TrackerServiceInterface $trackerService
    ) {
    }

    public function handle(BeforeModelUpdateEvent $event): BeforeModelUpdateEvent
    {
        $payload = $event->getModel();

        if (is_a($payload, PersonalGreetingUserInterface::class)) {
            /** @var EshopModelUser&PersonalGreetingUserInterface $payload */
            $this->trackerService->updateTracker($payload);
        }

        return $event;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            BeforeModelUpdateEvent::class => 'handle',
        ];
    }
}
