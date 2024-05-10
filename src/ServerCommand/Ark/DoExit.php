<?php
namespace RconManager\ServerCommand\Ark;

/**
 * https://ark.fandom.com/wiki/Console_commands#DoExit
 * Shutdown Server
 */
class DoExit extends AbstractCommand
{
    public function validateResponse(string $response): bool
    {
        return trim($response) === 'Exiting...';
    }

    public function getRconCommand(...$arguments): string
    {
        return 'DoExit';
    }
}