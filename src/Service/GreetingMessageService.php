<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Service;

use OxidEsales\Eshop\Application\Model\User as EshopModelUser;
use OxidEsales\Eshop\Core\Request as EshopRequest;
use OxidEsales\ModuleTemplate\Core\Module as ModuleCore;
use OxidEsales\ModuleTemplate\Model\User as TemplateModelUser;

class GreetingMessageService implements GreetingMessageServiceInterface
{
    public function __construct(
        private ModuleSettingsServiceInterface $moduleSettings,
        private EshopRequest $shopRequest
    ) {
    }

    public function getGreeting(?EshopModelUser $user = null): string
    {
        $result = ModuleCore::DEFAULT_PERSONAL_GREETING_LANGUAGE_CONST;

        if (ModuleSettingsServiceInterface::GREETING_MODE_PERSONAL == $this->moduleSettings->getGreetingMode()) {
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
        $input = (string)$this->shopRequest->getRequestParameter(ModuleCore::OEMT_GREETING_TEMPLATE_VARNAME);

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
