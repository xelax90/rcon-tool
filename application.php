#!/usr/bin/env php
<?php
namespace RconManager;

require __DIR__ . '/vendor/autoload.php';

use Laminas\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;
use Laminas\ServiceManager\ServiceManager;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\CommandLoader\ContainerCommandLoader;

$container = new ServiceManager([
    'abstract_factories' => [
        ReflectionBasedAbstractFactory::class,
    ]
]);

$application = new Application();
$application->setCommandLoader(new ContainerCommandLoader($container, [
    'rcon:list-servers' => Command\ListServersCommand::class,
    'rcon:ark:stop-server' => Command\Ark\StopServerCommand::class,
    'rcon:ark:saveworld' => Command\Ark\SaveWorldCommand::class,
    'rcon:vrising:stop-server' => Command\VRising\StopServerCommand::class,
    'rcon:vrising:list-players' => Command\VRising\ListPlayersCommand::class,
]));

$application->run();
