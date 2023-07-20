<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Model;

use OxidEsales\Eshop\Application\Model\BasketItem;
use OxidEsales\ModuleTemplate\Service\BasketItemLoggerInterface;
use OxidEsales\ModuleTemplate\Traits\ServiceContainer;

/**
 * @see \OxidEsales\Eshop\Application\Model\Basket
 */
class Basket extends Basket_parent
{

    use ServiceContainer;

    /**
     * Method overrides eShop method and adds logging functionality.
     *
     * @param string $productID
     * @param int $amount
     * @param null|array $sel
     * @param null|array $persParam
     * @param bool|false $shouldOverride
     * @param bool|false $isBundle
     * @param null|string $oldBasketItemId
     *
     * @return BasketItem|null
     * @see \OxidEsales\Eshop\Application\Model\Basket::addToBasket()
     *
     */
    public function addToBasket(
        $productID,
        $amount,
        $sel = null,
        $persParam = null,
        $shouldOverride = false,
        $isBundle = false,
        $oldBasketItemId = null
    )
    {

        $basketItemLogger = $this->getServiceFromContainer(BasketItemLoggerInterface::class);
        $basketItemLogger->logItemToBasket($productID);

        return parent::addToBasket($productID, $amount, $sel, $persParam, $shouldOverride, $isBundle, $oldBasketItemId);
    }
}