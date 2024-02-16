<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tests\Integration\Command;

use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use OxidEsales\ModuleTemplate\Command\ReadLogsCommand;
use OxidEsales\ModuleTemplate\Tests\Integration\IntegrationTestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

final class ReadLogsCommandTest extends IntegrationTestCase
{
    private const VFS_ROOT_DIRECTORY = 'vfsRoot';

    /** @var vfsStreamDirectory */
    private $vfsRoot;

    public function setUp(): void
    {
        $this->vfsRoot = vfsStream::setup(self::VFS_ROOT_DIRECTORY);
        parent::setUp();
    }

    public function testExecute(): void
    {
        $fileContents = 'Test log file contents...';
        $basketLogFilePath = $this->getFileFromVfsSteam($fileContents);

        $application = new Application();
        $command = new ReadLogsCommand($basketLogFilePath);
        $application->add($command);

        $commandTester = new CommandTester($command);
        $commandTester->execute([]);

        $this->assertStringContainsString($fileContents, $commandTester->getDisplay());
    }

    public function testExecuteLogNotFound(): void
    {
        $nonExistentFilePath = '/none/existent/file.log';
        $command = new ReadLogsCommand($nonExistentFilePath);

        $application = new Application();
        $application->add($command);

        $commandTester = new CommandTester($command);
        $commandTester->execute([]);

        $this->assertStringContainsString('was not found', $commandTester->getDisplay());
    }

    /**
     * Use VfsStream to not write to file system.
     */
    private function getFileFromVfsSteam(string $fileContents): string
    {
        $fileName = 'basket.txt';
        vfsStream::newFile($fileName, 0755)
            ->withContent($fileContents)
            ->at($this->vfsRoot);

        $this->assertTrue($this->vfsRoot->hasChild($fileName));
        $this->assertSame($fileContents, $this->vfsRoot->getChild($fileName)->getContent());

        return vfsStream::url(self::VFS_ROOT_DIRECTORY . DIRECTORY_SEPARATOR . $fileName);
    }
}
