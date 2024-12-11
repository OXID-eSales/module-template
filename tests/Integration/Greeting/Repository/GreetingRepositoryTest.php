<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tests\Integration\Greeting\Repository;

use OxidEsales\Eshop\Application\Model\User as EshopModelUser;
use OxidEsales\EshopCommunity\Core\Di\ContainerFacade;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;
use OxidEsales\ModuleTemplate\Greeting\Repository\GreetingRepository;
use OxidEsales\ModuleTemplate\Greeting\Repository\GreetingRepositoryInterface;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(GreetingRepository::class)]
class GreetingRepositoryTest extends TestCase
{
    public const TEST_USER_ID = '_testuser';
    public const TEST_GREETING = 'Hi there';

    protected function tearDown(): void
    {
        $this->cleanUpUsers();

        parent::tearDown();
    }

    public function testGetSavedUserGreeting(): void
    {
        $this->prepareTestData();

        $repo = ContainerFacade::get(GreetingRepositoryInterface::class);

        $this->assertSame(self::TEST_GREETING, $repo->getSavedUserGreeting(self::TEST_USER_ID));
        $this->assertSame('', $repo->getSavedUserGreeting('_notexisting'));
    }

    private function prepareTestData(): void
    {
        $user = oxNew(EshopModelUser::class);
        $user->assign(
            [
                'oxid' => self::TEST_USER_ID,
                'oemtgreeting' => self::TEST_GREETING
            ]
        );
        $user->save();
    }

    private function cleanUpUsers()
    {
        $queryBuilder = ContainerFacade::get(QueryBuilderFactoryInterface::class)->create();
        $queryBuilder->delete('oxuser');
        $queryBuilder->execute();
    }
}
