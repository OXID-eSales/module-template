<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tests\Integration\Extension\Model;

use OxidEsales\Eshop\Application\Model\Article as EshopModelArticle;
use OxidEsales\EshopCommunity\Tests\Integration\IntegrationTestCase;
use OxidEsales\ModuleTemplate\Extension\Model\Basket;
use OxidEsales\ModuleTemplate\Logging\Service\BasketProductLoggerServiceInterface;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(Basket::class)]
final class BasketTest extends IntegrationTestCase
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
        $product->assign([
            'oxprice' => 100,
            'oxstock' => 100,
            'oxparentid' => null,
            'oxvarstock' => null,
            'oxvarcount' => null,
            'oxstockflag' => null,
            'oxshopid' => null,
        ]);
        $product->save();
    }

    public function testAddToBasket(): void
    {
        $loggerSpy = $this->createMock(BasketProductLoggerServiceInterface::class);
        $loggerSpy->expects($this->once())->method('log');

        $basket = $this->createPartialMock(Basket::class, ['getService']);
        $basket->method('getService')->willReturnMap([
            [BasketProductLoggerServiceInterface::class, $loggerSpy]
        ]);

        $basket->addToBasket(self::TEST_PRODUCT_ID, 1);
    }
}
