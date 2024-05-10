<?php
namespace RconManager\ServerCommand\VRising;

/**
 * https://ark.fandom.com/wiki/Console_commands#ServerChat
 * Send Chat message to all players
 */
class Announce extends AbstractCommand
{
    public function __construct(protected string $message)
    {
    }

    public function validateResponse(string $response): bool
    {
        return true;
    }

    public function getRconCommand(...$arguments): string
    {
        return sprintf('announce "%s"', $this->message);
    }
}