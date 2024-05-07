<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Greeting\Repository;

interface GreetingRepositoryInterface
{
    public function getSavedUserGreeting(string $userId): string;
}
