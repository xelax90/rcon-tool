<?php
namespace RconManager\ServerScripts;

use RconManager\ServerCommand\Command;
use RuntimeException;
use Thedudeguy\Rcon;

abstract class AbstractScript implements ServerScriptInterface
{
    protected function runCommand(Rcon $rcon, Command $command, ...$arguments)
    {
        $execCommand = $command->getRconCommand(...$arguments);
        $response = $rcon->sendCommand($execCommand);
        if (! $command->validateResponse($response)) {
            throw new RuntimeException(sprintf('Command "%s" failed with response "%s"', $execCommand, $response));
        }
        return $response;
    }
}
