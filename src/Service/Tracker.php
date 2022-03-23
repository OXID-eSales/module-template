<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Service;

use OxidEsales\Eshop\Application\Model\User as EshopModelUser;
use OxidEsales\ModuleTemplate\Model\GreetingTracker;
use OxidEsales\ModuleTemplate\Model\User as ModelUser;
use OxidEsales\ModuleTemplate\Service\Repository as RepositoryService;

/**
 * @extendable-class
 */
class Tracker
{
    /** @var RepositoryService */
    private $repository;

    public function __construct(RepositoryService $repository)
    {
        $this->repository = $repository;
    }

    public function updateTracker(EshopModelUser $user): void
    {
        $savedGreeting = $this->repository->getSavedUserGreeting($user->getId());

        /** @var ModelUser $user */
        if ($savedGreeting !== $user->getPersonalGreeting()) {
            /** @var GreetingTracker $tracker */
            $tracker = $this->repository->getTrackerByUserId($user->getId());
            $tracker->countUp();
        }
    }
}
