<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tests\Integration\Tracker\Repository;

use OxidEsales\ModuleTemplate\Greeting\Model\GreetingTracker;
use OxidEsales\ModuleTemplate\Tests\Integration\IntegrationTestCase;
use OxidEsales\ModuleTemplate\Tracker\Repository\TrackerRepositoryInterface;

final class TrackerRepositoryTest extends IntegrationTestCase
{
    public const TEST_TRACKER_ID = '_testoxid';

    public const TEST_USER_ID = '_testuser';

    public const TEST_GREETING = 'Hi there';

    public function testGetExistingTrackerByUserId(): void
    {
        $this->prepareTestData();

        $repo    = $this->get(TrackerRepositoryInterface::class);
        $tracker = $repo->getTrackerByUserId(self::TEST_USER_ID);

        $this->assertSame(self::TEST_TRACKER_ID, $tracker->getId());
    }

    public function testGetNotExistingTrackerByUserId(): void
    {
        $repo    = $this->get(TrackerRepositoryInterface::class);
        $tracker = $repo->getTrackerByUserId('_notexisting');

        $this->assertEmpty($tracker->getId());
        $this->assertSame('_notexisting', $tracker->getFieldData('oxuserid'));
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
    }
}
