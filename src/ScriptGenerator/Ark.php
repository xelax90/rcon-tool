<?php
namespace RconManager\ScriptGenerator;

use Mustache_Engine;
use RconManager\Service\Config;
use RconManager\Service\RconService;
use RconManager\Utils\ArkConfig;
use RuntimeException;
use Symfony\Component\Filesystem\Path;

class Ark implements ScriptGenerator
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
        if ($serverInfo['type'] !== RconService::SERVER_TYPE_ARK) {
            throw new RuntimeException(sprintf('Server type %s is not supported by generator "%s"', $serverInfo['type'], get_class($this)));
        }
        $this->generateStartServerScript($server);
        $this->generateCrontaskScript($server);
        $this->generateRestartScript($server);
        $this->generateConfigs($server);
    }

    protected function getValidatedServerConfig(string $server)
    {
        $serverInfo = $this->config->getServerConfig($server);
        $managementConfig = $this->config->getConfig()['management'] ?? [];
        if (! isset($serverInfo['management']) && empty($managementConfig)) {
            throw new RuntimeException(sprintf('No management configuration in server %s', $server));
        }

        $configTemplate = [];
        if (isset($serverInfo['management']['ark']['configTemplate'])) {
            $configTemplate = $this->config->getConfig()['management']['ark']['configTemplates'][$serverInfo['management']['ark']['configTemplate']] ?? [];
        }

        $startWaitTimeout = 120;
        if (isset($managementConfig['ark']['startWaitTimeout'])) {
            $startWaitTimeout = $managementConfig['ark']['startWaitTimeout'];
        }
        if (isset($serverInfo['management']['ark']['startWaitTimeout'])) {
            $startWaitTimeout = $serverInfo['management']['ark']['startWaitTimeout'];
        }

        foreach ($serverInfo['management']['ark']['gameSettings'] ?? [] as $settingType => $typeSettings) {
            if ($settingType == ArkConfig::CONFIG_TYPE_COMMANDLINE_OPTION) {
                // No sections in command line
                foreach ($typeSettings as $setting => $settingValue) {
                    $configTemplate[$settingType][$setting] = $settingValue;
                }
                continue;
            }
            if (in_array($settingType, [
                ArkConfig::CONFIG_TYPE_PLAYER_EXCLUSIVE_JOIN_LIST,
                ArkConfig::CONFIG_TYPE_PLAYER_JOIN_NO_CHECK_LIST,
                ArkConfig::CONFIG_TYPE_ALLOWED_CHEATER_ACCOUNT_IDS,
                ArkConfig::CONFIG_TYPE_BANLIST
            ])) {
                // Player ID lists have no keys
                $configTemplate[$settingType] = array_unique(array_merge($configTemplate[$settingType], $typeSettings));
                continue;
            }
            foreach ($typeSettings as $section => $sectionSettings) {
                foreach ($sectionSettings as $setting => $settingValue) {
                    if (is_numeric($setting)) {
                        $configTemplate[$settingType][$section][] = $settingValue;
                    } else {
                        $configTemplate[$settingType][$section][$setting] = $settingValue;
                    }
                }
            }
        }

        $mustache = new Mustache_Engine();

        $installDir = $serverInfo['management']['localInstallDir'] ?? null;
        if (! $installDir) {
            $installDirTemplate = $managementConfig['ark']['localInstallDirTemplate'] ?? null;
            $installDir = $mustache->render($installDirTemplate, ['server' => $server]);
        }
        if (! $installDir) {
            throw new RuntimeException(sprintf('Invalid Install Dir in server %s', $server));
        }

        $steamCmdPath = $this->config->getConfig()['steamcmd']['path'] ?? null;
        if (! $steamCmdPath) {
            throw new RuntimeException('Steam CMD Path not configured');
        }



        $serverMap = $serverInfo['management']['ark']['map'] ?? null;
        if (! $serverMap) {
            throw new RuntimeException(sprintf('Invalid Server Map in server %s', $server));
        }

        return [
            'installDir' => $installDir,
            'steamcmdPath' => $steamCmdPath,
            'startWaitTimeout' => $startWaitTimeout,
            'serverMap' => $serverMap,
            'gameSettings' => $configTemplate,
        ];
    }

    protected function generateStartServerScript(string $server)
    {
        $validatedConfig = $this->getValidatedServerConfig($server);

        $questionmarkParameters = [];
        $serverStartParameters = [];
        foreach ($validatedConfig['gameSettings'][ArkConfig::CONFIG_TYPE_COMMANDLINE_OPTION] ?? [] as $key => $value) {
            if (str_starts_with($key, '?')) {
                if (is_numeric($value)) {
                    $questionmarkParameters[] = sprintf('%s=%s', $key, $value);
                } else {
                    $questionmarkParameters[] = sprintf('%s="%s"', $key, $value);
                }
                continue;
            }
            if ($value === null) {
                $serverStartParameters[] = $key;
                continue;
            }
            if (is_array($value)) {
                $serverStartParameters[] = sprintf('%s=%s', $key, implode(',', $value));
                continue;
            }
            $serverStartParameters[] = sprintf('%s="%s"', $key, $value);
        }

        $serverPort = 7777;
        if (isset($validatedConfig['gameSettings'][ArkConfig::CONFIG_TYPE_COMMANDLINE_OPTION]['-port'])) {
            $serverPort = $validatedConfig['gameSettings'][ArkConfig::CONFIG_TYPE_COMMANDLINE_OPTION]['-port'];
        }

        $params = [
            'steamcmdPath' => $validatedConfig['steamcmdPath'],
            'installDir' => $validatedConfig['installDir'],
            'serverMap' => $validatedConfig['serverMap'],
            'serverPort' => $serverPort,
            'maxStartCounter' => ceil($validatedConfig['startWaitTimeout'] / 5),
            'questionmarkParameters' => implode('', $questionmarkParameters),
            'serverStartParameters' => implode(' ', $serverStartParameters),
        ];
        $templateContents = file_get_contents('scriptTemplates/ark/startServer.mustache');

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
        $params = [
            'server' => $server,
            'applicationPath' => str_replace('/', DIRECTORY_SEPARATOR, Path::canonicalize(getcwd())),
        ];
        $templateContents = file_get_contents('scriptTemplates/ark/crontask.mustache');

        $mustache = new Mustache_Engine();
        $scriptContent = $mustache->render($templateContents, $params);

        $outputDir = Path::join('generated', $server);
        $outputPath = Path::join($outputDir, 'crontask.bat');

        if (! is_dir($outputDir)) {
            mkdir($outputDir, 0777, true);
        }
        file_put_contents($outputPath, $scriptContent);
    }

    protected function generateRestartScript(string $server)
    {
        $params = [
            'server' => $server,
            'applicationPath' => str_replace('/', DIRECTORY_SEPARATOR, Path::canonicalize(getcwd())),
        ];
        $templateContents = file_get_contents('scriptTemplates/ark/restartServer.mustache');

        $mustache = new Mustache_Engine();
        $scriptContent = $mustache->render($templateContents, $params);

        $outputDir = Path::join('generated', $server);
        $outputPath = Path::join($outputDir, 'restartServer.bat');

        if (! is_dir($outputDir)) {
            mkdir($outputDir, 0777, true);
        }
        file_put_contents($outputPath, $scriptContent);
    }

    protected function generateConfigs(string $server)
    {
        $validatedConfig = $this->getValidatedServerConfig($server);

        $gameIniContents = $this->buildIniContent($validatedConfig['gameSettings'][ArkConfig::CONFIG_TYPE_GAME] ?? []);
        $gameUserIniContent = $this->buildIniContent($validatedConfig['gameSettings'][ArkConfig::CONFIG_TYPE_GAMEUSERSETTINGS] ?? []);

        $outputDir = Path::join('generated', $server);

        if (! is_dir($outputDir)) {
            mkdir($outputDir, 0777, true);
        }
        file_put_contents(Path::join($outputDir, 'Game.ini'), $gameIniContents);
        file_put_contents(Path::join($outputDir, 'GameUserSettings.ini'), $gameUserIniContent);
        file_put_contents(Path::join($outputDir, 'PlayersExclusiveJoinList.txt'), implode("\n", $validatedConfig['gameSettings'][ArkConfig::CONFIG_TYPE_PLAYER_EXCLUSIVE_JOIN_LIST] ?? []));
        file_put_contents(Path::join($outputDir, 'PlayersJoinNoCheckList.txt'), implode("\n", $validatedConfig['gameSettings'][ArkConfig::CONFIG_TYPE_PLAYER_JOIN_NO_CHECK_LIST] ?? []));
        file_put_contents(Path::join($outputDir, 'AllowedCheaterAccountIDs.txt'), implode("\n", $validatedConfig['gameSettings'][ArkConfig::CONFIG_TYPE_ALLOWED_CHEATER_ACCOUNT_IDS] ?? []));
        file_put_contents(Path::join($outputDir, 'Banlist.txt'), implode("\n", $validatedConfig['gameSettings'][ArkConfig::CONFIG_TYPE_BANLIST] ?? []));
    }

    protected function buildIniContent(array $configArray)
    {
        $iniContent = [];
        foreach ($configArray as $section => $sectionConfig) {
            if (! empty($iniContent)) {
                $iniContent[] = '';
            }
            $iniContent[] = sprintf('[%s]', $section);
            foreach ($sectionConfig as $key => $value) {
                if (is_numeric($key)) {
                    $iniContent[] = $value;
                    continue;
                }
                $iniContent[] = sprintf('%s=%s', $key, $value);
            }
        }
        return implode("\n", $iniContent);
    }
}
