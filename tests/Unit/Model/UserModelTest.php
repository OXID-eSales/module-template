<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tests\Unit\Model;

use OxidEsales\Eshop\Application\Model\User as EshopModelUser;
use OxidEsales\TestingLibrary\UnitTestCase;

final class UserModelTest extends UnitTestCase
{
    public function tearDown(): void
    {
        //this method removes all rows where column 'oxid' start with an underscore
        $this->cleanUpTable('oxuser', 'oxid');

        parent::tearDown();
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
        $user->save();
        unset($user);

        $user = oxNew(EshopModelUser::class);
        $user->load('_newuser');
        $this->assertTrue($user->isLoaded());
        $this->assertSame('some information about me', $user->getPersonalGreeting());
    }
}
