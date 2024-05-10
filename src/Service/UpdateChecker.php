<?php
namespace RconManager\Service;

use mikehaertl\shellcommand\Command;
use RuntimeException;

class UpdateChecker
{
    protected $appIds = [
        RconService::SERVER_TYPE_VRISING => 1829350,
    ];

    public function __construct(
        protected Config $config
    ) {
    }

    public function serverNeedsUpdate(string $server)
    {
        $serverInfo = $this->config->getServerConfig($server);
        if (! isset($serverInfo['type'])) {
            throw new RuntimeException(sprintf('No server type specified for server %s', $server));
        }
        if (! isset($serverInfo['management'])) {
            throw new RuntimeException(sprintf('No management configuration in server %s', $server));
        }

        $installDir = $serverInfo['management']['localInstallDir'] ?? null;
        $appId = $serverInfo['management']['steamAppId'] ?? $this->appIds[$serverInfo['type']] ?? null;
        if (! $installDir) {
            throw new RuntimeException(sprintf('Invalid Install Dir in server %s', $server));
        }
        if (! $appId) {
            throw new RuntimeException(sprintf('Invalid App ID in server %s', $server));
        }

        $steamCmdPath = $this->config->getConfig()['steamcmd']['path'] ?? null;
        if (! $steamCmdPath) {
            throw new RuntimeException('Steam CMD Path not configured');
        }

        $command = new Command();
        $command->setCommand($steamCmdPath);
        $command->addArg('+force_install_dir');
        $command->addArg($installDir);
        $command->addArg('+login');
        $command->addArg('anonymous');
        $command->addArg('+app_status');
        $command->addArg($appId);
        $command->addArg('+quit');
        $command->execute();

        $output = explode("\n", $command->getOutput());
        $installedBuildID = null;
        foreach ($output as $line) {
            if (preg_match('/\s+\- size on disk: [0-9]+ bytes, BuildID ([0-9]+)/', $line, $matches)) {
                $installedBuildID = $matches[1];
            }
        }

        if (! $installedBuildID) {
            throw new RuntimeException('Installed Build ID could not be determined');
        }

        $steamAPIResponse = json_decode(file_get_contents(sprintf('https://api.steamcmd.net/v1/info/%d', $appId)), true);
        $currentBuildID = $steamAPIResponse['data'][$appId]['depots']['branches']['public']['buildid'] ?? null;

        if (! $currentBuildID) {
            throw new RuntimeException('Current Build ID could not be determined');
        }

        if ($currentBuildID != $installedBuildID) {
            return true;
        }
        return false;
    }
}