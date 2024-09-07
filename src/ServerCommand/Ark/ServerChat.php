<?php
namespace RconManager\ServerCommand\Ark;

/**
 * https://ark.fandom.com/wiki/Console_commands#ServerChat
 * Send Chat message to all players
 */
class ServerChat extends AbstractCommand
{
    public function __construct(protected string $message)
    {
    }

    public function validateResponse(string $response): bool
    {
        return trim($response) === 'Server received, But no response!!';
    }

    public function getRconCommand(...$arguments): string
    {
        return sprintf('ServerChat %s', $this->message);
    }
}