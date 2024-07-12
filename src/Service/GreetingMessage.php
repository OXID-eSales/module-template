<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Service;

use OxidEsales\Eshop\Application\Model\User as EshopModelUser;
use OxidEsales\ModuleTemplate\Core\Module as ModuleCore;
use OxidEsales\ModuleTemplate\Infrastructure\CoreRequestFactoryInterface;
use OxidEsales\ModuleTemplate\Model\User as TemplateModelUser;
use OxidEsales\ModuleTemplate\Service\ModuleSettings as ModuleSettingsService;

/**
 * @extendable-class
 */
class GreetingMessage
{
    /**
     * @var ModuleSettingsService
     */
    private $settings;

    /**
     * @var CoreRequestFactoryInterface
     */
    private $coreRequestFactory;

    public function __construct(
        ModuleSettingsService $settings,
        CoreRequestFactoryInterface $coreRequestFactory
    ) {
        $this->settings = $settings;
        $this->coreRequestFactory = $coreRequestFactory;
    }

    public function getGreeting(?EshopModelUser $user = null): string
    {
        $result = ModuleCore::DEFAULT_PERSONAL_GREETING_LANGUAGE_CONST;

        if (ModuleSettingsService::GREETING_MODE_PERSONAL == $this->settings->getGreetingMode()) {
            $result = $this->getUserGreeting($user);
        }

        return $result;
    }

    public function saveGreeting(EshopModelUser $user): bool
    {
        /** @var TemplateModelUser $user */
        $user->setPersonalGreeting($this->getRequestOemtGreeting());

        return (bool)$user->save();
    }

    private function getRequestOemtGreeting(): string
    {
        $coreRequestService = $this->coreRequestFactory->create();
        $input = (string)$coreRequestService->getRequestParameter(ModuleCore::OEMT_GREETING_TEMPLATE_VARNAME);

        //in real life add some input validation
        return (string)substr($input, 0, 253);
    }

    private function getUserGreeting(?EshopModelUser $user = null): string
    {
        $result = '';

        if (is_object($user)) {
            /** @var TemplateModelUser $user */
            $result = $user->getPersonalGreeting();
        }

        return $result;
    }
}
