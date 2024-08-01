<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\ModuleTemplate\Infrastructure;

use OxidEsales\Eshop\Application\Model\User;

interface UserModelFactoryInterface
{
    /**
     * @return User
     */
    public function create(): User;
}
