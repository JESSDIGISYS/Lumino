<?php

use Doctrine\DBAL\Connection;
use Freelance\Template\TwigFactory;
use JDS\Console\Application;
use JDS\Console\Command\MigrateDatabase;
use JDS\Controller\AbstractController;
use JDS\Dbal\ConnectionFactory;
use JDS\Dbal\GenerateNewId;
use JDS\Dbal\MenuServiceInterface;
use JDS\EventDispatcher\EventDispatcher;
use JDS\Http\Kernel;
use JDS\Http\Middleware\Jwt\JwtAuthenticate;
use JDS\Http\Middleware\RequestHandler;
use JDS\Http\Middleware\RequestHandlerInterface;
use JDS\Routing\Router;
use JDS\Routing\RouterInterface;
use JDS\Session\Session;
use JDS\Session\SessionInterface;
use JDS\Templates\TwigFactoryInterface;
use League\Container\Argument\Literal\ArrayArgument;
use League\Container\Argument\Literal\BooleanArgument;
use League\Container\Argument\Literal\StringArgument;
use League\Container\Container;
use League\Container\ReflectionContainer;
use Lumino\Generators\BreadcrumbGenerator;
use Lumino\Generators\MenuGenerator;
use Lumino\Provider\LocationServiceProvider;
use Lumino\Repository\UserRepository;

$allowedEnv = ['dev', 'prod', 'test', 'testing'];

// change all the \ to / in the path
$basePath = str_replace("\\", "/", dirname(__DIR__));
$dotenv = new Symfony\Component\Dotenv\Dotenv();
$dotenv->loadEnv($basePath . '/.env');

$container = new Container();
$dbPrefix = $_ENV['DB_PREFIX'];
$container->delegate(new ReflectionContainer());

// parameters for application config
$container->add('basePath', new StringArgument($basePath));

// set up local variables to use
$container->add('routePath', new StringArgument($_ENV['ROUTE_PATH']));

$container->add('initializePath', new StringArgument($basePath . '/bin'));
$routes = include($basePath . '/routes/web.php');
$states = include($basePath . '/routes/states.php');

$appEnv = $_ENV['APP_ENV'];
if (!in_array($appEnv, $allowedEnv)) {
    throw new Exception('Invalid environment values. These are the only allowed values (' . implode(', ', $allowedEnv) . ')!');
}

$databaseDNS = [
    'driver' => $_ENV['DRIVER'],
    'dbname' => $_ENV['DBNAME'],
    'host' => $_ENV['HOST'],
    'user' => $_ENV['USER'],
    'password' => $_ENV['PASSWORD'],
    'port' => $_ENV['PORT'],
];

$templatesPath = $basePath . '/templates';

$container->add('APP_DEV', new StringArgument($appEnv));

$container->add('maintMode', new BooleanArgument($_ENV['MAINTENANCE_MODE'] === 'true'));

$container->add('jwtSecretKey', new StringArgument($_ENV['JWT_SECRET']));

$container->add(
    "base-commands-namespace",
    new StringArgument("JDS\\Console\\Command\\")
);

$container->add(
    RouterInterface::class,
    Router::class
);

$container->add(
    RequestHandlerInterface::class,
    RequestHandler::class
)->addArgument($container);

$container->addShared(EventDispatcher::class);

$container->add(JDS\Http\Kernel::class)
    ->addArguments([
        $container,
        RequestHandlerInterface::class,
        EventDispatcher::class
    ]);

$container->addShared(
    SessionInterface::class,
    Session::class
);

$container->add(TwigFactoryInterface::class, TwigFactory::class)
    ->addArguments([
        SessionInterface::class,
        new StringArgument($templatesPath),
        new StringArgument($container->get('routePath')),
        new BooleanArgument($container->get('maintMode'))
    ]);

$container->add('template-renderer-factory', TwigFactoryInterface::class)
    ->addArgument([
        SessionInterface::class,
        new StringArgument($templatesPath),
        new StringArgument($container->get('routePath')),
]);

$container->addShared('twig', function () use ($container) {
    return $container->get('template-renderer-factory')->create();
});

$container->add(AbstractController::class);

$container->inflector(AbstractController::class)
    ->invokeMethod('setContainer', [$container]);

$container->add(ConnectionFactory::class)
    ->addArguments([$databaseDNS]);

$container->addShared(Connection::class, function () use ($container): Connection {
    return $container->get(ConnectionFactory::class)->create();
});

$container->add(Application::class)
    ->addArgument($container);

$container->add(\JDS\Console\Kernel::class)
    ->addArguments([$container, Application::class]);

$container->add('database:migrations:migrate', MigrateDatabase::class)
    ->addArguments([
        Connection::class,
        new StringArgument($basePath . '/migrations'),
        GenerateNewId::class
    ]);

$container->add(\JDS\Http\Middleware\RouterDispatch::class)
    ->addArguments([
        RouterInterface::class,
        $container
    ]);

$container->add(\JDS\Authentication\SessionAuthentication::class)
    ->addArguments([
        UserRepository::class,
        SessionInterface::class,
        $container->get('jwtSecretKey')
    ]);

$container->add(JwtAuthenticate::class)
    ->addArgument($container);

$container->add(MenuGenerator::class)
    ->addArgument(new ArrayArgument($routes));

$container->add(BreadcrumbGenerator::class)
    ->addArguments([
        new ArrayArgument($routes),
        new StringArgument($container->get('routePath'))
    ]);

$container->add(MenuServiceInterface::class);

$container->add(LocationServiceProvider::class);

$container->add('states', new ArrayArgument($container->get(LocationServiceProvider::class)->getStates()));
$container->add('countries', new ArrayArgument($container->get(LocationServiceProvider::class)->getCountries()));
$container->add('cities', new ArrayArgument($container->get(LocationServiceProvider::class)->getUSCities()));

return $container;

