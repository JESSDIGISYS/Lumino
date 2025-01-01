<?php

use Doctrine\DBAL\Connection;
use JDS\Dbal\GenerateNewId;

return new class
{
	public function up(string $migration, ?Connection $connection): void
	{
        $sql = "CREATE TABLE IF NOT EXISTS permissions (
                id int(12) NOT NULL AUTO_INCREMENT,
                permission_id varbinary(12) NOT NULL,
                name varchar(25) NOT NULL,
                description varchar(255) NOT NULL,
                bitwise bigint unsigned NOT NULL COMMENT '1,2,4,8,16,32,64,128, etc.',
                position tinyint(4) NOT NULL DEFAULT 24 COMMENT '0,1,2,3,4,5,6,7,8,9,10, etc. Max 24',
                active boolean NOT NULL DEFAULT true COMMENT 'Ability to show or hide when necessary',
                created datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                updated datetime NOT NULL DEFAULT '1900-01-01 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (permission_id),
                UNIQUE KEY id (id),
                KEY name (name),
                KEY bitwise (bitwise),
                KEY p_order (p_order),
                KEY active (active)
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
        $sql = "DROP TABLE IF EXISTS permissions;";

        if (!is_null($connection)) {
            $connection->executeQuery($sql);
            echo '"down" method finished for  "' . rtrim($migration, '.ph') . '"!' . PHP_EOL;
        } else {
            echo 'No CONNECTION established! ERROR' . PHP_EOL;
        }
	}
};
