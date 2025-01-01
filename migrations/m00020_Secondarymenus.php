<?php

use Doctrine\DBAL\Connection;
use JDS\Dbal\GenerateNewId;

return new class
{
	public function up(string $migration, ?Connection $connection): void
	{
        $sql = "CREATE TABLE IF NOT EXISTS secondarymenus (
                id varbinary(12) NOT NULL AUTO_INCREMENT,
                secondarymenu_id varbinary(12) NOT NULL,
                name varchar(20) NOT NULL,
                url varchar(255) NOT NULL,
                controller varchar(255) NOT NULL DEFAULT '',
                method varchar(35) NOT NULL DEFAULT '',
                action varchar(100) NOT NULL DEFAULT '',
                middleware text NOT NULL DEFAULT '',
                noclick boolean NOT NULL DEFAULT false COMMENT 'True: DO NOT ALLOW clicking on the URL. False: Allow clicking on the URL.',
                bitwise bigint unsigned NOT NULL COMMENT '1,2,4,8,16,32,64,128, etc.',
                position tinyint(4) NOT NULL DEFAULT 24 COMMENT '0,1,2,3,4,...,5,10,15,20,etc. Max 24',
                visible boolean NOT NULL DEFAULT true,
                created datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                updated datetime NOT NULL DEFAULT '1900-01-01 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (secondarymenu_id),
                UNIQUE KEY id (id),
                KEY name (name),
                KEY url (url),
                KEY controller (controller),
                KEY method (method),
                KEY position (position),
                KEY bitwise (bitwise),
                KEY visible (visible)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Part of the Lumino Demo Database'; ";

        if (!is_null($connection)) {
            $connection->executeQuery($sql);
            echo '"up" method finished for  "' . rtrim($migration, '.ph') . '"!' . PHP_EOL;
        } else {
            echo 'No CONNECTION established! ERROR' . PHP_EOL;
        }
	}

 	public function down(string $migration, ?Connection $connection): void
	{
        $sql = "DROP TABLE IF EXISTS secondarymenus; ";

        if (!is_null($connection)) {
            $connection->executeQuery($sql);
            echo '"down" method finished for  "' . rtrim($migration, '.ph') . '"!' . PHP_EOL;
        } else {
            echo 'No CONNECTION established! ERROR' . PHP_EOL;
        }
	}
};
