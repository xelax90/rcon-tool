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

    protected function getValidatedServerConfig(string $server)
    {
        $serverInfo = $this->config->getServerConfig($server);
        $managementConfig = $this->config->getConfig()['management'] ?? [];
        if (! isset($serverInfo['management']) && empty($managementConfig)) {
            throw new RuntimeException(sprintf('No management configuration in server %s', $server));
        }

        $mustache = new Mustache_Engine();

        $installDir = $serverInfo['management']['localInstallDir'] ?? null;
        if (! $installDir) {
            $installDirTemplate = $managementConfig['vrising']['localInstallDirTemplate'] ?? null;
            $installDir = $mustache->render($installDirTemplate, ['server' => $server]);
        }
        if (! $installDir) {
            throw new RuntimeException(sprintf('Invalid Install Dir in server %s', $server));
        }

        $saveDataDir = $serverInfo['management']['vrising']['saveDataDir'] ?? null;
        if (! $saveDataDir) {
            $saveDataDirTemplate = $managementConfig['vrising']['saveDataDirTemplate'] ?? null;
            $saveDataDir = $mustache->render($saveDataDirTemplate, ['server' => $server]);
        }
        if (! $saveDataDir) {
            throw new RuntimeException(sprintf('Invalid V Rising Server ID in server %s', $server));
        }

        $steamCmdPath = $this->config->getConfig()['steamcmd']['path'] ?? null;
        if (! $steamCmdPath) {
            throw new RuntimeException('Steam CMD Path not configured');
        }

        $startWaitTimeout = 60;
        if (isset($managementConfig['vrising']['startWaitTimeout'])) {
            $startWaitTimeout = $managementConfig['vrising']['startWaitTimeout'];
        }
        if (isset($serverInfo['management']['vrising']['startWaitTimeout'])) {
            $startWaitTimeout = $serverInfo['management']['vrising']['startWaitTimeout'];
        }

        $serverPort = ($serverInfo['port'] ?? 27218) - 3;
        if (isset($serverInfo['management']['vrising']['serverPort'])) {
            $serverPort = $serverPort['management']['vrising']['serverPort'];
        }

        return [
            'installDir' => $installDir,
            'saveDataDir' => $saveDataDir,
            'steamcmdPath' => $steamCmdPath,
            'startWaitTimeout' => $startWaitTimeout,
            'serverPort' => $serverPort,
        ];
    }

    protected function generateStartServerScript(string $server)
    {
        $validatedConfig = $this->getValidatedServerConfig($server);

        $params = [
            'steamcmdPath' => $validatedConfig['steamcmdPath'],
            'installDir' => $validatedConfig['installDir'],
            'saveDataDir' => $validatedConfig['saveDataDir'],
            'serverPort' => $validatedConfig['serverPort'],
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
        $validatedConfig = $this->getValidatedServerConfig($server);

        $params = [
            'server' => $server,
            'applicationPath' => str_replace('/', DIRECTORY_SEPARATOR, Path::canonicalize(getcwd())),
            'serverPort' => $validatedConfig['serverPort'],
            'maxStartCounter' => ceil($validatedConfig['startWaitTimeout'] / 5),
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
