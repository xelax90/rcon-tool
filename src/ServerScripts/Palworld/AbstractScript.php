<?php
namespace RconManager\ServerScripts\Palworld;

use RconManager\ServerScripts\AbstractScript as BaseAbstractScript;
use RconManager\Service\RconService;

abstract class AbstractScript extends BaseAbstractScript
{
    public function serverTypeIsSupported(string $serverType): bool
    {
        return $serverType === RconService::SERVER_TYPE_PALWORLD;
    }
}
