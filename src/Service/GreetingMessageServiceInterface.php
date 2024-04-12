<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Service;

use OxidEsales\Eshop\Application\Model\User as EshopModelUser;

/**
 * @extendable-class
 */
interface GreetingMessageServiceInterface
{
    public function getGreeting(?EshopModelUser $user = null): string;

    public function saveGreeting(EshopModelUser $user): bool;
}