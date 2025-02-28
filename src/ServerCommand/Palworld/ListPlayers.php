<?php
namespace RconManager\ServerCommand\Palworld;

/**
 * https://docs.palworldgame.com/settings-and-operation/commands
 * Save World
 */
class ListPlayers extends AbstractCommand
{
    public function validateResponse(string $response): bool
    {
        return strlen(trim($response)) > 5;
    }

    public function getRconCommand(...$arguments): string
    {
        return 'ShowPlayers';
    }
}