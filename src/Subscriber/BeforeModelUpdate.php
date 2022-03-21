<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

#AfterModelUpdateEvent

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Subscriber;

use OxidEsales\Eshop\Application\Model\User as EshopModelUser;
use OxidEsales\EshopCommunity\Internal\Framework\Event\AbstractShopAwareEventSubscriber;
use OxidEsales\EshopCommunity\Internal\Transition\ShopEvents\BeforeModelUpdateEvent;
use OxidEsales\ModuleTemplate\Model\User as ModelUser;
use OxidEsales\ModuleTemplate\Service\Repository;
use OxidEsales\ModuleTemplate\Traits\ServiceContainer;

final class BeforeModelUpdate extends AbstractShopAwareEventSubscriber
{
    use ServiceContainer;

    public function handle(BeforeModelUpdateEvent $event): BeforeModelUpdateEvent
    {
        $payload = $event->getModel();

        if (is_a($payload, EshopModelUser::class)) {
            $this->updateTracker($payload);
        }

        return $event;
    }

    private function updateTracker(EshopModelUser $user): void
    {
        $repository    = $this->getServiceFromContainer(Repository::class);
        $savedGreeting = $repository->getSavedUserGreeting($user->getId());

        /** @var ModelUser $user */
        if ($savedGreeting !== $user->getPersonalGreeting()) {
            $tracker = $repository->getTrackerByUserId($user->getId());
            $tracker->countUp();
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            BeforeModelUpdateEvent::class => 'handle',
        ];
    }
}
