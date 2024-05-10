<?php
namespace RconManager\ServerScripts;

use Thedudeguy\Rcon;

interface ServerScriptInterface
{
    public function run(Rcon $rcon): void;

    public function serverTypeIsSupported(string $serverType): bool;
}
