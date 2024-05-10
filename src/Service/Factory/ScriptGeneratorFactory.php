<?php
namespace RconManager\Service\Factory;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;
use RconManager\Service\Config;
use RconManager\Service\ScriptGenerator;

class ScriptGeneratorFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, string $requestedName, ?array $options = null): mixed {
        return new ScriptGenerator(
            $container->get(Config::class),
            $container
        );
    }
}