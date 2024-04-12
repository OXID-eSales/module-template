<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Model;

use OxidEsales\ModuleTemplate\Service\BasketItemLogger;

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
        $basketItemLogger = $this->getService(BasketItemLogger::class);
        $basketItemLogger->log($productID);

        return parent::addToBasket($productID, $amount, $sel, $persParam, $shouldOverride, $isBundle, $oldBasketItemId);
    }
}
