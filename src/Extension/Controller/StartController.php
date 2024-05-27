<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Extension\Controller;

use OxidEsales\Eshop\Application\Model\User as EshopModelUser;
use OxidEsales\Eshop\Core\Registry as EshopRegistry;
use OxidEsales\ModuleTemplate\Greeting\Service\GreetingMessageServiceInterface;
use OxidEsales\ModuleTemplate\Settings\Service\ModuleSettingsServiceInterface;

/**
 * @eshopExtension
 *
 * This is an example for a module extension (chain extend) of
 * the shop start controller.
 * NOTE: class must not be final.
 *
 * @mixin \OxidEsales\Eshop\Application\Controller\StartController
 *
 * @todo: extract methods to domain
 */
class StartController extends StartController_parent
{
    /**
     * All we need here is to fetch the information we need from a service.
     * As in our example we extend a block of a template belonging ONLY
     * to the shop's StartController, we extend that Controller with a new method.
     * NOTE: only leaf classes can be extended this way. The FrontendController class which
     *      many Controllers inherit from cannot be extended this way.
     */
    public function getOemtGreeting(): string
    {
        $service = $this->getService(GreetingMessageServiceInterface::class);

        $user   = is_a($this->getUser(), EshopModelUser::class) ? $this->getUser() : null;
        return $service->getGreeting($user);
    }

    public function canUpdateOemtGreeting(): bool
    {
        $moduleSettings = $this->getService(ModuleSettingsServiceInterface::class);

        return is_a($this->getUser(), EshopModelUser::class) && $moduleSettings->isPersonalGreetingMode();
    }
}
