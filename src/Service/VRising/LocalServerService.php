<?php
namespace RconManager\Service\VRising;

use Mustache_Engine;
use RconManager\Service\Config;
use RuntimeException;
use Symfony\Component\Filesystem\Path;

class LocalServerService
{
    public function __construct(
        protected Config $config
    ) {
    }


    protected function getSaveDataDir(string $server)
    {
        $serverInfo = $this->config->getServerConfig($server);
        $managementConfig = $this->config->getConfig()['management'] ?? [];
        if (! isset($serverInfo['management']) && empty($managementConfig)) {
            throw new RuntimeException(sprintf('No management configuration in server %s', $server));
        }

        $mustache = new Mustache_Engine();

        $saveDataDir = $serverInfo['management']['saveDataDir'] ?? null;
        if (! $saveDataDir) {
            $saveDataDirTemplate = $managementConfig['vrising']['saveDataDirTemplate'] ?? null;
            $saveDataDir = $mustache->render($saveDataDirTemplate, ['server' => $server]);
        }
        if (! $saveDataDir) {
            throw new RuntimeException(sprintf('Invalid V Rising Server ID in server %s', $server));
        }

        return $saveDataDir;
    }

    public function initLocalServer(string $server)
    {
        $serverInfo = $this->config->getServerConfig($server);
        $targetDir = Path::join($this->getSaveDataDir($server), 'save-data/Settings');

        $hostSettings = [
            "Name" => "MY_SERVER",
            "Description" => "",
            "Port" => ($serverInfo['port'] ?? 27218) - 3,
            "QueryPort" => $serverInfo['steamQeryPort'] ?? 27216,
            "MaxConnectedUsers" => 40,
            "MaxConnectedAdmins" => 10,
            "SaveName" => "world1",
            "Password" => "",
            "Secure" => true,
            "ListOnSteam" => true,
            "ListOnEOS" => false,
            "AutoSaveCount" => 20,
            "AutoSaveInterval" => 60,
            "GameSettingsPreset" => "",
            "GameDifficultyPreset" => "Difficulty_Brutal",
            "AdminOnlyDebugEvents" => true,
            "DisableDebugEvents" => false,
            "API" => [
                "Enabled" => false
            ],
            "Rcon" => [
                "Enabled" => true,
                "Port" => $serverInfo['port'] ?? 27218,
                "Password" => $serverInfo['password']
            ]
        ];

        if (! is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $targetFile = Path::join($targetDir, 'ServerHostSettings.json');
        if (! file_exists($targetFile)) {
            file_put_contents($targetFile, json_encode($hostSettings, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

            $targetFile2 = Path::join($targetDir, 'ServerGameSettings.json');
            if (! file_exists($targetFile2)) {
                file_put_contents($targetFile2, '{}');
            }
        }
    }
}
