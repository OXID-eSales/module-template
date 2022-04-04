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
final class Version20220321134600 extends AbstractMigration
{
    //The migration done here creates a new table
    //NOTE: write migrations so that they can be run multiple times without breaking anything.
    //      Means: check if changes are already present before actually creating a table
    public function up(Schema $schema): void
    {
        $this->connection->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

        //add module specific table. To be used with a shop model it needs OXID and TIMESTAMP columns.
        if (!$schema->hasTable('oetm_tracker')) {
            $this->addSql("CREATE TABLE `oetm_tracker` (
            `OXID` char(32) CHARACTER SET latin1 COLLATE latin1_general_ci  NOT NULL COMMENT 'Primary oxid',
            `OXSHOPID` int(11) NOT NULL DEFAULT '0' COMMENT 'Shop id (oxshops), value 0 in case no shop was specified',
            `OXUSERID` char(32) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL COMMENT 'Userid for this order',
            `OETMCOUNT` int(11) NOT NULL DEFAULT '0' COMMENT 'Greeting update count',
            `OXTIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Timestamp',
            PRIMARY KEY (`OXID`),
            UNIQUE KEY `OXMAINIDX` (`OXUSERID`,`OXSHOPID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
        }
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}
