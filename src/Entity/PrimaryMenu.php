<?php

namespace Lumino\Entity;

use JDS\Dbal\Entity;

class PrimaryMenu extends Entity
{

    public function __construct(
        private string $name,
        private string $url,
        private string $controller,
        private string $method,
        private string $action,
        private string $middleware,
        private bool $noClick,
        private int $bitwise,
        private int $position,
        private bool $visible,
        private ?int $id = null,
        private ?string $primaryMenu_id = null
    )
    {
    }

    private array $secondaryMenus = [];
    private array $roles = [];

    public static function create(
        string $name,
        string $url,
        string $controller,
        string $method,
        string $action,
        string $middleware,
        bool $noClick,
        int $bitwise,
        int $position,
        bool $visible,
        ?int $id = null,
        ?string $primaryMenu_id = null
    ): self
    {
        return new self(
            $name,
            $url,
            $controller,
            $method,
            $action,
            $middleware,
            $noClick,
            $bitwise,
            $position,
            $visible,
            $id,
            $primaryMenu_id
        );
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

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;
        return $this;
    }

    public function getController(): string
    {
        return $this->controller;
    }

    public function setController(string $controller): self
    {
        $this->controller = $controller;
        return $this;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function setMethod(string $method): self
    {
        $this->method = $method;
        return $this;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function setAction(string $action): self
    {
        $this->action = $action;
        return $this;
    }

    public function getMiddleware(): string
    {
        return $this->middleware;
    }

    public function setMiddleware(string $middleware): self
    {
        $this->middleware = $middleware;
        return $this;
    }

    public function isNoclick(): bool
    {
        return $this->noClick;
    }

    public function setNoclick(bool $noClick): self
    {
        $this->noClick = $noClick;
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

    public function isVisible(): bool
    {
        return $this->visible;
    }

    public function setVisible(bool $visible): self
    {
        $this->visible = $visible;
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

    public function getPrimaryMenuId(): ?string
    {
        return $this->primaryMenu_id;
    }

    public function setPrimaryMenuId(?string $primaryMenu_id): self
    {
        $this->primaryMenu_id = $primaryMenu_id;
        return $this;
    }

    public function getSecondaryMenus(): array
    {
        return $this->secondaryMenus;
    }

    public function setSecondaryMenus(array $secondaryMenus): self
    {
        foreach ($secondaryMenus as $secondaryMenu) {
            if (!in_array($secondaryMenu, $this->secondaryMenus)) {
                $this->secondaryMenus[] = $secondaryMenu;
            }
        }
        return $this;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }
    public function setRoles(array $roles): self
    {
        foreach ($roles as $role) {
            if (!in_array($role, $this->roles)) {
                $this->roles[] = $role;
            }
        }
        return $this;
    }

}

