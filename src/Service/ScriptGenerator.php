<?php
namespace RconManager\Service;

use Laminas\ServiceManager\ServiceManager;
use RconManager\ScriptGenerator\Ark;
use RconManager\ScriptGenerator\ScriptGenerator as ScriptGeneratorInterface;
use RconManager\ScriptGenerator\VRising;
use RuntimeException;

class ScriptGenerator
{
    protected $generators = [
        RconService::SERVER_TYPE_VRISING => [
            VRising::class,
        ],
        RconService::SERVER_TYPE_ARK => [
            Ark::class,
        ],
    ];

    public function __construct(
        protected Config $config,
        protected ServiceManager $container
    ) {
    }

    public function addGenerator(string $serverType, string $generatorClass)
    {
        $this->generators[$serverType][] = $generatorClass;
    }

    public function generate(string $server)
    {
        $serverInfo = $this->config->getServerConfig($server);
        if (! isset($serverInfo['type'])) {
            throw new RuntimeException(sprintf('No server type specified for server %s', $server));
        }
        $generators = $this->generators[$serverInfo['type']] ?? [];
        foreach ($generators as $generatorClass) {
            /** @var ScriptGeneratorInterface $generator */
            $generator = $this->container->get($generatorClass);
            if (! $generator instanceof ScriptGeneratorInterface) {
                throw new RuntimeException(sprintf('Invalid generator "%s"', $generatorClass));
            }
            $generator->generate($server);
        }
    }
}