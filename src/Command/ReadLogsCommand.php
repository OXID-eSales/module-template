<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Command;

use OxidEsales\ModuleTemplate\Utility\Context;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ReadLogsCommand extends Command
{
    private const COMMAND_NAME = 'oe:moduletemplate:read-log-file';
    private const COMMAND_DESCRIPTION = 'Log file reader.';
    private const COMMAND_HELP = 'Reads log file and outputs content.';
    private const LOG_FILE_CONTENT = 'Log file content:';
    private const LOG_FILE_ERROR = '<error>Log file - %s was not found</error>';

    protected function configure()
    {
        $this->setName(self::COMMAND_NAME)
            ->setDescription(self::COMMAND_DESCRIPTION)
            ->setHelp(self::COMMAND_HELP);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filePath = Context::getBasketLogFilePath();
        if (file_exists($filePath)) {
            $fileContents = file_get_contents($filePath);
            $output->writeln(self::LOG_FILE_CONTENT);
            $output->writeln($fileContents);
        } else {
            $output->writeln(sprintf(self::LOG_FILE_ERROR, $filePath));
        }

        return Command::SUCCESS;
    }
}