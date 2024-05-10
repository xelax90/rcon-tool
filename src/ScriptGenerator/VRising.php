<?php
namespace RconManager\ScriptGenerator;

use Mustache_Engine;
use RconManager\Service\Config;
use RconManager\Service\RconService;
use RuntimeException;
use Symfony\Component\Filesystem\Path;

class VRising implements ScriptGenerator
{
    public function __construct(
        protected Config $config
    )
    {
    }

    public function generate(string $server)
    {
        $serverInfo = $this->config->getServerConfig($server);
        if (! isset($serverInfo['type'])) {
            throw new RuntimeException(sprintf('No server type specified for server %s', $server));
        }
        if ($serverInfo['type'] !== RconService::SERVER_TYPE_VRISING) {
            throw new RuntimeException(sprintf('Server type %s is not supported by generator "%s"', $serverInfo['type'], get_class($this)));
        }
        $this->generateStartServerScript($server);
        $this->generateCrontaskScript($server);
    }

    protected function validateServerConfig(string $server)
    {
        $serverInfo = $this->config->getServerConfig($server);
        if (! isset($serverInfo['management'])) {
            throw new RuntimeException(sprintf('No management configuration in server %s', $server));
        }
        $installDir = $serverInfo['management']['localInstallDir'] ?? null;
        $serverId = $serverInfo['management']['vrising']['serverId'] ?? null;
        if (! $installDir) {
            throw new RuntimeException(sprintf('Invalid Install Dir in server %s', $server));
        }
        if (! $serverId) {
            throw new RuntimeException(sprintf('Invalid V Rising Server ID in server %s', $server));
        }

        $steamCmdPath = $this->config->getConfig()['steamcmd']['path'] ?? null;
        if (! $steamCmdPath) {
            throw new RuntimeException('Steam CMD Path not configured');
        }
    }

    protected function generateStartServerScript(string $server)
    {
        $this->validateServerConfig($server);

        $serverInfo = $this->config->getServerConfig($server);

        $installDir = $serverInfo['management']['localInstallDir'] ?? null;
        $serverId = $serverInfo['management']['vrising']['serverId'] ?? null;
        $steamCmdPath = $this->config->getConfig()['steamcmd']['path'] ?? null;

        $params = [
            'serverId' => $serverId,
            'steamcmdPath' => $steamCmdPath,
            'installDir' => $installDir,
        ];
        $templateContents = file_get_contents('scriptTemplates/vrising/startServer.mustache');

        $mustache = new Mustache_Engine();
        $scriptContent = $mustache->render($templateContents, $params);

        $outputDir = Path::join('generated', $server);
        $outputPath = Path::join($outputDir, 'startServer.bat');

        if (! is_dir($outputDir)) {
            mkdir($outputDir, 0777, true);
        }
        file_put_contents($outputPath, $scriptContent);
    }

    protected function generateCrontaskScript(string $server)
    {
        $this->validateServerConfig($server);

        $serverInfo = $this->config->getServerConfig($server);

        $installDir = $serverInfo['management']['localInstallDir'] ?? null;
        $serverId = $serverInfo['management']['vrising']['serverId'] ?? null;
        $steamCmdPath = $this->config->getConfig()['steamcmd']['path'] ?? null;

        $params = [
            'server' => $server,
            'applicationPath' => Path::canonicalize(getcwd()),
        ];
        $templateContents = file_get_contents('scriptTemplates/vrising/crontask.mustache');

        $mustache = new Mustache_Engine();
        $scriptContent = $mustache->render($templateContents, $params);

        $outputDir = Path::join('generated', $server);
        $outputPath = Path::join($outputDir, 'crontask.bat');

        if (! is_dir($outputDir)) {
            mkdir($outputDir, 0777, true);
        }
        file_put_contents($outputPath, $scriptContent);
    }
}
