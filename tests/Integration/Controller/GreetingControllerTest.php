<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tests\Integration\Controller;

use OxidEsales\Eshop\Application\Model\User as EshopModelUser;
use OxidEsales\ModuleTemplate\Controller\GreetingController;
use OxidEsales\ModuleTemplate\Core\Module as ModuleCore;
use OxidEsales\ModuleTemplate\Model\GreetingTracker;
use OxidEsales\ModuleTemplate\Model\User as ModuleUser;
use OxidEsales\ModuleTemplate\Service\ModuleSettings;
use OxidEsales\ModuleTemplate\Service\Repository;
use OxidEsales\ModuleTemplate\Traits\ServiceContainer;
use OxidEsales\TestingLibrary\UnitTestCase;

/*
 * We want to test controller behavior going 'full way'.
 * No mocks, we go straight to the database (full integration)).
 */
final class GreetingControllerTest extends UnitTestCase
{
    use ServiceContainer;

    public const TEST_USER_ID = '_testuser';

    public const TEST_GREETING = 'oh dear';

    public const TEST_GREETING_UPDATED = 'shopping addict';

    public function tearDown(): void
    {
        $this->cleanUpTable('oetm_tracker', 'oxuserid');
        $this->cleanUpTable('oxuser', 'oxid');

        parent::tearDown();
    }

    /**
     * @dataProvider providerOetmGreeting
     */
    public function testUpdateGreeting(bool $hasUser, string $mode, string $expected, int $count): void
    {
        $moduleSettings = $this->getServiceFromContainer(ModuleSettings::class);
        $moduleSettings->saveGreetingMode($mode);
        $this->setRequestParameter(ModuleCore::OETM_GREETING_TEMPLATE_VARNAME, $expected);

        $controller = oxNew(GreetingController::class);

        if ($hasUser) {
            $controller->setUser($this->createTestUser());
        }

        $controller->updateGreeting();

        /** @var ModuleUser $user */
        $user = oxNew(EshopModelUser::class);
        $user->load(self::TEST_USER_ID);
        $this->assertSame($expected, $user->getPersonalGreeting());

        $tracker = $this->getServiceFromContainer(Repository::class)
            ->getTrackerByUserId(self::TEST_USER_ID);
        $this->assertSame($count, $tracker->getCount());
    }

    /**
     * @dataProvider providerRender
     */
    public function testRender(bool $hasUser, string $mode, array $expected): void
    {
        $this->createTestTracker();

        $moduleSettings = $this->getServiceFromContainer(ModuleSettings::class);
        $moduleSettings->saveGreetingMode($mode);

        $controller = oxNew(GreetingController::class);

        if ($hasUser) {
            $controller->setUser($this->createTestUser());
        }

        $this->assertSame('greetingtemplate.tpl', $controller->render());

        $viewData = $controller->getViewData();
        $this->assertSame($expected['greeting'], $viewData[ModuleCore::OETM_GREETING_TEMPLATE_VARNAME]);
        $this->assertSame($expected['counter'], $viewData[ModuleCore::OETM_COUNTER_TEMPLATE_VARNAME]);
    }

    public function providerOetmGreeting(): array
    {
        return [
            'without_user_generic' => [
                'user'          => false,
                'greeting_mode' => ModuleSettings::GREETING_MODE_GENERIC,
                'expected'      => '',
                'count'         => 0,
            ],
            'without_user_personal' => [
                'user'          => false,
                'greeting_mode' => ModuleSettings::GREETING_MODE_PERSONAL,
                'expected'      => '',
                'count'         => 0,
            ],
            'with_user_generic' => [
                'user'          => true,
                'greeting_mode' => ModuleSettings::GREETING_MODE_GENERIC,
                'expect'        => self::TEST_GREETING,
                'count'         => 0,
            ],
            'with_user_personal' => [
                'user'          => true,
                'greeting_mode' => ModuleSettings::GREETING_MODE_PERSONAL,
                'expect'        => self::TEST_GREETING_UPDATED,
                'count'         => 1,
            ],
        ];
    }

    public function providerRender(): array
    {
        return [
            'without_user_generic' => [
                'user'          => false,
                'greeting_mode' => ModuleSettings::GREETING_MODE_GENERIC,
                'expected'      => [
                    'greeting' => '',
                    'counter'  => 0,
                ],
            ],
            'without_user_personal' => [
                'user'          => false,
                'greeting_mode' => ModuleSettings::GREETING_MODE_PERSONAL,
                'expected'      => [
                    'greeting' => '',
                    'counter'  => 0,
                ],
            ],
            'with_user_generic' => [
                'user'          => true,
                'greeting_mode' => ModuleSettings::GREETING_MODE_GENERIC,
                'expected'      => [
                    'greeting' => '',
                    'counter'  => 0,
                ],
            ],
            'with_user_personal' => [
                'user'          => true,
                'greeting_mode' => ModuleSettings::GREETING_MODE_PERSONAL,
                'expected'      => [
                    'greeting' => self::TEST_GREETING,
                    'counter'  => 67,
                ],
            ],
        ];
    }

    private function getControllerMock(array $map): GreetingController
    {
        $controller = $this->getMockBuilder(GreetingController::class)
            ->onlyMethods(['getServiceFromContainer'])
            ->getMock();
        $controller->method('getServiceFromContainer')
            ->willReturnMap($map);

        return $controller;
    }

    private function createTestUser(): EshopModelUser
    {
        $user = oxNew(EshopModelUser::class);
        $user->assign(
            [
                'oxid'         => self::TEST_USER_ID,
                'oetmgreeting' => self::TEST_GREETING,
            ]
        );
        $user->save();

        return $user;
    }

    private function createTestTracker(): void
    {
        $tracker = oxNew(GreetingTracker::class);
        $tracker->assign(
            [
                'oxuserid'  => self::TEST_USER_ID,
                'oxshopid'  => 1,
                'oetmcount' => '67',
            ]
        );
        $tracker->save();
    }
}
