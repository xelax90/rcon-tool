<?php
namespace RconManager\ServerCommand\VRising;

/**
 * Show command info
 */
class Help extends AbstractCommand
{
    public function __construct()
    {
    }

    public function validateResponse(string $response): bool
    {
        return true;
    }

    public function getRconCommand(...$arguments): string
    {
        if (! empty($arguments)) {
            return sprintf('help "%s"', $arguments[0]);
        }
        return 'help';
    }
}