<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tracker\Repository;

use OxidEsales\ModuleTemplate\Greeting\Model\GreetingTracker;

/**
 * @extendable-class
 */
interface TrackerRepositoryInterface
{
    public function getTrackerByUserId(string $userId): GreetingTracker;
}
