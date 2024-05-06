<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tests\Integration\Tracker\Model;

use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;
use OxidEsales\EshopCommunity\Tests\Integration\IntegrationTestCase;
use OxidEsales\ModuleTemplate\Tracker\Model\TrackerModel;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(TrackerModel::class)]
final class TrackerModelTest extends IntegrationTestCase
{
    public const TEST_ID = '_testoxid';

    public function setUp(): void
    {
        parent::setUp();

        $this->cleanUpTrackers();
    }

    private function cleanUpTrackers()
    {
        $queryBuilder = $this->get(QueryBuilderFactoryInterface::class)->create();
        $queryBuilder->delete('oemt_tracker');
        $queryBuilder->execute();
    }

    public function testGetCount(): void
    {
        $this->prepareTestData(22);

        $sut = oxNew(TrackerModel::class);
        $sut->load(self::TEST_ID);

        $this->assertSame(22, $sut->getCount());
    }

    public function testCountUp(): void
    {
        $this->prepareTestData(10);

        $sut = oxNew(TrackerModel::class);
        $sut->load(self::TEST_ID);

        $sut->countUp();
        $sut->countUp();
        $sut->countUp();

        $this->assertSame(13, $sut->getCount());
    }

    private function prepareTestData(int $count = 0): string
    {
        $tracker = oxNew(TrackerModel::class);
        $tracker->assign(
            [
                'oxid' => self::TEST_ID,
                'oxshopid' => '1',
                'oxuserid' => '_testuser',
                'oemtcount' => $count,
            ]
        );

        return (string)$tracker->save();
    }
}
