<?php

namespace Lumino\Repository;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\ParameterType;
use JDS\Authentication\AuthRepositoryInterface;
use JDS\Authentication\AuthUserInterface;
use JDS\Dbal\AbstractRepository;
use JDS\Http\NotFoundException;
use Lumino\Entity\User;

class UserRepository extends AbstractRepository implements AuthRepositoryInterface
{

    public function __construct(private Connection $connection)
    {
    }

    public function findByEmail(string $email): ?AuthUserInterface
    {
        $sql = "SELECT
                    id, user_id, email, password, firstname, lastname, phone 
                FROM 
                    users 
                WHERE 
                    email = :email
        ";

        $stmt = $this->connection->prepare($sql);
        $this->bind($stmt, 'email', $email, ParameterType::STRING);
        $row = $this->connection->executeQuery()->fetchAssociative();

        if (!$row) {
            return null;
        }

        $user = User::create(
            $row['email'],
            $row['password'],
            $row['firstname'],
            $row['lastname'],
            $row['phone'],
            $row['id'],
            $row['user_id']
        );

        return $user;
    }

    public function findOrFail(string $userId): User
    {
      $user = $this->findByUserId($userId);
      if (!$user) {
          throw new NotFoundException(sprintf("User '%s' not found.", $userId));
      }
      return $user;
    }

    /**
     * @throws Exception
     */
    public function findByUserId(string $userId): ?User
    {
        $sql = "SELECT
                    id, user_id, email, password, firstname, lastname, phone 
                FROM 
                    users 
                WHERE 
                    user_id = :user_id
        ";
        $stmt = $this->connection->prepare($sql);
        $this->bind($stmt, 'user_id', $userId, ParameterType::STRING);
        $row = $this->connection->executeQuery()->fetchAssociative();

        if (!$row) {
            return null;
        }

        $user = User::create(
            $row['email'],
            $row['password'],
            $row['firstname'],
            $row['lastname'],
            $row['phone'],
            $row['id'],
            $row['user_id']
        );

        return $user;
    }
}

