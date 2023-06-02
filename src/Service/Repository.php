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
use OxidEsales\ModuleTemplate\Model\User;
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
        $this->context = $context;
    }

    public function getSavedUserGreeting(string $userId): string
    {
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = $this->queryBuilderFactory->create();

        $parameters = [
            'oxuserid' => $userId,
        ];

        $queryBuilder->select(User::OEMT_USER_GREETING_FIELD)
            ->from('oxuser')
            ->where('oxid = :oxuserid');

        return $this->queryValue($queryBuilder, $parameters);
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
            ->from('oemt_tracker')
            ->where('oxuserid = :oxuserid')
            ->andWhere('oxshopid = :oxshopid');

        return $this->queryValue($queryBuilder, $parameters);
    }

    private function queryValue(QueryBuilder $queryBuilder, array $parameters): string
    {
        $result = $queryBuilder->setParameters($parameters)
            ->setMaxResults(1)
            ->execute();

        if (is_object($result)) {
            $value = (string)$result->fetchOne();
        }

        return $value ?? '';
    }
}
