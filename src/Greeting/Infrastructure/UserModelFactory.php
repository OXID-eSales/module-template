<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Greeting\Infrastructure;

use OxidEsales\Eshop\Application\Model\User;

class UserModelFactory implements UserModelFactoryInterface
{
    public function create(): User
    {
        return oxNew(User::class);
    }
}
