<?php
namespace RconManager\ServerScripts\VRising;

use RconManager\ServerScripts\AbstractScript as BaseAbstractScript;
use RconManager\Service\Config;
use RconManager\Service\RconService;

abstract class AbstractScript extends BaseAbstractScript
{
    public function serverTypeIsSupported(string $serverType): bool
    {
        return $serverType === RconService::SERVER_TYPE_VRISING;
    }
}
