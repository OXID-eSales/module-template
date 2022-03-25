<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tests\Unit\Core;

use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use OxidEsales\Eshop\Core\Config;
use OxidEsales\Eshop\Core\Registry as EshopRegistry;
use OxidEsales\ModuleTemplate\Core\TmpCleaner;
use OxidEsales\TestingLibrary\UnitTestCase;

/**
 * NOTE: using a virtual stream wrapper takes a lot away from the PITA of testing a file system.
 */
final class TmpCleanerTest extends UnitTestCase
{
    public function testSomething(): void
    {
        /** @var vfsStreamDirectory $vfsStreamDirectory */
        $vfsStreamDirectory = $this->prepareDirectory();

        //doublecheck setup
        $this->assertSame(5, count($vfsStreamDirectory->getChild('root/tmp')->getChildren()));
        $this->assertTrue($vfsStreamDirectory->hasChild('root/tmp/smarty'));
        $smartyDirectoryContent = $vfsStreamDirectory->getChild('root/tmp/smarty')->getChildren();
        $this->assertSame('some_tpl_content', $smartyDirectoryContent[0]->getContent());

        $config = $this->getMockBuilder(Config::class)
            ->getMock();
        $config->expects($this->once())
            ->method('getConfigParam')
            ->with($this->equalTo('sCompileDir'))
            ->willReturn(vfsStream::url($vfsStreamDirectory->path() . '/tmp'));
        EshopRegistry::set(Config::class, $config);

        $cleaner = new TmpCleaner();
        $cleaner->clearTmp();

        //check what's left
        $this->assertTrue($vfsStreamDirectory->hasChild('root/tmp/smarty'));
        $this->assertEmpty($vfsStreamDirectory->getChild('root/tmp/smarty')->getChildren());

        $this->assertSame(3, count($vfsStreamDirectory->getChild('root/tmp')->getChildren()));
    }

    private function prepareDirectory(): VfsStreamDirectory
    {
        $files = [
            'schema.txt',
            '.htaccess',
            '.gitkeep',
            '.gitignore',
        ];

        $tree = [
            'tmp' => [
                'smarty' => [
                    'some_tpl_content',
                ],
            ],
        ];

        $vfsStreamDirectory = vfsStream::setup('root', 777);
        vfsStream::create($tree, $vfsStreamDirectory);

        foreach ($files as $name) {
            $file = vfsStream::newFile($name);
            $vfsStreamDirectory->getChild('tmp')->addChild($file);
        }

        return $vfsStreamDirectory;
    }
}
