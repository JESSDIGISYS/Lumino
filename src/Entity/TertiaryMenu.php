<?php

namespace Lumino\Entity;

use JDS\Dbal\Entity;

class TertiaryMenu extends Entity
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
        private ?string $tertiaryMenu_id = null
    )
    {
    }

}

