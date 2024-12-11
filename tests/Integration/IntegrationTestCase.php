<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tests\Integration;

use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use Codeception\PHPUnit\TestCase;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;

class IntegrationTestCase extends TestCase
{
    protected function cleanUpUsers()
    {
        $queryBuilder = $this->get(QueryBuilderFactoryInterface::class)->create();
        $queryBuilder->delete('oxuser');
        $queryBuilder->execute();
    }

    protected function cleanUpTrackers()
    {
        $queryBuilder = $this->get(QueryBuilderFactoryInterface::class)->create();
        $queryBuilder->delete('oemt_tracker');
        $queryBuilder->execute();
    }

    protected function cleanUpVotes()
    {
        $queryBuilder = $this->get(QueryBuilderFactoryInterface::class)->create();
        $queryBuilder->delete('oemt_product_vote');
        $queryBuilder->execute();
    }

    protected function get(string $serviceId)
    {
        return ContainerFactory::getInstance()->getContainer()->get($serviceId);
    }
}
