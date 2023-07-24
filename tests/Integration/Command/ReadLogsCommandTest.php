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
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class ReadLogsCommandTest extends TestCase
{
    const VFS_ROOT_DIRECTORY = 'vfsRoot';

    /** @var vfsStreamDirectory */
    private $vfsRoot;

    public function setUp(): void
    {
        $this->vfsRoot = vfsStream::setup(self::VFS_ROOT_DIRECTORY);
        parent::setUp();
    }

    public function testExecute()
    {
        $fileContents = 'Test log file contents...';
        $basketLogFilePath = $this->mockFileSystemForLog($fileContents);

        $application = new Application();
        $command = new ReadLogsCommand($basketLogFilePath);
        $application->add($command);

        $commandTester = new CommandTester($command);
        $commandTester->execute([]);

        $this->assertStringContainsString('log file content', $commandTester->getDisplay());
        $this->assertStringContainsString($fileContents, $commandTester->getDisplay());

    }

    public function testExecuteLogNotFound()
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
     *
     * @return string $filePath.
     */
    private function mockFileSystemForLog($fileContents)
    {

        $fileName = vfsStream::url(self::VFS_ROOT_DIRECTORY . '/basket.txt');
        $bytes = @file_put_contents($fileName, $fileContents);
        if (false === $bytes) {
            return 'could not write data';
        }
        $this->assertTrue($this->vfsRoot->hasChild('basket.txt'));
        $this->assertSame($fileContents, $this->vfsRoot->getChild('basket.txt')->getContent());

        return $fileName;
    }
}
