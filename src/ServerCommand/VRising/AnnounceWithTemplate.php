<?php
namespace RconManager\ServerCommand\VRising;

use RconManager\ServerCommand\AbstractCommand;

/**
 * Send Chat message to all players using template
 */
class AnnounceWithTemplate extends Announce
{
    public function __construct(protected string $template)
    {
        parent::__construct('');
    }

    public function getRconCommand(...$arguments): string
    {
        $this->message = sprintf($this->template, ...$arguments);
        return parent::getRconCommand();
    }
}