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
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function logItemToBasket(string $itemId): void
    {
        $this->logger->info(
            sprintf(static::MESSAGE, $itemId)
        );
    }
}
