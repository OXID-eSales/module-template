<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tests\Integration;

use OxidEsales\Eshop\Core\Registry;
use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;
use PHPUnit\Framework\TestCase;

class IntegrationTestCase extends TestCase
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
        $queryBuilder->delete('oemt_tracker');
        $queryBuilder->execute();
    }

    protected function get(string $serviceId)
    {
        return ContainerFactory::getInstance()->getContainer()->get($serviceId);
    }
}
