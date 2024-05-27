<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Extension\Model;

use OxidEsales\ModuleTemplate\Logging\Service\BasketProductLoggerServiceInterface;

/**
 * @mixin \OxidEsales\Eshop\Application\Model\Basket
 */
class Basket extends Basket_parent
{
    /**
     * Method overrides eShop method and adds logging functionality.
     * {@inheritDoc}
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     */
    public function addToBasket(
        $productID,
        $amount,
        $sel = null,
        $persParam = null,
        $shouldOverride = false,
        $isBundle = false,
        $oldBasketItemId = null
    ) {
        $this->logProductAddToBasketAction((string)$productID);

        return parent::addToBasket($productID, $amount, $sel, $persParam, $shouldOverride, $isBundle, $oldBasketItemId);
    }

    private function logProductAddToBasketAction(string $productID): void
    {
        $basketItemLogger = $this->getService(BasketProductLoggerServiceInterface::class);
        $basketItemLogger->log($productID);
    }
}
