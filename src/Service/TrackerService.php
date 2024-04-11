<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Service;

use OxidEsales\Eshop\Application\Model\User as EshopModelUser;
use OxidEsales\ModuleTemplate\Greeting\Repository as GreetingRepository;
use OxidEsales\ModuleTemplate\Model\User as ModelUser;
use OxidEsales\ModuleTemplate\Tracker\Repository as TrackerRepository;

/**
 * Example which we can decorate
 */
class TrackerService implements TrackerServiceInterface
{
    public function __construct(
        private TrackerRepository $repository,
        private GreetingRepository $greetingRepository,
    ) {
    }

    public function updateTracker(EshopModelUser $user): void
    {
        $savedGreeting = $this->greetingRepository->getSavedUserGreeting($user->getId());

        /** @var ModelUser $user */
        if ($savedGreeting !== $user->getPersonalGreeting()) {
            $tracker = $this->repository->getTrackerByUserId($user->getId());
            $tracker->countUp();
        }
    }
}
