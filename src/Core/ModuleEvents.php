<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Core;

/**
 * Class defines what module does on Shop events.
 *
 * @codeCoverageIgnore
 */
final class ModuleEvents
{
    /**
     * Execute action on activate event
     */
    public static function onActivate(): void
    {
        // execute module migrations
        $migrationExecutor = new ModuleMigrationExecutor();
        $migrationExecutor->executeModuleMigrations(Module::MODULE_ID);
    }

    /**
     * Execute action on deactivate event
     */
    public static function onDeactivate(): void
    {
        //nothing to be done here for this module right now
    }
}
