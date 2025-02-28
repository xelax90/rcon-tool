<?php
namespace RconManager\ServerCommand\Palworld;

/**
 * https://docs.palworldgame.com/settings-and-operation/commands
 * Send Chat message to all players using a template
 */
class ServerChatWithTemplate extends ServerChat
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