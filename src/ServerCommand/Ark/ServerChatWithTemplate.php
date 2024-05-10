<?php
namespace RconManager\ServerCommand\Ark;

/**
 * https://ark.fandom.com/wiki/Console_commands#ServerChat
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