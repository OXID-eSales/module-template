<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tests\Unit\Service;

use OxidEsales\ModuleTemplate\Service\ModuleSettings;
use OxidEsales\ModuleTemplate\Traits\ServiceContainer;
use OxidEsales\TestingLibrary\UnitTestCase;

final class ModuleSettingsTest extends UnitTestCase
{
    use ServiceContainer;

    public function testModuleGreetingModeDefault(): void
    {
        $moduleSettings = $this->getServiceFromContainer(ModuleSettings::class);
        $moduleSettings->saveGreetingMode('');

        $this->assertEquals(ModuleSettings::GREETING_MODE_GENERIC, $moduleSettings->getGreetingMode());
        $this->assertFalse($moduleSettings->isPersonalGreetingMode());
    }

    public function testModuleGreetingMode(): void
    {
        $moduleSettings = $this->getServiceFromContainer(ModuleSettings::class);

        $moduleSettings->saveGreetingMode(ModuleSettings::GREETING_MODE_PERSONAL);
        $this->assertEquals(ModuleSettings::GREETING_MODE_PERSONAL, $moduleSettings->getGreetingMode());
        $this->assertTrue($moduleSettings->isPersonalGreetingMode());

        $moduleSettings->saveGreetingMode(ModuleSettings::GREETING_MODE_GENERIC);
        $this->assertEquals(ModuleSettings::GREETING_MODE_GENERIC, $moduleSettings->getGreetingMode());
        $this->assertFalse($moduleSettings->isPersonalGreetingMode());
    }

    public function testModuleGreetingModeIncorrectValue(): void
    {
        $moduleSettings = $this->getServiceFromContainer(ModuleSettings::class);

        $moduleSettings->saveGreetingMode('some_other_value');
        $this->assertEquals(ModuleSettings::GREETING_MODE_GENERIC, $moduleSettings->getGreetingMode());
    }
}
