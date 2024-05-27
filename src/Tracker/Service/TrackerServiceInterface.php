<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tracker\Service;

use OxidEsales\Eshop\Application\Model\User;
use OxidEsales\ModuleTemplate\Greeting\Model\PersonalGreetingUserInterface;

interface TrackerServiceInterface
{
    public function updateTracker(User&PersonalGreetingUserInterface $user): void;
}
