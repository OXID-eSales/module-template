<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tracker\Repository;

use Doctrine\DBAL\Query\QueryBuilder;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;
use OxidEsales\EshopCommunity\Internal\Transition\Utility\ContextInterface;
use OxidEsales\ModuleTemplate\Tracker\Model\TrackerModel;

/**
 * @extendable-class
 */
readonly class TrackerRepository implements TrackerRepositoryInterface
{
    public function __construct(
        private QueryBuilderFactoryInterface $queryBuilderFactory,
        private ContextInterface $context,
    ) {
    }

    public function getTrackerByUserId(string $userId): TrackerModel
    {
        $tracker = oxNew(TrackerModel::class);
        $trackerId = $this->getGreetingTrackerId($userId);

        if ($trackerId) {
            $tracker->load($trackerId);
        }

        //if it cannot be loaded from database, create a new object
        if (!$tracker->isLoaded()) {
            $tracker->assign([
                'oxuserid' => $userId,
                'oxshopid' => $this->context->getCurrentShopId(),
            ]);
        }

        return $tracker;
    }

    private function getGreetingTrackerId(string $userId): string
    {
        $queryBuilder = $this->queryBuilderFactory->create();

        $parameters = [
            'oxuserid' => $userId,
            'oxshopid' => $this->context->getCurrentShopId(),
        ];

        $result = $queryBuilder->select('oxid')
            ->from('oemt_tracker')
            ->where('oxuserid = :oxuserid')
            ->andWhere('oxshopid = :oxshopid')
            ->setParameters($parameters)
            ->setMaxResults(1)
            ->execute();

        if (is_object($result)) {
            $value = (string)$result->fetchOne();
        }

        return $value ?? '';
    }
}
