<?php
namespace RconManager\ServerScripts\VRising;

use RconManager\ServerCommand\VRising\AnnounceRestart;
use RconManager\ServerCommand\VRising\AnnounceWithTemplate;
use RconManager\ServerCommand\VRising\Shutdown;
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
        
        if ($this->stopImmediately) {
            $messageIntervals = [];
        } else {
            $messageIntervals = $config['intervals'];
            rsort($messageIntervals, SORT_NUMERIC);
        }
        if (empty($messageIntervals)) {
            $messageIntervals = [60, 30, 10];
        }
        if ($messageIntervals[0] < 60) {
            array_unshift($messageIntervals, 60);
        }

        $shutdownInitialized = false;

        $messageCommand = new AnnounceWithTemplate('Server restart in %s');
        for ($i = 0; $i < count($messageIntervals); $i++) {
            $currentInterval = $messageIntervals[$i];
            $nextInterval = $messageIntervals[$i+1] ?? 0;
            if (! $shutdownInitialized) {
                $restartMinutes = max(floor($currentInterval/60), 1);
                echo $this->rconService->runCommand($server, new Shutdown($restartMinutes, sprintf("Server will restart in %d minutes", $restartMinutes)));
                $shutdownInitialized = true;
            } elseif (($currentInterval % 60) == 0) {
                echo $this->rconService->runCommand($server, new AnnounceRestart($currentInterval / 60));
            } elseif ($currentInterval < 60) {
                echo $this->rconService->runCommand($server, $messageCommand, intervalToString::compute($currentInterval));
            }

            $diff = $currentInterval - $nextInterval;
            sleep($diff);
        }
    }


    protected function intervalToString(int $interval)
    {
        $hours = floor($interval/60/60);
        $minutes = floor(($interval % (60 * 60)) /60);
        $seconds = $interval % 60;

        if ($hours) {
            return sprintf('%d:%d:%d Hours', $hours, $minutes, $seconds);
        }
        $result = '';
        if ($minutes) {
            $result .= sprintf('%d Minutes ', $minutes);
        }
        if ($seconds) {
            $result .= sprintf('%d Seconds ', $seconds);
        }
        return $result;
    }
}
