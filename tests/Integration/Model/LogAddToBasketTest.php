<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tests\Integration\Model;

use OxidEsales\Eshop\Application\Component\BasketComponent;
use OxidEsales\Eshop\Application\Model\Article as EshopModelArticle;
use OxidEsales\Eshop\Core\Registry;
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
    private $vfsRoot;
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
        $this->mockFileSystemForShop();
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
        $loggerString = sprintf(BasketItemLogger::MESSAGE, $productId);
        $this->assertStringContainsString($loggerString, $fileContents);
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

    /**
     * @return bool|string
     */
    private function getLogFileContent()
    {
        $fakeBasketLogFile = 'log' . DIRECTORY_SEPARATOR . BasketItemLogger::FILE_NAME;
        $fileContents = $this->vfsRoot->getChild($fakeBasketLogFile)->getContent();

        return $fileContents;
    }

    /**
     * @param string $paramName
     * @param string|array $paramValue
     */
    public function setRequestParameter($paramName, $paramValue)
    {
        $_POST[$paramName] = $paramValue;
    }

    /**
     * Use VfsStream to not write to file system.
     *
     * @return string path to root directory.
     */
    public function mockFileSystemForShop()
    {
        $rootPath = vfsStream::url(self::VFS_ROOT_DIRECTORY) . DIRECTORY_SEPARATOR;
        Registry::getConfig()->setConfigParam('sShopDir', $rootPath);
        $directory = $rootPath . 'log';
        if (file_exists($directory) === false) {
            mkdir($directory, 0700, true);
        }
        return $rootPath;
    }
}