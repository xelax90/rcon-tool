<?php
namespace RconManager\ServerScripts\Ark;

use RconManager\ServerCommand\Ark\DoExit;
use RconManager\ServerCommand\Ark\SaveWorld;
use RconManager\ServerCommand\Ark\ServerChat;
use RconManager\ServerCommand\Ark\ServerChatWithTemplate;
use RconManager\Service\Config;
use RconManager\Utils\intervalToString;
use Thedudeguy\Rcon;

class StopServer extends AbstractScript
{
    public function __construct(protected Config $config)
    {
    }

    public function run(Rcon $rcon): void
    {
        $config = $this->config->getConfig()['scripts']['shutdown'];
        
        $messageIntervals = $config['intervals'];
        rsort($messageIntervals, SORT_NUMERIC);

        $this->runCommand($rcon, new SaveWorld());

        $messageCommand = new ServerChatWithTemplate('Server shutdown in %s');
        for ($i = 0; $i < count($messageIntervals); $i++) {
            $currentInterval = $messageIntervals[$i];
            $nextInterval = $messageIntervals[$i+1] ?? 0;
            $this->runCommand($rcon, $messageCommand, intervalToString::compute($currentInterval));

            $diff = $currentInterval - $nextInterval;
            sleep($diff);
        }

        $this->runCommand($rcon, new SaveWorld());
        $this->runCommand($rcon, new ServerChat(sprintf('SHUTDOWN')));
        sleep(5);
        // $this->runCommand($rcon, new DoExit());
    }
}
