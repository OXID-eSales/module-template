<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Model\Core;

use Exception;
use OxidEsales\DoctrineMigrationWrapper\MigrationsBuilder;

/**
 * Class defines what module does on Shop events.
 */
final class Events
{
    /**
     * Execute action on activate event
     *
     * @throws Exception
     */
    public static function onActivate(): void
    {
        // execute module migrations
        self::executeModuleMigrations();
    }

    /**
     * Execute action on deactivate event
     *
     * @throws Exception
     */
    public static function onDeactivate(): void
    {
    }

    /**
     * Execute necessary module migrations on activate event
     */
    private static function executeModuleMigrations(): void
    {
        $migrations = (new MigrationsBuilder())->build();
        $migrations->execute('migrations:migrate', 'oe_moduletemplate');
    }
}
