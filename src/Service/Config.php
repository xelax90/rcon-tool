<?php
namespace RconManager\Service;

use InvalidArgumentException;
use Laminas\ConfigAggregator\ConfigAggregator;
use Laminas\ConfigAggregator\PhpFileProvider;

class Config
{
    protected $config;

    public function __construct()
    {
    }

    public function getConfig() {
        if ($this->config === null) {
            $aggregator = new ConfigAggregator([
                new PhpFileProvider(__DIR__ . '/../../config/*.php'),
            ]);
            $this->config = $aggregator->getMergedConfig();
        }
        return $this->config;
    }

    public function getServers()
    {
        $servers = $this->getConfig()['rcon_servers'] ?? [];
        return array_keys($servers);
    }

    public function getServerConfig(string $server): array
    {
        $config = $this->getConfig()['rcon_servers'][$server] ?? null;
        if (! $config) {
            throw new InvalidArgumentException(sprintf('Unknown Server %s', $server));
        }
        return $config;
    }
}