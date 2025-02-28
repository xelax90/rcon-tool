<?php
namespace RconManager\ServerScripts\Palworld;

use RconManager\ServerCommand\Palworld\DoExit;
use RconManager\ServerCommand\Palworld\ListPlayers;
use RconManager\ServerCommand\Palworld\SaveWorld;
use RconManager\ServerCommand\Palworld\ServerChat;
use RconManager\ServerCommand\Palworld\ServerChatWithTemplate;
use RconManager\Service\Config;
use RconManager\Service\RconService;
use RconManager\Utils\intervalToString;

class StopServer extends AbstractScript
{
    protected bool $stopImmediately = false;

    public function __construct(
        protected Config $config,
        RconService $rconService
    ) {
        parent::__construct($rconService);
    }

    public function setStopImmediately(bool $stopImmediately): static
    {
        $this->stopImmediately = $stopImmediately;
        return $this;
    }

    public function run(string $server): void
    {
        $config = $this->config->getConfig()['scripts']['shutdown'];
        
        $stopImmediately = $this->stopImmediately;
        if (! $stopImmediately) {
            // Faster shutdown if no players are connected
            $playerList = trim($this->rconService->runCommand($server, new ListPlayers()));
            if ($playerList === 'No Players Connected') {
                $stopImmediately = true;
            }
        }

        if ($stopImmediately) {
            $messageIntervals = [];
        } else {
            $messageIntervals = $config['intervals'];
            rsort($messageIntervals, SORT_NUMERIC);
        }
        if (empty($messageIntervals)) {
            $messageIntervals = [10, 5, 4, 3, 2, 1];
        }

        $this->rconService->runCommand($server, new SaveWorld());
        $this->rconService->disconnect($server);

        $messageCommand = new ServerChatWithTemplate('Server shutdown in %s');
        for ($i = 0; $i < count($messageIntervals); $i++) {
            $currentInterval = $messageIntervals[$i];
            $nextInterval = $messageIntervals[$i+1] ?? 0;
            // Disconnect/Connect is required for long pauses between commands as it is otherwise closed by the server
            $this->rconService->connect($server);
            $this->rconService->runCommand($server, $messageCommand, intervalToString::compute($currentInterval));
            $this->rconService->disconnect($server);

            $diff = $currentInterval - $nextInterval;
            sleep($diff);
        }

        $this->rconService->connect($server);
        $this->rconService->runCommand($server, new ServerChat(sprintf('Final Saveworld 1')));
        $this->rconService->runCommand($server, new SaveWorld());
        sleep(5);
        $this->rconService->runCommand($server, new ServerChat(sprintf('Final Saveworld 2')));
        $this->rconService->runCommand($server, new SaveWorld());
        sleep(5);
        $this->rconService->runCommand($server, new ServerChat(sprintf('SHUTDOWN')));
        sleep(5);
        $this->rconService->runCommand($server, new DoExit());
    }
}
