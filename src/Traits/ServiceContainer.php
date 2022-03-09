<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Traits;

use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;

trait ServiceContainer
{
    /**
     * @template T
     * @psalm-param class-string<T> $serviceName
     *
     * @return T
     */
    protected function getServiceFromContainer(string $serviceName)
    {
        return ContainerFactory::getInstance()
            ->getContainer()
            ->get($serviceName);
    }
}
