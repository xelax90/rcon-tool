<?php
namespace RconManager\ServerCommand\VRising;

/**
 * Schedule server shutdown.
 * Server will be shutdown aver $minutes minutes.
 * The message $message is sent to all users immediately
 */
class Shutdown extends AbstractCommand
{
    public function __construct(protected int $minutes, protected string $message)
    {
    }

    public function validateResponse(string $response): bool
    {
        return true;
    }

    public function getRconCommand(...$arguments): string
    {
        return sprintf('shutdown %d "%s"', $this->minutes, $this->message);
    }
}