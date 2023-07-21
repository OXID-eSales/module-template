<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Utility;

use OxidEsales\EshopCommunity\Core\Registry;
use OxidEsales\ModuleTemplate\Service\BasketItemLogger;
use Psr\Log\LogLevel;
use Webmozart\PathUtil\Path;

class Context
{
    /**
     * @return string
     */
    public static function getBasketLogFilePath(): string
    {
        return Path::join(Registry::getConfig()->getLogsDir(), BasketItemLogger::FILE_NAME);
    }

    public static function getBasketLogLevel(): string
    {
        return LogLevel::INFO;
    }
}