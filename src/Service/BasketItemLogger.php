<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Service;

use Psr\Log\LoggerInterface;

/**
 * Class logs items which goes to basket.
 */
final class BasketItemLogger implements BasketItemLoggerInterface
{
    private const MESSAGE = 'Adding item with id \'%s\'.';

    public function __construct(
        private LoggerInterface $logger,
        private ModuleSettings $moduleSettingService,
    ) {
    }

    public function logItemToBasket(string $itemId): void
    {
        if ($this->moduleSettingService->isLoggingEnabled()) {
            $this->logger->info(
                sprintf(self::MESSAGE, $itemId)
            );
        }
    }
}
