<?php
namespace RconManager\ServerCommand\Palworld;

/**
 * https://docs.palworldgame.com/settings-and-operation/commands
 * Save World
 */
class SaveWorld extends AbstractCommand
{
    public function validateResponse(string $response): bool
    {
        return trim($response) === 'Complete Save';
    }

    public function getRconCommand(...$arguments): string
    {
        return 'Save';
    }
}