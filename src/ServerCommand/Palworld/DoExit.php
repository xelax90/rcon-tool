<?php
namespace RconManager\ServerCommand\Palworld;

/**
 * https://docs.palworldgame.com/settings-and-operation/commands
 * Shutdown Server
 */
class DoExit extends AbstractCommand
{
    public function validateResponse(string $response): bool
    {
        return trim($response) === 'Shutdown...';
    }

    public function getRconCommand(...$arguments): string
    {
        return 'DoExit';
    }
}