<?php
namespace RconManager\ServerCommand\VRising;

/**
 * Send Chat message to all players that the server will restart in X minutes
 */
class AnnounceRestart extends AbstractCommand
{
    public function __construct(protected int $minutes)
    {
    }

    public function validateResponse(string $response): bool
    {
        return true;
    }

    public function getRconCommand(...$arguments): string
    {
        return sprintf('announcerestart %d', $this->minutes);
    }
}