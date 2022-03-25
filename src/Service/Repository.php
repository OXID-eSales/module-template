<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Service;

use Doctrine\DBAL\Query\QueryBuilder;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;
use OxidEsales\EshopCommunity\Internal\Transition\Utility\ContextInterface;
use OxidEsales\ModuleTemplate\Model\GreetingTracker;
use PDO;

/**
 * @extendable-class
 */
class Repository
{
    /** @var QueryBuilderFactoryInterface */
    private $queryBuilderFactory;

    /** @var ContextInterface */
    private $context;

    public function __construct(
        QueryBuilderFactoryInterface $queryBuilderFactory,
        ContextInterface $context
    ) {
        $this->queryBuilderFactory = $queryBuilderFactory;
        $this->context             = $context;
    }

    public function getSavedUserGreeting(string $userId): string
    {
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = $this->queryBuilderFactory->create();

        $parameters = [
            'oxuserid' => $userId,
        ];

        $queryBuilder->select('oetmgreeting')
            ->from('oxuser')
            ->where('oxid = :oxuserid');

        $result = $queryBuilder->setParameters($parameters)
            ->setMaxResults(1)
            ->execute();

        $text = '';

        if (is_object($result)) {
            $text = (string) $result->fetch(PDO::FETCH_COLUMN);
        }

        return $text;
    }

    public function getTrackerByUserId(string $userId): GreetingTracker
    {
        $tracker = oxNew(GreetingTracker::class);
        $trackerId = $this->getGreetingTrackerId($userId);

        if ($trackerId) {
            $tracker->load($trackerId);
        }

        //if it cannot be loaded from database, create a new object
        if (!$tracker->isLoaded()) {
            $tracker->assign(
                [
                    'oxuserid' => $userId,
                    'oxshopid' => $this->context->getCurrentShopId(),
                ]
            );
        }

        return $tracker;
    }

    private function getGreetingTrackerId(string $userId): string
    {
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = $this->queryBuilderFactory->create();

        $parameters = [
            'oxuserid' => $userId,
            'oxshopid' => $this->context->getCurrentShopId(),
        ];

        $queryBuilder->select('oxid')
            ->from('oetm_tracker')
            ->where('oxuserid = :oxuserid')
            ->andWhere('oxshopid = :oxshopid');

        $result = $queryBuilder->setParameters($parameters)
            ->setMaxResults(1)
            ->execute();

        $trackerId = '';

        if (is_object($result)) {
            $trackerId = (string) $result->fetch(PDO::FETCH_COLUMN);
        }

        return $trackerId;
    }
}
