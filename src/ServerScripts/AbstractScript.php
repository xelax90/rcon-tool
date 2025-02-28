<?php
namespace RconManager\ServerScripts;

use RconManager\Service\RconService;
abstract class AbstractScript implements ServerScriptInterface
{
    public function __construct(
        protected RconService $rconService
    ) {
    }
}
