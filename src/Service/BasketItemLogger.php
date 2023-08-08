<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Service;

use OxidEsales\EshopCommunity\Internal\Framework\Module\Facade\ModuleSettingServiceInterface;
use OxidEsales\ModuleTemplate\Core\Module;
use Psr\Log\LoggerInterface;

/**
 * Class logs items which goes to basket.
 */
final class BasketItemLogger implements BasketItemLoggerInterface
{
    private const MESSAGE = 'Adding item with id \'%s\'.';
    public const LOGGER_STATUS = 'oemoduletemplate_LoggerEnabled';

    public function __construct(
        private LoggerInterface $logger,
        private ModuleSettingServiceInterface $moduleSettingService,
    ) {
    }

    public function logItemToBasket(string $itemId): void
    {
        if ($this->moduleSettingService->getBoolean(self::LOGGER_STATUS, Module::MODULE_ID)) {
            $this->logger->info(
                sprintf(self::MESSAGE, $itemId)
            );
        }
    }
}
