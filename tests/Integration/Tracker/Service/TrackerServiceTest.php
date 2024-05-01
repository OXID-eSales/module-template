<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tests\Integration\Tracker\Service;

use OxidEsales\Eshop\Application\Model\User;
use OxidEsales\Eshop\Application\Model\User as EshopModelUser;
use OxidEsales\ModuleTemplate\Greeting\Model\GreetingTracker;
use OxidEsales\ModuleTemplate\Greeting\Model\PersonalGreetingUserInterface;
use OxidEsales\ModuleTemplate\Greeting\Repository\GreetingRepositoryInterface;
use OxidEsales\ModuleTemplate\Tests\Integration\IntegrationTestCase;
use OxidEsales\ModuleTemplate\Tracker\Repository\TrackerRepository;
use OxidEsales\ModuleTemplate\Tracker\Service\TrackerService as TrackerService;

final class TrackerServiceTest extends IntegrationTestCase
{
    public const TEST_TRACKER_ID = '_testoxid';

    public const TEST_USER_ID = '_testuser';

    public const TEST_GREETING = 'Hi there';

    public function testUpdateTrackerNoGreetingChange(): void
    {
        $greetingRepository = $this->createConfiguredStub(GreetingRepositoryInterface::class, [
            'getSavedUserGreeting' => self::TEST_GREETING
        ]);

        $repo = $this->createPartialMock(TrackerRepository::class, ['getTrackerByUserId']);
        $repo->expects($this->never())->method('getTrackerByUserId');

        /** @var TrackerService $tracker */
        $tracker = new \OxidEsales\ModuleTemplate\Tracker\Service\TrackerService(
            $repo,
            $greetingRepository
        );

        $tracker->updateTracker($this->getUserModel());
    }

    public function testUpdateTrackerGreetingChange(): void
    {
        $greetingRepository = $this->createConfiguredStub(GreetingRepositoryInterface::class, [
            'getSavedUserGreeting' => self::TEST_GREETING . ' with a change'
        ]);

        $repo = $this->createPartialMock(TrackerRepository::class, ['getTrackerByUserId']);
        $repo->expects($this->once())->method('getTrackerByUserId')->willReturn($this->getGreetingTrackerMock());

        /** @var \OxidEsales\ModuleTemplate\Tracker\Service\TrackerService $tracker */
        $tracker = new \OxidEsales\ModuleTemplate\Tracker\Service\TrackerService(
            $repo,
            $greetingRepository
        );

        $tracker->updateTracker($this->getUserModel());
    }

    /**
     * NOTE: this user model is NOT saved to database
     */
    private function getUserModel(): User&PersonalGreetingUserInterface
    {
        $user = oxNew(EshopModelUser::class);
        $user->assign(
            [
                'oxid' => self::TEST_USER_ID,
                'oemtgreeting' => self::TEST_GREETING,
            ]
        );

        return $user;
    }

    private function getGreetingTrackerMock(): GreetingTracker
    {
        $tracker = $this->getMockBuilder(GreetingTracker::class)
            ->disableOriginalConstructor()
            ->getMock();

        $tracker->expects($this->once())
            ->method('countUp');

        return $tracker;
    }
}
