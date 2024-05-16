<?php
namespace RconManager\ServerCommand\Ark;

/**
 * https://ark.fandom.com/wiki/Console_commands#SaveWorld
 * Save World
 */
class ListpLayers extends AbstractCommand
{
    public function validateResponse(string $response): bool
    {
        return trim($response) == "No Players Connected" || strlen(trim($response)) > 5;
    }

    public function getRconCommand(...$arguments): string
    {
        return 'ListPlayers';
    }
}