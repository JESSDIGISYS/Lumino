<?php

use Doctrine\DBAL\Connection;
use JDS\Dbal\GenerateNewId;

return new class
{
	public function up(string $migration, ?Connection $connection): void
	{
        $sql = "CREATE TABLE IF NOT EXISTS users (
            id int(12) NOT NULL AUTO_INCREMENT,
            user_id varbinary(12) NOT NULL,
            firstname varchar(35) NOT NULL,
            lastname varchar(35) NOT NULL,
            email varchar(115) NOT NULL,
            password varchar(255) NOT NULL,
            changepass boolean NOT NULL DEFAULT false,
            active boolean NOT NULL DEFAULT true,
            lastpasschanged datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
            phone varchar(25) NOT NULL,
            deleteuser boolean NOT NULL DEFAULT false,
            carrier varchar(75) NOT NULL,
            created datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated datetime NOT NULL DEFAULT '1900-01-01 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (user_id),
            UNIQUE KEY id (id),
            UNIQUE KEY email (email),
            KEY firstname (firstname),
            KEY lastname (lastname),
            KEY active (active),
            KEY phone (phone),
            KEY deleteuser (deleteuser)
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
        $sql = "DROP TABLE IF EXISTS users; ";

        if (!is_null($connection)) {
            $connection->executeQuery($sql);
            echo '"down" method finished for  "' . rtrim($migration, '.ph') . '"!' . PHP_EOL;
        } else {
            echo 'No CONNECTION established! ERROR' . PHP_EOL;
        }
	}
};
