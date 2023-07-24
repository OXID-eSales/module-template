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
class BasketItemLogger implements BasketItemLoggerInterface
{

    const MESSAGE = 'Adding item with id \'%s\'.';
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function logItemToBasket($itemId)
    {
        $this->logger->info(
            sprintf(static::MESSAGE, $itemId)
        );
    }

}