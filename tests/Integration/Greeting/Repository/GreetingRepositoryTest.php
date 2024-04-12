<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tests\Integration\Greeting\Repository;

use OxidEsales\Eshop\Application\Model\User as EshopModelUser;
use OxidEsales\ModuleTemplate\Greeting\Repository\GreetingRepositoryInterface;
use OxidEsales\ModuleTemplate\Tests\Integration\IntegrationTestCase;

class GreetingRepositoryTest extends IntegrationTestCase
{
    public const TEST_USER_ID = '_testuser';
    public const TEST_GREETING = 'Hi there';

    public function testGetSavedUserGreeting(): void
    {
        $this->prepareTestData();

        $repo = $this->get(GreetingRepositoryInterface::class);

        $this->assertSame(self::TEST_GREETING, $repo->getSavedUserGreeting(self::TEST_USER_ID));
        $this->assertSame('', $repo->getSavedUserGreeting('_notexisting'));
    }

    private function prepareTestData(): void
    {
        $user = oxNew(EshopModelUser::class);
        $user->assign(
            [
                'oxid'         => self::TEST_USER_ID,
                'oemtgreeting' => self::TEST_GREETING,
            ]
        );
        $user->save();
    }
}
