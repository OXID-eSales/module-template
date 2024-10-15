<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Settings\Service;

use OxidEsales\EshopCommunity\Internal\Framework\Module\Facade\ModuleSettingServiceInterface;
use OxidEsales\ModuleTemplate\Core\Module;

/**
 * @extendable-class
 */
readonly class ModuleSettingsService implements ModuleSettingsServiceInterface
{
    public const GREETING_MODE_VALUES = [
        self::GREETING_MODE_GENERIC,
        self::GREETING_MODE_PERSONAL,
    ];

    public function __construct(
        private ModuleSettingServiceInterface $moduleSettingService,
    ) {
    }

    public function isPersonalGreetingMode(): bool
    {
        return self::GREETING_MODE_PERSONAL === $this->getGreetingMode();
    }

    public function getGreetingMode(): string
    {
        $value = (string)$this->moduleSettingService->getString(self::GREETING_MODE, Module::MODULE_ID);

        return (!empty($value) && in_array($value, self::GREETING_MODE_VALUES)) ? $value : self::GREETING_MODE_GENERIC;
    }

    public function saveGreetingMode(string $value): void
    {
        $this->moduleSettingService->saveString(self::GREETING_MODE, $value, Module::MODULE_ID);
    }

    public function isLoggingEnabled(): bool
    {
        return $this->moduleSettingService->getBoolean(self::LOGGER_STATUS, Module::MODULE_ID);
    }
}
