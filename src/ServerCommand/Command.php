<?php
namespace RconManager\ServerCommand;

interface Command
{
    public function getRconCommand(...$arguments): string;

    public function validateResponse(string $response): bool;

    public function serverTypeIsSupported(string $serverType): bool;
}