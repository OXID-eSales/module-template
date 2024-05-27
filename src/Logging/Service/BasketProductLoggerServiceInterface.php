<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Logging\Service;

interface BasketProductLoggerServiceInterface
{
    public function log(string $productID): void;
}
