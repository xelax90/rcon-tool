<?php
namespace RconManager\Service;

use RconManager\ServerCommand\Command;
use RconManager\ServerScripts\ServerScriptInterface;
use ReflectionObject;
use RuntimeException;
use SteamCondenser\Servers\SourceServer;
use xPaw\SourceQuery\SourceQuery;

class RconService
{
    const SERVER_TYPE_VRISING = 'vrising';
    const SERVER_TYPE_ARK = 'ark';
    const SERVER_TYPE_PALWORLD = 'palworld';

    /** @var SourceQuery[] */
    protected $sourceConnections = [];

    public function __construct(
        protected Config $config
    ) {
    }

    public function getServers()
    {
        return $this->config->getServers();
    }

    public function connect(string $server): SourceQuery
    {
        if (! isset($this->sourceConnections[$server])) {
            $this->sourceConnections[$server] = new SourceQuery();
        }
        if (! $this->sourceQueryIsConnected($this->sourceConnections[$server])) {
            $serverInfo = $this->config->getServerConfig($server);
            $rcon = $this->sourceConnections[$server];
            $rcon->Connect(
                $serverInfo['host'],
                $serverInfo['port'],
                $this->config->getConfig()['rcon']['timeout'] ?? 3,
                SourceQuery::SOURCE
            );
            $rcon->SetRconPassword($serverInfo['password']);
        }
        return $this->sourceConnections[$server];
    }

    protected function sourceQueryIsConnected(SourceQuery $rcon)
    {
        $r = new ReflectionObject($rcon);
        $p = $r->getProperty('Connected');
        $p->setAccessible(true);
        return $p->getValue($rcon);
    }

    public function disconnect(string $server)
    {
        if (isset($this->sourceConnections[$server])) {
            $this->sourceConnections[$server]->Disconnect();
        }
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

        $script->run($server);
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
        $response = $rcon->Rcon($execCommand);
        if (! $command->validateResponse($response)) {
            throw new RuntimeException(sprintf('Command "%s" failed with response "%s"', $execCommand, $response));
        }
        return $response;
    }
}