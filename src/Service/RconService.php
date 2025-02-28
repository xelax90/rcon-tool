<?php
namespace RconManager\Service;

use RconManager\ServerCommand\Command;
use RconManager\ServerScripts\ServerScriptInterface;
use RuntimeException;
use SteamCondenser\Servers\SourceServer;
use Thedudeguy\Rcon;

class RconService
{
    const SERVER_TYPE_VRISING = 'vrising';
    const SERVER_TYPE_ARK = 'ark';
    const SERVER_TYPE_PALWORLD = 'palworld';

    protected $connections = [];

    public function __construct(
        protected Config $config
    ) {
    }

    public function getServers()
    {
        return $this->config->getServers();
    }

    public function connect(string $server): Rcon
    {
        if (! isset($this->connections[$server])) {
            $serverInfo = $this->config->getServerConfig($server);
            $rcon = new Rcon(
                $serverInfo['host'],
                $serverInfo['port'],
                $serverInfo['password'],
                $this->config->getConfig()['rcon']['timeout'] ?? 3
            );
            if (! @$rcon->connect()) {
                throw new RuntimeException(sprintf('Failed to connect to server %s', $server));
            }
            $this->connections[$server] = $rcon;
        }
        return $this->connections[$server];
    }

    public function connectSteam(string $server)
    {
        $serverInfo = $this->config->getServerConfig($server);
        if (! isset($serverInfo['steamQeryPort'])) {
            throw new RuntimeException(sprintf('No steam query port specified for server %s', $server));
        }

        $server = new SourceServer($serverInfo['host'], $serverInfo['steamQeryPort']);
        $server->initialize();
        return $server;
    }

    public function runScript(string $server, ServerScriptInterface $script)
    {
        $serverInfo = $this->config->getServerConfig($server);
        if (! isset($serverInfo['type'])) {
            throw new RuntimeException(sprintf('No server type specified for server %s', $server));
        }
        if (! $script->serverTypeIsSupported($serverInfo['type'])) {
            throw new RuntimeException(sprintf('Server type %s is not supported by script "%s"', $serverInfo['type'], get_class($script)));
        }

        $rcon = $this->connect($server);
        $script->run($rcon);
    }

    public function runCommand(string $server, Command $command, ...$arguments)
    {
        $serverInfo = $this->config->getServerConfig($server);
        if (! isset($serverInfo['type'])) {
            throw new RuntimeException(sprintf('No server type specified for server %s', $server));
        }
        if (! $command->serverTypeIsSupported($serverInfo['type'])) {
            throw new RuntimeException(sprintf('Server type %s is not supported by command "%s"', $serverInfo['type'], get_class($command)));
        }

        $rcon = $this->connect($server);
        $execCommand = $command->getRconCommand(...$arguments);
        $response = $rcon->sendCommand($execCommand);
        if (! $command->validateResponse($response)) {
            throw new RuntimeException(sprintf('Command "%s" failed with response "%s"', $execCommand, $response));
        }
        return $response;
    }
}