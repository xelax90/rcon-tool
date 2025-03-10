<?php
namespace RconManager\ServerCommand\Palworld;

/**
 * https://docs.palworldgame.com/settings-and-operation/commands
 * Send Chat message to all players
 */
class ServerChat extends AbstractCommand
{
    public function __construct(protected string $message)
    {
    }

    public function validateResponse(string $response): bool
    {
        return str_starts_with(trim($response), 'Broadcasted: ');
    }

    public function getRconCommand(...$arguments): string
    {
        return sprintf('Broadcast %s', $this->message);
    }
}