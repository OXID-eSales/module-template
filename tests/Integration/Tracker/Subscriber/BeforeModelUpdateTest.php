<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tests\Integration\Subscriber;

use OxidEsales\Eshop\Application\Model\User as EshopModelUser;
use OxidEsales\EshopCommunity\Internal\Transition\ShopEvents\BeforeModelUpdateEvent;
use OxidEsales\ModuleTemplate\Model\GreetingTracker;
use OxidEsales\ModuleTemplate\Tests\Integration\IntegrationTestCase;
use OxidEsales\ModuleTemplate\Tracker\Service\TrackerServiceInterface;
use OxidEsales\ModuleTemplate\Tracker\Subscriber\BeforeModelUpdate;

final class BeforeModelUpdateTest extends IntegrationTestCase
{
    public function testHandleEventWithNotMatchingPayload(): void
    {
        $event = new BeforeModelUpdateEvent(oxNew(GreetingTracker::class));

        $sut = new BeforeModelUpdate(
            trackerService: $trackerSpy = $this->createMock(TrackerServiceInterface::class)
        );
        $trackerSpy->expects($this->never())->method('updateTracker');

        $sut->handle($event);
    }

    public function testHandleEventWithMatchingPayload(): void
    {
        $event = new BeforeModelUpdateEvent(oxNew(EshopModelUser::class));

        $sut = new BeforeModelUpdate(
            trackerService: $trackerSpy = $this->createMock(TrackerServiceInterface::class)
        );
        $trackerSpy->expects($this->once())->method('updateTracker');

        $sut->handle($event);
    }

    public function testSubscribedEvents(): void
    {
        $handlers = BeforeModelUpdate::getSubscribedEvents();
        $this->assertArrayHasKey(BeforeModelUpdateEvent::class, $handlers);
    }
}
