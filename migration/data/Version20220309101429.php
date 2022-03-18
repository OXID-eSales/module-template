<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220309101429 extends AbstractMigration
{
    //The migration done here extends the shop's oxuser table by a new field
    //NOTE: write migrations so that they can be run multiple times without breaking anything.
    //      Means: check if changes are already present before actually modifying a table
    public function up(Schema $schema): void
    {
        $this->connection->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

        //extend the oxuser table
        $customerTable = $schema->getTable('oxuser');
        if (!$customerTable->hasColumn('OETMGREETING')) {
            $this->addSql("ALTER TABLE `oxuser` ADD COLUMN `OETMGREETING`
                 varchar(254) NOT NULL DEFAULT '' COMMENT 'OETM personal greeting';
            ");
        }
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}
