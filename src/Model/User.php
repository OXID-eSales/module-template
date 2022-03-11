<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Model;

use OxidEsales\ModuleTemplate\Traits\ServiceContainer;

/**
 * @eshopExtension
 * @mixin \OxidEsales\Eshop\Application\Model\User
 */
class User extends User_parent
{
    use ServiceContainer;

    public function getPersonalGreeting(): string
    {
        return (string) $this->getRawFieldData('oetmgreeting');
    }

    //NOTE: we only assign the value to the model.
    //Calling save() method will then store it in the databasse
    public function setPersonalGreeting(string $personalGreeting): void
    {
        $this->assign(
            [
                'oetmgreeting' => $personalGreeting,
            ]
        );
    }
}
