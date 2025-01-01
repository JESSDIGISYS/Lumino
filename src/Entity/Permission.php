<?php

namespace Lumino\Entity;

use JDS\Dbal\Entity;

class Permission extends Entity
{
    public function __construct(
        private string $name,
        private string $description,
        private int $bitwise,
        private int $position,
        private bool $active,
        private ?int $id = null,
        private ?string $permission_id = null

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
        ?string $permission_id = null

    ): self
    {
        return new self($name, $description, $bitwise, $position, $active, $id, $permission_id);
    }

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

    public function getPermissionId(): ?string
    {
        return $this->permission_id;
    }

    public function setPermissionId(?string $permission_id): self
    {
        $this->permission_id = $permission_id;
        return $this;
    }
}

