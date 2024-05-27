<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tests\Integration\Greeting\Controller;

use OxidEsales\Eshop\Application\Model\User as EshopModelUser;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use OxidEsales\ModuleTemplate\Core\Module as ModuleCore;
use OxidEsales\ModuleTemplate\Extension\Model\User as ModuleUser;
use OxidEsales\ModuleTemplate\Greeting\Controller\GreetingController;
use OxidEsales\ModuleTemplate\Settings\Service\ModuleSettingsServiceInterface;
use OxidEsales\ModuleTemplate\Tests\Integration\IntegrationTestCase;
use OxidEsales\ModuleTemplate\Tracker\Model\TrackerModel;
use OxidEsales\ModuleTemplate\Tracker\Repository\TrackerRepositoryInterface;
use PHPUnit\Framework\Attributes\CoversClass;

/*
 * We want to test controller behavior going 'full way'.
 * No mocks, we go straight to the database (full integration)).
 *
 * @todo: why no mocks? Unnecessary coupling. Whole system functionality should be checked with Acceptance test instead.
 * @todo: rework this fully to test only controller logic
 */
#[CoversClass(GreetingController::class)]
final class GreetingControllerTest extends IntegrationTestCase
{
    public const TEST_USER_ID = '_testuser';

    public const TEST_GREETING = 'oh dear';

    public const TEST_GREETING_UPDATED = 'shopping addict';

    public function setUp(): void
    {
        parent::setUp();

        $this->cleanUpTrackers();
        $this->cleanUpUsers();
    }

    public function tearDown(): void
    {
        Registry::getSession()->setUser(null);
        parent::tearDown();
    }

    /**
     * @dataProvider providerOemtGreeting
     */
    public function testUpdateGreeting(bool $hasUser, string $mode, string $expected, int $count): void
    {
        $moduleSettings = $this->get(ModuleSettingsServiceInterface::class);
        $moduleSettings->saveGreetingMode($mode);
        $_POST[ModuleCore::OEMT_GREETING_TEMPLATE_VARNAME] = $expected;

        $controller = oxNew(GreetingController::class);

        if ($hasUser) {
            $controller->setUser($this->createTestUser());
        }

        $controller->updateGreeting();

        /** @var ModuleUser $user */
        $user = oxNew(EshopModelUser::class);
        $user->load(self::TEST_USER_ID);
        $this->assertSame($expected, $user->getPersonalGreeting());

        $tracker = $this->get(TrackerRepositoryInterface::class)
            ->getTrackerByUserId(self::TEST_USER_ID);
        $this->assertSame($count, $tracker->getCount());
    }

    /**
     * @dataProvider providerRender
     */
    public function testRender(bool $hasUser, string $mode, array $expected): void
    {
        $this->createTestTracker();

        $moduleSettings = $this->get(ModuleSettingsServiceInterface::class);
        $moduleSettings->saveGreetingMode($mode);

        $controller = oxNew(GreetingController::class);

        if ($hasUser) {
            $controller->setUser($this->createTestUser());
        }

        $this->assertSame('@oe_moduletemplate/templates/greetingtemplate', $controller->render());

        $viewData = $controller->getViewData();
        $this->assertSame($expected['greeting'], $viewData[ModuleCore::OEMT_GREETING_TEMPLATE_VARNAME]);
        $this->assertSame($expected['counter'], $viewData[ModuleCore::OEMT_COUNTER_TEMPLATE_VARNAME]);
    }

    public static function providerOemtGreeting(): array
    {
        return [
            'without_user_generic' => [
                'hasUser' => false,
                'mode' => ModuleSettingsServiceInterface::GREETING_MODE_GENERIC,
                'expected' => '',
                'count' => 0,
            ],
            'without_user_personal' => [
                'hasUser' => false,
                'mode' => ModuleSettingsServiceInterface::GREETING_MODE_PERSONAL,
                'expected' => '',
                'count' => 0,
            ],
            'with_user_generic' => [
                'hasUser' => true,
                'mode' => ModuleSettingsServiceInterface::GREETING_MODE_GENERIC,
                'expected' => self::TEST_GREETING,
                'count' => 0,
            ],
            'with_user_personal' => [
                'hasUser' => true,
                'mode' => ModuleSettingsServiceInterface::GREETING_MODE_PERSONAL,
                'expected' => self::TEST_GREETING_UPDATED,
                'count' => 1,
            ],
        ];
    }

    public static function providerRender(): array
    {
        return [
            'without_user_generic' => [
                'hasUser' => false,
                'mode' => ModuleSettingsServiceInterface::GREETING_MODE_GENERIC,
                'expected' => [
                    'greeting' => '',
                    'counter' => 0,
                ],
            ],
            'without_user_personal' => [
                'hasUser' => false,
                'mode' => ModuleSettingsServiceInterface::GREETING_MODE_PERSONAL,
                'expected' => [
                    'greeting' => '',
                    'counter' => 0,
                ],
            ],
            'with_user_generic' => [
                'hasUser' => true,
                'mode' => ModuleSettingsServiceInterface::GREETING_MODE_GENERIC,
                'expected' => [
                    'greeting' => '',
                    'counter' => 0,
                ],
            ],
            'with_user_personal' => [
                'hasUser' => true,
                'mode' => ModuleSettingsServiceInterface::GREETING_MODE_PERSONAL,
                'expected' => [
                    'greeting' => self::TEST_GREETING,
                    'counter' => 67,
                ],
            ],
        ];
    }

    private function createTestUser(): EshopModelUser
    {
        $user = oxNew(EshopModelUser::class);
        $user->assign(
            [
                'oxid' => self::TEST_USER_ID,
                'oemtgreeting' => self::TEST_GREETING,
            ]
        );
        $user->save();

        return $user;
    }

    private function createTestTracker(): void
    {
        $tracker = oxNew(TrackerModel::class);
        $tracker->assign(
            [
                'oxuserid' => self::TEST_USER_ID,
                'oxshopid' => 1,
                'oemtcount' => '67',
            ]
        );
        $tracker->save();
    }
}
