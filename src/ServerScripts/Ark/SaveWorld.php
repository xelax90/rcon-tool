<?php
namespace RconManager\ServerScripts\Ark;

use RconManager\ServerCommand\Ark\SaveWorld as SaveWorldCommand;
use RconManager\ServerCommand\Ark\ServerChat;
use RconManager\Service\Config;
use RconManager\Service\RconService;
use xPaw\SourceQuery\SourceQuery;

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
