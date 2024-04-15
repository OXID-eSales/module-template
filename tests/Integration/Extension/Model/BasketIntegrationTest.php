<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tests\Integration\Extension\Model;

use OxidEsales\Eshop\Application\Model\Article as EshopModelArticle;
use OxidEsales\ModuleTemplate\Logging\Service\BasketItemLogger;
use OxidEsales\ModuleTemplate\Tests\Integration\IntegrationTestCase;

final class BasketIntegrationTest extends IntegrationTestCase
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

    public function testAddToBasket(): void
    {
        $loggerSpy = $this->createMock(BasketItemLogger::class);
        $loggerSpy->expects($this->once())->method('log');

        $basket = $this->createPartialMock(\OxidEsales\ModuleTemplate\Extension\Model\Basket::class, ['getService']);
        $basket->method('getService')->willReturnMap([
            [BasketItemLogger::class, $loggerSpy]
        ]);

        $basket->addToBasket(self::TEST_PRODUCT_ID, 1, null, null, false, false, null);
    }
}
