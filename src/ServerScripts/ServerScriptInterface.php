<?php
namespace RconManager\ServerScripts;

interface ServerScriptInterface
{
    public function run(string $server): void;

    public function serverTypeIsSupported(string $serverType): bool;
}
