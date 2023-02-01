<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tests\Integration\Service;

use OxidEsales\Eshop\Application\Model\User as EshopModelUser;
use OxidEsales\ModuleTemplate\Model\GreetingTracker;
use OxidEsales\ModuleTemplate\Service\Repository;
use OxidEsales\ModuleTemplate\Tests\Integration\IntegrationTestCase;
use OxidEsales\ModuleTemplate\Traits\ServiceContainer;

final class RepositoryTest extends IntegrationTestCase
{
    use ServiceContainer;

    public const TEST_TRACKER_ID = '_testoxid';

    public const TEST_USER_ID = '_testuser';

    public const TEST_GREETING = 'Hi there';

    public function testGetExistingTrackerByUserId(): void
    {
        $this->prepareTestData();

        $repo    = $this->getServiceFromContainer(Repository::class);
        $tracker = $repo->getTrackerByUserId(self::TEST_USER_ID);

        $this->assertSame(self::TEST_TRACKER_ID, $tracker->getId());
    }

    public function testGetNotExistingTrackerByUserId(): void
    {
        $repo    = $this->getServiceFromContainer(Repository::class);
        $tracker = $repo->getTrackerByUserId('_notexisting');

        $this->assertEmpty($tracker->getId());
        $this->assertSame('_notexisting', $tracker->getFieldData('oxuserid'));
    }

    public function testGetSavedUserGreeting(): void
    {
        $this->prepareTestData();

        $repo = $this->getServiceFromContainer(Repository::class);

        $this->assertSame(self::TEST_GREETING, $repo->getSavedUserGreeting(self::TEST_USER_ID));
        $this->assertSame('', $repo->getSavedUserGreeting('_notexisting'));
    }

    private function prepareTestData(): void
    {
        $tracker = oxNew(GreetingTracker::class);
        $tracker->assign(
            [
                'oxid'      => self::TEST_TRACKER_ID,
                'oxshopid'  => '1',
                'oxuserid'  => self::TEST_USER_ID,
                'oemtcount' => 5,
            ]
        );
        $tracker->save();

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
