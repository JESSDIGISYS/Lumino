<?php

namespace Lumino\Entity;

use JDS\Authentication\AuthUserInterface;
use JDS\Dbal\Entity;

class User extends Entity implements AuthUserInterface
{
    private array $roles = [];

    public function __construct(
        private string $email,
        private string $password,
        private string $firstname,
        private string $lastname,
        private string $phone,
        private ?int $id = null,
        private ?string $user_id = null,

    )
    {
    }

    public static function create(
        string $email,
        string $password,
        string $firstname,
        string $lastname,
        string $phone,
        ?int $id = null,
        ?string $user_id = null,
    ): self
    {
        return new self($email, $password, $firstname, $lastname, $phone, $id, $user_id);
    }


    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;
        return $this;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;
        return $this;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getUserId(): ?string
    {
        return $this->user_id;
    }

    public function setUserId(?string $user_id): self
    {
        $this->user_id = $user_id;
        return $this;
    }

    public function getAuthId(): int|string
    {
        return $this->getUserId();
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setRoles(array $roles): void
    {
        foreach ($roles as $role) {
            if (!in_array($role, $this->roles)) {
                $this->roles[] = $role;
            }
        }
    }

    public function getRoles(): array
    {
        return $this->roles;
    }
}

