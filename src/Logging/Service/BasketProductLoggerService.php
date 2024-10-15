<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Logging\Service;

use OxidEsales\ModuleTemplate\Settings\Service\ModuleSettingsServiceInterface;
use Psr\Log\LoggerInterface as PsrLoggerInterface;

/**
 * Class logs items which goes to basket.
 */
readonly class BasketProductLoggerService implements BasketProductLoggerServiceInterface
{
    public const MESSAGE = 'Adding item with id \'%s\'.';

    public function __construct(
        private PsrLoggerInterface $logger,
        private ModuleSettingsServiceInterface $moduleSettingService,
    ) {
    }

    public function log(string $productID): void
    {
        if ($this->moduleSettingService->isLoggingEnabled()) {
            $message = sprintf(self::MESSAGE, $productID);
            $this->logger->info($message);
        }
    }
}
