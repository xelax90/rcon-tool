<?php
namespace RconManager\ServerScripts\Palworld;

use RconManager\ServerCommand\Palworld\SaveWorld as SaveWorldCommand;
use RconManager\ServerCommand\Palworld\ServerChat;
use RconManager\Service\Config;
use Thedudeguy\Rcon;

class SaveWorld extends AbstractScript
{
    public function __construct(protected Config $config)
    {
    }

    public function run(Rcon $rcon): void
    {
        $config = $this->config->getConfig()['scripts']['saveworld'];
        
        if ($config['showMessage'] ?? false) {
            $message = $config['message'] ?? 'A world save is about to be performed';
            $this->runCommand($rcon, new ServerChat($message));
            sleep($config['messageLeadTime'] ?? 10);
        }

        $this->runCommand($rcon, new SaveWorldCommand());
    }
}
