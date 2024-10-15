<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Greeting\Service;

use OxidEsales\Eshop\Application\Model\User as EshopModelUser;
use OxidEsales\ModuleTemplate\Greeting\Infrastructure\UserModelFactoryInterface;

/**
 * @extendable-class
 */
readonly class UserService implements UserServiceInterface
{
    public function __construct(
        private UserModelFactoryInterface $userModelFactory,
    ) {
    }

    public function getUserById(string $userId): EshopModelUser
    {
        $userModel = $this->userModelFactory->create();
        $userModel->load($userId);

        return $userModel;
    }
}
