<?php
declare(strict_types=1);

use JDS\Http\Kernel;
use JDS\Http\Request;

define('BASE_PATH', dirname(__DIR__));
define('BASE_PUBLIC', BASE_PATH . '/public');

require_once BASE_PATH . '/vendor/autoload.php';
$container = require BASE_PATH . '/config/services.php';

require BASE_PATH . '/bootstrap/bootstrap.php';

$request = Request::createFromGlobals();

$kernel = $container->get(Kernel::class);

$response = $kernel->handle($request);
$response->send();

$kernel->terminate($request, $response);








