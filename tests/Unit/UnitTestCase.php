<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tests\Unit;

use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\UtilsObject;
use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;
use PHPUnit\Framework\MockObject\MockBuilder;
use PHPUnit\Framework\TestCase;

class UnitTestCase extends TestCase
{
    /**
     * @var object|QueryBuilderFactoryInterface|null
     */
    private $queryBuilderFactory;

    public function setUp(): void
    {
        $this->queryBuilderFactory = $this->get(QueryBuilderFactoryInterface::class);
        $this->cleanUpUsers();
        $this->cleanUpTrackers();

        parent::setUp();
    }

    public function tearDown(): void
    {
        Registry::getSession()->setUser(null);

        parent::tearDown();
    }

    private function cleanUpUsers()
    {
        $queryBuilder = $this->queryBuilderFactory->create();
        $queryBuilder->delete('oxuser');
        $queryBuilder->execute();
    }

    private function cleanUpTrackers()
    {
        $queryBuilder = $this->queryBuilderFactory->create();
        $queryBuilder->delete('oetm_tracker');
        $queryBuilder->execute();
    }

    protected function get(string $serviceId)
    {
        return ContainerFactory::getInstance()->getContainer()->get($serviceId);
    }

    /**
     * Creates a mock builder for the edition file of the class name given
     *
     * @param $className
     *
     * @return MockBuilder
     */
    public function getMockBuilder($className): MockBuilder
    {
        $editionClassName = Registry::get(UtilsObject::class)->getClassName($className);

        return parent::getMockBuilder($editionClassName);
    }
}
