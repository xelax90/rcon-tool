<?php
namespace RconManager\Command;

use RconManager\ServerScripts\SaveWorld;
use RconManager\Service\Config;
use RconManager\Service\RconService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

// the name of the command is what users type after "php bin/console"
#[AsCommand(name: 'rcon:list-servers')]
class ListServersCommand extends Command
{
    public function __construct(
        protected Config $config,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            // the command description shown when running "php bin/console list"
            ->setDescription('List configured servers')
        ;
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $servers = $this->config->getServers();
        if ($output->isVerbose()) {
            $result = [];
            foreach ($servers as $server) {
                $serverConfig = $this->config->getServerConfig($server);
                $result[] = sprintf('%s - %s:%d', $server, $serverConfig['host'], $serverConfig['port']);
            }
            $servers = $result;
        }

        $io->writeln('Available servers:');
        $io->listing($servers);

        return Command::SUCCESS;
    }
}