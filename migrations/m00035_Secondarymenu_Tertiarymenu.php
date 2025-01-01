<?php

use Doctrine\DBAL\Connection;
use JDS\Dbal\GenerateNewId;

return new class
{
	public function up(string $migration, ?Connection $connection): void
	{
        $sql = "CREATE TABLE IF NOT EXISTS secondarymenu_tertiarymenu (
                id int(12) NOT NULL AUTO_INCREMENT,
                secondarymenu_id varbinary(12) NOT NULL,
                tertiarymenu_id varbinary(12) NOT NULL,
                PRIMARY KEY (secondarymenu_id, tertiarymenu_id),
                UNIQUE KEY id (id)
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
        $sql = "";

        if (!is_null($connection)) {
            $connection->executeQuery($sql);
            echo '"down" method finished for  "' . rtrim($migration, '.ph') . '"!' . PHP_EOL;
        } else {
            echo 'No CONNECTION established! ERROR' . PHP_EOL;
        }
	}
};
