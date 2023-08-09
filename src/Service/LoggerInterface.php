<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Service;

interface LoggerInterface
{
    /**
     *
     * @param string $message
     */
    public function log(string $message): void;
}
