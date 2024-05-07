<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Greeting\Repository;

use Doctrine\DBAL\Query\QueryBuilder;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;
use OxidEsales\ModuleTemplate\Extension\Model\User;

class GreetingRepository implements GreetingRepositoryInterface
{
    public function __construct(
        private QueryBuilderFactoryInterface $queryBuilderFactory,
    ) {
    }

    public function getSavedUserGreeting(string $userId): string
    {
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = $this->queryBuilderFactory->create();

        $parameters = [
            'oxuserid' => $userId,
        ];

        $result = $queryBuilder->select(User::OEMT_USER_GREETING_FIELD)
            ->from('oxuser')
            ->where('oxid = :oxuserid')
            ->setParameters($parameters)
            ->setMaxResults(1)
            ->execute();

        if (is_object($result)) {
            $value = (string)$result->fetchOne();
        }

        return $value ?? '';
    }
}
