<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Model;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * Class logs items which goes to basket.
 */
class BasketItemLogger
{
    const FILE_NAME = 'basket.txt';

    const MESSAGE = 'Adding item with id \'%s\'.';

    const NAME = 'basket';

    /** @var Logger */
    private $logger;

    /** @var string */
    private $logsPath;

    /**
     * @param string $logsPath Path to logs directory.
     */
    public function __construct($logsPath)
    {
        $this->logsPath = $logsPath;
    }

    /**
     * Method logs items which goes to basket.
     *
     * @param string $itemId
     */
    public function logItemToBasket($itemId)
    {
        $this->getLogger()->addInfo(sprintf(static::MESSAGE, $itemId));
    }

    /**
     * @param Logger $logger
     */
    public function setLogger($logger)
    {
        $this->logger = $logger;
    }

    /**
     * @return Logger
     */
    protected function getLogger()
    {
        if (is_null($this->logger)) {
            $logger = new Logger(static::NAME);
            $logger->pushHandler(
                new StreamHandler(
                    $this->logsPath . DIRECTORY_SEPARATOR . static::FILE_NAME,
                    Logger::INFO
                )
            );
            $this->setLogger($logger);
        }

        return $this->logger;
    }
}