<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Core;

use OxidEsales\DoctrineMigrationWrapper\Migrations;
use OxidEsales\DoctrineMigrationWrapper\MigrationsBuilder;

/**
 * @todo: something like this could be available in the migration wrapper itself?
 */
class ModuleMigrationExecutor
{
    public function executeModuleMigrations(string $moduleId): void
    {
        $migrations = $this->getMigrationExecutor();
        $neeedsUpdate = $migrations->execute('migrations:up-to-date', $moduleId);
        if ($neeedsUpdate) {
            $migrations->execute('migrations:migrate', $moduleId);
        }
    }

    public function getMigrationExecutor(): Migrations
    {
        return (new MigrationsBuilder())->build();
    }
}
