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
use OxidEsales\ModuleTemplate\Service\Tracker;
use OxidEsales\ModuleTemplate\Subscriber\BeforeModelUpdate;
use OxidEsales\ModuleTemplate\Tests\Integration\IntegrationTestCase;

final class BeforeModelUpdateTest extends IntegrationTestCase
{
    public const TEST_USER_ID = '_testuser';

    public function testHandleEventWithNotMatchingPayload(): void
    {
        $event = new BeforeModelUpdateEvent(oxNew(GreetingTracker::class));

        $sut = new BeforeModelUpdate(
            tracker: $trackerSpy = $this->createMock(Tracker::class)
        );
        $trackerSpy->expects($this->never())->method('updateTracker');

        $sut->handle($event);
    }

    public function testHandleEventWithMatchingPayload(): void
    {
        $event = new BeforeModelUpdateEvent(oxNew(EshopModelUser::class));

        $sut = new BeforeModelUpdate(
            tracker: $trackerSpy = $this->createMock(Tracker::class)
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
