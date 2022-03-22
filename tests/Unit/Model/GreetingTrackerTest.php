<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tests\Unit\Model;

use OxidEsales\ModuleTemplate\Model\GreetingTracker;
use OxidEsales\TestingLibrary\UnitTestCase;

final class GreetingTrackerTest extends UnitTestCase
{
    public const TEST_ID = '_testoxid';

    public function setUp(): void
    {
        parent::setUp();

        //Add you own setup logic AFTER the parent one
    }

    public function tearDown(): void
    {
        //this method removes all rows where column 'oxid' start with an underscore
        $this->cleanUpTable('oetm_tracker', 'oxid');

        //Add you own tear down logic BEFORE the parent one
        parent::tearDown();
    }

    public function testGetCount(): void
    {
        $this->prepareTestData(22);
        $tracker = oxNew(GreetingTracker::class);
        $tracker->load(self::TEST_ID);

        $this->assertSame(22, $tracker->getCount());
    }

    public function testCountUp(): void
    {
        $this->prepareTestData(10);
        $tracker = oxNew(GreetingTracker::class);
        $tracker->load(self::TEST_ID);

        $tracker->countUp();
        $tracker->countUp();
        $tracker->countUp();

        $this->assertSame(13, $tracker->getCount());
    }

    private function prepareTestData(int $count = 0): string
    {
        $tracker = oxNew(GreetingTracker::class);
        $tracker->assign(
            [
                'oxid'      => self::TEST_ID,
                'oxshopid'  => '1',
                'oxuserid'  => '_testuser',
                'oetmcount' => $count,
            ]
        );

        return (string) $tracker->save();
    }
}
