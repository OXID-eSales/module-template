<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tests\Unit\Controller;

use OxidEsales\Eshop\Application\Model\User as EshopModelUser;
use OxidEsales\ModuleTemplate\Controller\GreetingController;
use OxidEsales\ModuleTemplate\Core\Module as ModuleCore;
use OxidEsales\ModuleTemplate\Model\GreetingTracker;
use OxidEsales\ModuleTemplate\Service\GreetingMessage;
use OxidEsales\ModuleTemplate\Service\ModuleSettings;
use OxidEsales\ModuleTemplate\Service\Repository;
use OxidEsales\TestingLibrary\UnitTestCase;

/*
 * Here we have tests for a new controller extending the shop's FrontendController class.
 *
 * NOTE: we use this test to show some mocking examples. All we need to know is
 *    - will the controller hold the expected view data
 *    - will the controller call the services as expected
 */
final class GreetingControllerTest extends UnitTestCase
{
    public const TEST_USER_ID = '_testuser';

    /**
     * @dataProvider providerOetmGreeting
     */
    public function testUpdateGreeting(bool $hasUser, bool $personal, string $expect): void
    {
        $map = [
            [
                ModuleSettings::class,
                $this->getModuleSettingsMock($personal),
            ],
            [
                GreetingMessage::class,
                $this->getGreetingMessageMock($expect),
            ],
        ];
        $controller = $this->getControllerMock($map);

        if ($hasUser) {
            $controller->setUser($this->getTestUser());
        }

        $controller->updateGreeting();
    }

    /**
     * @dataProvider providerOetmGreeting
     */
    public function testRender(bool $hasUser, bool $personal, string $expect, array $expectedData): void
    {
        $map = [
            [
                ModuleSettings::class,
                $this->getModuleSettingsMock($personal),
            ],
            [
                Repository::class,
                $this->getRepositoryMock(),
            ],
        ];
        $controller = $this->getControllerMock($map);

        if ($hasUser) {
            $controller->setUser($this->getTestUser());
        }

        $this->assertSame('greetingtemplate.tpl', $controller->render());

        $viewData = $controller->getViewData();
        $this->assertSame($expectedData[0], $viewData[ModuleCore::OETM_GREETING_TEMPLATE_VARNAME]);
        $this->assertSame($expectedData[1], $viewData[ModuleCore::OETM_COUNTER_TEMPLATE_VARNAME]);
    }

    public function providerOetmGreeting(): array
    {
        return [
            'without_user_generic' => [
                'user'                   => false,
                'greeting_mode_personal' => false,
                'expect'                 => 'never',
                'viewdata'               => ['', 0],
            ],
            'without_user_personal' => [
                'user'                   => false,
                'greeting_mode_personal' => true,
                'expect'                 => 'never',
                'viewdata'               => ['', 0],
            ],
            'with_user_generic' => [
                'user'                   => true,
                'greeting_mode_personal' => false,
                'expect'                 => 'never',
                'viewdata'               => ['', 0],
            ],
            'with_user_personal' => [
                'user'                   => true,
                'greeting_mode_personal' => true,
                'expect'                 => 'once',
                'viewdata'               => ['happy_new_year', 66],
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

    private function getTestUser(): EshopModelUser
    {
        $user = $this->getMockBuilder(EshopModelUser::class)
            ->onlyMethods(['getPersonalGreeting'])
            ->getMock();
        $user->setId(self::TEST_USER_ID);
        $user->expects($this->any())
            ->method('getPersonalGreeting')
            ->willReturn('happy_new_year');

        return $user;
    }

    private function getModuleSettingsMock(bool $isPersonal = true): ModuleSettings
    {
        $mock = $this->getMockBuilder(ModuleSettings::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mock->expects($this->any())
            ->method('isPersonalGreetingMode')
            ->willReturn($isPersonal);

        return $mock;
    }

    private function getGreetingMessageMock(string $expect): GreetingMessage
    {
        $mock = $this->getMockBuilder(GreetingMessage::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mock->expects($this->$expect())
            ->method('saveOetmGreeting');

        return $mock;
    }

    private function getRepositoryMock(): Repository
    {
        $tracker = $this->getMockBuilder(GreetingTracker::class)
            ->disableOriginalConstructor()
            ->getMock();
        $tracker->expects($this->any())
            ->method('getCount')
            ->willReturn(66);

        $mock = $this->getMockBuilder(Repository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mock->expects($this->any())
            ->method('getTrackerByUserId')
            ->with($this->equalTo(self::TEST_USER_ID))
            ->willReturn($tracker);

        return $mock;
    }
}
