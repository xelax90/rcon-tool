<?php
namespace RconManager\ServerCommand\VRising;

/**
 * Schedule server shutdown.
 * Server will be shutdown aver $minutes minutes.
 * The message $message is sent to all users immediately
 */
class CancelShutdown extends AbstractCommand
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
        return sprintf('cancelshutdown "%s"', $this->message);
    }
}