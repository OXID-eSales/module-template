<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tests\Integration\Greeting;

use OxidEsales\ModuleTemplate\Greeting\Repository;
use OxidEsales\ModuleTemplate\Tests\Integration\IntegrationTestCase;
use OxidEsales\ModuleTemplate\Traits\ServiceContainer;
use OxidEsales\Eshop\Application\Model\User as EshopModelUser;

class RepositoryTest extends IntegrationTestCase
{
    use ServiceContainer;

    public const TEST_USER_ID = '_testuser';
    public const TEST_GREETING = 'Hi there';

    public function testGetSavedUserGreeting(): void
    {
        $this->prepareTestData();

        $repo = $this->getServiceFromContainer(Repository::class);

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
