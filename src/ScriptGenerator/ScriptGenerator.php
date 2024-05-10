<?php
namespace RconManager\ScriptGenerator;

interface ScriptGenerator
{
    public function generate(string $server);
}
