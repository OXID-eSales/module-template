<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Service;

interface BasketItemLoggerInterface
{
    /**
     * Method logs items which goes to basket.
     *
     * @param string $itemId
     */
    public function logItemToBasket(string $itemId);
}