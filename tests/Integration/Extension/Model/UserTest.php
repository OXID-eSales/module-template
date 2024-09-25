<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tests\Integration\Extension\Model;

use OxidEsales\Eshop\Application\Model\User as EshopModelUser;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;
use OxidEsales\EshopCommunity\Tests\Integration\IntegrationTestCase;
use OxidEsales\ModuleTemplate\Extension\Model\User;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(User::class)]
final class UserTest extends IntegrationTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->cleanUpUsers();
    }

    public function tearDown(): void
    {
        Registry::getSession()->setUser(null);
        parent::tearDown();
    }

    private function cleanUpUsers()
    {
        $queryBuilder = $this->get(QueryBuilderFactoryInterface::class)->create();
        $queryBuilder->delete('oxuser');
        $queryBuilder->execute();
    }

    public function testGetPersonalGreetingNotSet(): void
    {
        $user = oxNew(EshopModelUser::class);

        $this->assertEmpty($user->getPersonalGreeting());
    }

    public function testGetPersonalGreeting(): void
    {
        $user = oxNew(EshopModelUser::class);
        $user->setPersonalGreeting('some information about me');

        $this->assertSame('some information about me', $user->getPersonalGreeting());
    }

    public function testNewFieldNotAutomaticallySavedToDatabase(): void
    {
        $user = oxNew(EshopModelUser::class);
        $user->setId('_testuser');
        $user->save();
        $user->setPersonalGreeting('some information about me');
        unset($user); //this object was not saved after last assign

        $user = oxNew(EshopModelUser::class);
        $user->load('_testuser');
        $this->assertEmpty($user->getPersonalGreeting());
        unset($user);
    }

    public function testNewFieldSavedToDatabase(): void
    {
        $user = oxNew(EshopModelUser::class);
        $user->setId('_newuser');
        $user->save();
        $user->setPersonalGreeting('some information about me');
        $user->assign([
            'oxusername' => null,
            'oxpassword' => null,
            'oxregister' => null,
        ]);
        $user->save();
        unset($user);

        $user = oxNew(EshopModelUser::class);
        $user->load('_newuser');
        $this->assertTrue($user->isLoaded());
        $this->assertSame('some information about me', $user->getPersonalGreeting());
    }
}
