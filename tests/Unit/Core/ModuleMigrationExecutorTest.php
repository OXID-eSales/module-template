<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tests\Unit\Core;

use OxidEsales\DoctrineMigrationWrapper\Migrations;
use OxidEsales\ModuleTemplate\Core\ModuleMigrationExecutor;
use PHPUnit\Framework\TestCase;

class ModuleMigrationExecutorTest extends TestCase
{
    public function testExecuteModuleMigrationsWhenItsNotNeeded(): void
    {
        $exampleModuleId = 'someModuleId';

        $migrationExecutorSpy = $this->createMock(Migrations::class);
        $migrationExecutorSpy->expects($this->once())
            ->method('execute')
            ->with('migrations:up-to-date', $exampleModuleId)
            ->willReturn(0);

        $sut = $this->createPartialMock(ModuleMigrationExecutor::class, ['getMigrationExecutor']);
        $sut->method('getMigrationExecutor')->willReturn($migrationExecutorSpy);

        $sut->executeModuleMigrations($exampleModuleId);
    }

    public function testExecuteModuleMigrationsWhenItsNeeded(): void
    {
        $exampleModuleId = 'someModuleId';

        $migrationExecutorSpy = $this->createMock(Migrations::class);
        $migrationExecutorSpy->expects($this->exactly(2))
            ->method('execute')
            ->with($this->anything(), $exampleModuleId)
            ->willReturn(1);

        $sut = $this->createPartialMock(ModuleMigrationExecutor::class, ['getMigrationExecutor']);
        $sut->method('getMigrationExecutor')->willReturn($migrationExecutorSpy);

        $sut->executeModuleMigrations($exampleModuleId);
    }

    public function testGetMigrationExecutor(): void
    {
        $sut = new ModuleMigrationExecutor();
        $this->assertInstanceOf(Migrations::class, $sut->getMigrationExecutor());
    }
}
