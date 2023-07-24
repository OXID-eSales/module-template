<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tests\Integration\Model;

use OxidEsales\Eshop\Application\Model\BasketItem;
use OxidEsales\ModuleTemplate\Model\Basket;
use OxidEsales\Eshop\Application\Model\Article as EshopModelArticle;
use OxidEsales\ModuleTemplate\Tests\Integration\IntegrationTestCase;

class BasketIntegrationTest extends IntegrationTestCase
{
    private const TEST_PRODUCT_ID = 'testArticleId';

    public function setUp(): void
    {
        parent::setUp();
        $this->prepareTestData();
    }

    private function prepareTestData(): void
    {
        $product = oxNew(EshopModelArticle::class);
        $product->setId(self::TEST_PRODUCT_ID);
        $product->assign(
            [
                'oxprice' => 100,
                'oxstock' => 100
            ]
        );
        $product->save();
    }

    public function testAddToBasket()
    {
        $basket = new Basket();
        $basket->addToBasket(self::TEST_PRODUCT_ID, 1, null, null, false, false, null);
        $this->assertInstanceOf(BasketItem::class, $basket->addToBasket(self::TEST_PRODUCT_ID, 1, null, null, false, false, null));
    }
}
