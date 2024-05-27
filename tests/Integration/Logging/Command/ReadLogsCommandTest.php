<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tests\Integration\Logging\Command;

use org\bovigo\vfs\vfsStream;
use OxidEsales\ModuleTemplate\Logging\Command\ReadLogsCommand;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

#[CoversClass(ReadLogsCommand::class)]
final class ReadLogsCommandTest extends TestCase
{
    private const VFS_ROOT_DIRECTORY = 'vfsRoot';

    public function testExecute(): void
    {
        $fileContents = 'Test log file contents...';
        $basketLogFilePath = $this->getVirtualTestLogFilePath($fileContents);

        $sut = new ReadLogsCommand($basketLogFilePath);

        $application = new Application();
        $application->add($sut);

        $commandTester = new CommandTester($sut);
        $commandTester->execute([]);

        $this->assertStringContainsString($fileContents, $commandTester->getDisplay());
    }

    public function testExecuteLogNotFound(): void
    {
        $nonExistentFilePath = '/none/existent/file.log';

        $sut = new ReadLogsCommand($nonExistentFilePath);

        $application = new Application();
        $application->add($sut);

        $commandTester = new CommandTester($sut);
        $commandTester->execute([]);

        $this->assertStringContainsString('was not found', $commandTester->getDisplay());
    }

    /**
     * Use VfsStream to not write to file system.
     */
    private function getVirtualTestLogFilePath(string $fileContents): string
    {
        $vfsRoot = vfsStream::setup(self::VFS_ROOT_DIRECTORY);

        $fileName = 'basket.txt';
        vfsStream::newFile($fileName, 0755)
            ->withContent($fileContents)
            ->at($vfsRoot);

        $this->assertTrue($vfsRoot->hasChild($fileName));
        $this->assertSame($fileContents, $vfsRoot->getChild($fileName)->getContent());

        return vfsStream::url(self::VFS_ROOT_DIRECTORY . DIRECTORY_SEPARATOR . $fileName);
    }
}
