<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tests\Unit\Controller;

use OxidEsales\ModuleTemplate\Controller\StartController as StartController;
use OxidEsales\ModuleTemplate\Model\User as UserModel;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\ModuleTemplate\Service\GreetingMessage;
use OxidEsales\ModuleTemplate\Service\ModuleSettings;
use PHPUnit\Framework\TestCase;

/*
 * Here we have tests for a what we call 'chain extended' shop class.
 *
 * NOTE: we use this test to show some mocking examples. All we need to know is
 *     if the controller calls the services as expected
 */
final class StartControllerTest extends TestCase
{
    public const TEST_USER_ID = '_testuser';

    public function tearDown(): void
    {
        Registry::getSession()->setUser(null);

        parent::tearDown();
    }

    /**
     * @dataProvider providerSessionUser
     */
    public function testGetOetmGreeting(?UserModel $user = null): void
    {
        $mock = $this->getMockBuilder(GreetingMessage::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mock->expects($this->once())
            ->method('getGreeting')
            ->with($this->equalTo($user));

        $controller = $this->getMockBuilder(StartController::class)
            ->onlyMethods(['getServiceFromContainer'])
            ->getMock();
        $controller->expects($this->once())
            ->method('getServiceFromContainer')
            ->willReturn($mock);

        $controller->setUser($user);

        $controller->getOetmGreeting();
    }

    /**
     * @dataProvider providerCanUpdateOetmGreeting
     */
    public function testCanUpdateOetmGreeting(bool $hasUser, bool $personal, string $expect): void
    {
        $controller = $this->getMockBuilder(StartController::class)
            ->onlyMethods(['getServiceFromContainer'])
            ->getMock();
        $controller->expects($this->once())
            ->method('getServiceFromContainer')
            ->willReturn($this->getModuleSettingsMock($personal));

        if ($hasUser) {
            $controller->setUser($this->getTestUser());
        }

        $this->$expect($controller->canUpdateOetmGreeting());
    }

    public function providerCanUpdateOetmGreeting(): array
    {
        return [
            'without_user_generic' => [
                'user'                   => false,
                'greeting_mode_personal' => false,
                'assert'                 => 'assertFalse',
            ],
            'without_user_personal' => [
                'user'                   => false,
                'greeting_mode_personal' => true,
                'assert'                 => 'assertFalse',
            ],
            'with_user_generic' => [
                'user'                   => true,
                'greeting_mode_personal' => false,
                'assert'                 => 'assertFalse',
            ],
            'with_user_personal' => [
                'user'                   => true,
                'greeting_mode_personal' => true,
                'assert'                 => 'assertTrue',
            ],
        ];
    }

    public function providerSessionUser(): array
    {
        return [
            'without_user' => [
                'user' => null,
            ],
            'with_user' => [
                'user' => $this->getTestUser(),
            ],
        ];
    }

    private function getTestUser(): UserModel
    {
        $user = $this->getMockBuilder(UserModel::class)->getMock();
        $user->setId(self::TEST_USER_ID);

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
}
