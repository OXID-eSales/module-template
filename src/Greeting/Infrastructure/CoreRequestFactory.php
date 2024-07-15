<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Greeting\Infrastructure;

use OxidEsales\Eshop\Core\Request;

class CoreRequestFactory implements CoreRequestFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function create(): Request
    {
        return oxNew(Request::class);
    }
}
