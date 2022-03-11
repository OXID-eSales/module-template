<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Service;

use OxidEsales\Eshop\Application\Model\User as EshopModelUser;
use OxidEsales\ModuleTemplate\Service\ModuleSettings as ModuleSettingsService;

final class GreetingMessage
{
    public const DEFAULT_PERSONAL_GREETING_LANGUAGE_CONST = 'OEMODULETEMPLATE_GREETING_GENERIC';

    /**
     * @var ModuleSettingsService
     */
    private $settings;

    public function __construct(
        ModuleSettingsService $settings
    ) {
        $this->settings = $settings;
    }

    public function getOetmGreeting(?EshopModelUser $user = null): string
    {
        $result = self::DEFAULT_PERSONAL_GREETING_LANGUAGE_CONST;

        if ((ModuleSettingsService::GREETING_MODE_PERSONAL == $this->settings->getGreetingMode())) {
            $result = $this->getUserGreeting($user);
        }

        return $result;
    }

    private function getUserGreeting(?EshopModelUser $user = null): string
    {
        $result = '';

        if (is_object($user)) {
            /** @var \OxidEsales\ModuleTemplate\Model\User $user */
            $result = $user->getPersonalGreeting();
        }

        return $result;
    }
}
