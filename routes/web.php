<?php
// Route Definition
// method is either GET or POST
// [method, path, [controller, method, <optional> [Middleware], [label, root path (null if no root), position, role, permission]]
// role is bitwise [1, 2, 4, 8, 16, 32, 64, etc.]
// permission is bitwise [1, 2, 4, 8, 16, 32, 64, etc.]
// sample use of associative array to generate menus
// [label, root path (null if no root), position, role, permission]
// ['home' => 'Home', 'parent' => null, 'position' => 0, 'role' => 0, 'permission' => 1]
// role = [0 = Admin, 9 = public]

use Lumino\Controller\HomeController;

return [
    ['GET', '/', [HomeController::class, 'index'], ['Home', null, 9, 1]],
    ['GET', '/login', [LoginController::class, 'index', [MyGuest::class]], ['Login', null, 9, 1]], # this has a middleware
    ['POST', 'login', [\Lumino\Controller\LoginController::class, 'login']]
];