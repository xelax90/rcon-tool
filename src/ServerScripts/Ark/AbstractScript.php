<?php
namespace RconManager\ServerScripts\Ark;

use RconManager\ServerScripts\AbstractScript as BaseAbstractScript;
use RconManager\Service\RconService;

abstract class AbstractScript extends BaseAbstractScript
{
    public function serverTypeIsSupported(string $serverType): bool
    {
        return $serverType === RconService::SERVER_TYPE_ARK;
    }
}
