<?php

namespace Lumino\Generators;

use JDS\Routing\MenuGeneratorInterface;

class MenuGenerator implements MenuGeneratorInterface
{

    public function __construct(private array $routes)
    {
    }

    public function generateMenu(): array
    {
        $menu = [];

        foreach ($this->routes as $route) {
            $middleware = [];
            if ($route[0] === 'POST') {
                continue;
            }
            if ($route[0] === 'GET') {
                if (isset($route[2][2]) && is_array($route[2][2])) {
                    $middleware[] = $route[2][2];
                }
                $menu[] = [
                    'route' => $route[1],
                    'controller' => $route[2][0],
                    'method' => $route[2][1],
                    'middleware' => $middleware, # if no middleware it will be empty
                ];
                unset($middleware);
            }
        }
        return array_values($menu);
    }
}