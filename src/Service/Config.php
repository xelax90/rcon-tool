<?php
namespace RconManager\Service;

use InvalidArgumentException;

class Config
{
    protected $config;

    public function __construct()
    {
    }

    public function getConfig() {
        if ($this->config === null) {
            $this->config = require __DIR__ . '/../../config/config.php';
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