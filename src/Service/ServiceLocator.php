<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Service;

use OxidEsales\Eshop\Core\Registry as EshopRegistry;
use OxidEsales\Eshop\Core\Request as EshopRequest;
use OxidEsales\Eshop\Core\Session as EshopSession;
use Psr\Container\ContainerInterface;
use Symfony\Contracts\Service\ServiceSubscriberInterface;

class ServiceLocator implements ServiceSubscriberInterface
{
    private $locator;

    public function __construct(ContainerInterface $locator)
    {
        $this->locator = $locator;
    }

    public static function getSubscribedServices(): array
    {
        return [
            \OxidEsales\ModuleTemplate\Service\ModuleSettings::class,
        ];
    }

    public function getService(string $name)
    {
        return $this->locator->get($name);
    }

    public function getRequest(): EshopRequest
    {
        return EshopRegistry::getRequest();
    }

    public function getSession(): EshopSession
    {
        return EshopRegistry::getSession();
    }
}
