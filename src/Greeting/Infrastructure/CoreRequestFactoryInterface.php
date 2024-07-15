<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\ModuleTemplate\Greeting\Infrastructure;

use OxidEsales\Eshop\Core\Request;

interface CoreRequestFactoryInterface
{
    /**
     * @return Request
     */
    public function create(): Request;
}
