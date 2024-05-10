<?php
namespace RconManager\ServerCommand\Ark;

/**
 * https://ark.fandom.com/wiki/Console_commands#SaveWorld
 * Save World
 */
class SaveWorld extends AbstractCommand
{
    public function validateResponse(string $response): bool
    {
        return trim($response) === 'World Saved';
    }

    public function getRconCommand(...$arguments): string
    {
        return 'SaveWorld';
    }
}