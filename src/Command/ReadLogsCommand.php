<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ReadLogsCommand extends Command
{
    private const COMMAND_NAME = 'oe:moduletemplate:read-log-file';
    private const COMMAND_DESCRIPTION = 'Log file reader.';
    private const COMMAND_HELP = 'Reads log file and outputs content.';
    private const LOG_FILE_CONTENT = 'Log file content:';
    public const LOG_FILE_ERROR = '<error>Log file - %s was not found</error>';

    public function __construct(private string $basketLogFilePath)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName(self::COMMAND_NAME)
            ->setDescription(self::COMMAND_DESCRIPTION)
            ->setHelp(self::COMMAND_HELP);
    }

    /** @SuppressWarnings(PHPMD.UnusedFormalParameter) */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (is_file($this->basketLogFilePath)) {
            $fileContents = ((file_get_contents($this->basketLogFilePath))) ?: '';
            $output->writeln(self::LOG_FILE_CONTENT);
            $output->writeln($fileContents);

            return Command::SUCCESS;
        }

        $output->writeln(sprintf(self::LOG_FILE_ERROR, $this->basketLogFilePath));

        return Command::SUCCESS;
    }
}
