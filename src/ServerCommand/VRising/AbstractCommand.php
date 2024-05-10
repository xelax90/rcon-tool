<?php
namespace RconManager\ServerCommand\VRising;

use RconManager\ServerCommand\AbstractCommand as BaseAbstractCommand;
use RconManager\Service\RconService;

abstract class AbstractCommand extends BaseAbstractCommand
{
    public function serverTypeIsSupported(string $serverType): bool
    {
        return $serverType === RconService::SERVER_TYPE_VRISING;
    }
}