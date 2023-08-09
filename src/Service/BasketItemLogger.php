<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Service;

use Psr\Log\LoggerInterface as PsrLoggerInterface;

/**
 * Class logs items which goes to basket.
 */
final class BasketItemLogger implements LoggerInterface
{
    public const MESSAGE = 'Adding item with id \'%s\'.';

    public function __construct(
        private PsrLoggerInterface $logger,
        private ModuleSettings $moduleSettingService,
    ) {
    }

    public function log(string $message): void
    {
        if ($this->moduleSettingService->isLoggingEnabled()) {
            $this->logger->info($message);
        }
    }
}
