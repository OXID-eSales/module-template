<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tests\Integration\Model;

use OxidEsales\Eshop\Application\Component\BasketComponent;
use OxidEsales\Eshop\Application\Model\Article as EshopModelArticle;
use OxidEsales\ModuleTemplate\Service\BasketItemLogger;
use OxidEsales\EshopCommunity\Tests\Integration\IntegrationTestCase;
use \org\bovigo\vfs\vfsStream;
use \org\bovigo\vfs\vfsStreamDirectory;

/**
 * Test class for checking if logger correctly integrates with shop via bridge.
 */
class LogAddToBasketTest extends IntegrationTestCase
{
    const VFS_ROOT_DIRECTORY = 'vfsRoot';

    /** @var vfsStreamDirectory */
    protected $vfsRoot;
    private const TEST_PRODUCT_ID = 'testArticleId';

    public function setUp(): void
    {
        $this->vfsRoot = vfsStream::setup(self::VFS_ROOT_DIRECTORY);
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

    /**
     * Test creates virtual directory and checks if required information was logged.
     */
    public function testLoggingWhenCustomerAddsToBasket()
    {
        $this->addProductToBasket(self::TEST_PRODUCT_ID);
        $fileContents = $this->getLogFileContent();
        $this->assertLogContentCorrect($fileContents, self::TEST_PRODUCT_ID);
    }

    /**
     * @param string $fileContents
     * @param string $productId
     */
    private function assertLogContentCorrect($fileContents, $productId)
    {
        $this->assertTrue((bool)strpos($fileContents, $productId), "Product id does not exist in log file.");
    }

    /**
     * @param string $productId
     */
    private function addProductToBasket($productId)
    {
        /** @var BasketComponent $basketComponent */
        $basketComponent = oxNew(BasketComponent::class);
        $this->setRequestParameter('aid', $productId);
        $basketComponent->tobasket();
    }


    private function getLogFileContent()
    {
        return $this->vfsRoot->getChild(BasketItemLogger::FILE_NAME)->getContent();
    }

    /**
     * @param string $paramName
     * @param string|array $paramValue
     */
    public function setRequestParameter($paramName, $paramValue)
    {
        $_POST[$paramName] = $paramValue;
    }
}