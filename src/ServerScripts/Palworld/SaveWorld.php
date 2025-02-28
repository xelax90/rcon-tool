<?php
namespace RconManager\ServerScripts\Palworld;

use RconManager\ServerCommand\Palworld\SaveWorld as SaveWorldCommand;
use RconManager\ServerCommand\Palworld\ServerChat;
use RconManager\Service\Config;
use RconManager\Service\RconService;

class SaveWorld extends AbstractScript
{
    public function __construct(
        protected Config $config,
        RconService $rconService
    ) {
        parent::__construct($rconService);
    }

    public function run(string $server): void
    {
        $config = $this->config->getConfig()['scripts']['saveworld'];
        
        if ($config['showMessage'] ?? false) {
            $message = $config['message'] ?? 'A world save is about to be performed';
            $this->rconService->runCommand($server, new ServerChat($message));
            sleep($config['messageLeadTime'] ?? 10);
        }

        $this->rconService->runCommand($server, new SaveWorldCommand());
    }
}
