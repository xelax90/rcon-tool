#!/usr/bin/env php
<?php
namespace RconManager;

chdir (__DIR__);
require __DIR__ . '/vendor/autoload.php';

use Laminas\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;
use Laminas\ServiceManager\ServiceManager;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\CommandLoader\ContainerCommandLoader;

$container = new ServiceManager([
    'factories' => [
        Service\ScriptGenerator::class => Service\Factory\ScriptGeneratorFactory::class,
    ],
    'abstract_factories' => [
        ReflectionBasedAbstractFactory::class,
    ]
]);

$application = new Application();
$application->setCommandLoader(new ContainerCommandLoader($container, [
    'rcon:list-servers' => Command\ListServersCommand::class,
    'rcon:generate-scripts' => Command\GenerateScriptsCommand::class,
    'rcon:check-update' => Command\CheckUpdateCommand::class,
    'rcon:check-is-running' => Command\CheckServerRunning::class,
    'rcon:ark:list-players' => Command\Ark\ListPlayersCommand::class,
    'rcon:ark:stop-server' => Command\Ark\StopServerCommand::class,
    'rcon:vrising:cancel-shutdown' => Command\VRising\CancelShutdownCommand::class,
    'rcon:ark:saveworld' => Command\Ark\SaveWorldCommand::class,
    'rcon:vrising:stop-server' => Command\VRising\StopServerCommand::class,
    'rcon:vrising:list-players' => Command\VRising\ListPlayersCommand::class,
    'rcon:vrising:init-local-server' => Command\VRising\InitLocalServerCommand::class,
]));

$application->run();
