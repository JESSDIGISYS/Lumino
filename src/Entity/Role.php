<?php

namespace Lumino\Entity;

use JDS\Dbal\Entity;

class Role extends Entity
{

    public function __construct(
        private string $name,
        private string $description,
        private int $bitwise,
        private int $position,
        private bool $active,
        private ?int $id = null,
        private ?string $role_id = null
    )
    {
    }

    public static function create(
        string $name,
        string $description,
        int $bitwise,
        int $position,
        bool $active,
        ?int $id = null,
        ?string $role_id = null
    ): self
    {
        return new self(
            $name,
            $description,
            $bitwise,
            $position,
            $active,
            $id,
            $role_id
        );
    }

    private array $permissions = [];
    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getBitwise(): int
    {
        return $this->bitwise;
    }

    public function setBitwise(int $bitwise): self
    {
        $this->bitwise = $bitwise;
        return $this;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;
        return $this;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;
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

    public function getRoleId(): ?string
    {
        return $this->role_id;
    }

    public function setRoleId(?string $role_id): self
    {
        $this->role_id = $role_id;
        return $this;
    }

    public function getPermissions(): array
    {
        return $this->permissions;
    }

    public function setPermissions(array $permissions): void
    {
        foreach ($permissions as $permission) {
            if (!in_array($permission, $this->permissions)) {
                $this->permissions[] = $permission;
            }

        }
    }
}

