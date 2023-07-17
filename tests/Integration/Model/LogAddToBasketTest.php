<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tests\Integration\Model;

use OxidEsales\Eshop\Application\Component\BasketComponent;
use OxidEsales\ModuleTemplate\Model\BasketItemLogger;
use OxidEsales\ModuleTemplate\Tests\Integration\IntegrationTestCase;

/**
 * Test class for checking if logger correctly integrates with shop via bridge.
 */
class LogAddToBasketTest extends  IntegrationTestCase
{
    /**
     * Test creates virtual directory and checks if required information was logged.
     */
    public function testLoggingWhenCustomerAddsToBasket()
    {
        $rootPath = $this->mockFileSystemForShop();

        $productId = 'testArticleId';

        $this->addProductToBasket($productId);

        $fileContents = $this->getLogFileContent($rootPath);

        $this->assertLogContentCorrect($fileContents, $productId);
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

    /**
     * @param $rootPath
     *
     * @return bool|string
     */
    private function getLogFileContent($rootPath)
    {
        $fakeBasketLogFile = $rootPath . 'log' . DIRECTORY_SEPARATOR . BasketItemLogger::FILE_NAME;
        $fileContents = file_get_contents($fakeBasketLogFile);

        return $fileContents;
    }

    /**
     * Use VfsStream to not write to file system.
     *
     * @return string path to root directory.
     */
    private function mockFileSystemForShop()
    {
        $vfsStreamWrapper = $this->getVfsStreamWrapper();
        $vfsStreamWrapper->createStructure(array('log' => array()));
        $this->getConfig()->setConfigParam('sShopDir', $vfsStreamWrapper->getRootPath());
        $rootPath = $vfsStreamWrapper->getRootPath();

        return $rootPath;
    }
}