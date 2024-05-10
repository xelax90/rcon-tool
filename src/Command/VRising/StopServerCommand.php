<?php
namespace RconManager\Command\VRising;

use RconManager\Command\AbstractServerCommand;
use RconManager\ServerScripts\VRising\StopServer;
use RconManager\Service\RconService;
use RuntimeException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

// the name of the command is what users type after "php bin/console"
#[AsCommand(name: 'rcon:vrising:stop-server')]
class StopServerCommand extends AbstractServerCommand
{
    public function __construct(
        protected StopServer $script,
        RconService $rconService
    ) {
        parent::__construct($rconService);
    }

    protected function configure(): void
    {
        $this
            // the command description shown when running "php bin/console list"
            ->setDescription('Shutdown server')
            // the command help shown when running the command with the "--help" option
            ->setHelp('Server will save world and shutdown after sending configured messages.')
        ;
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $this->requestMissingInputOptions($input, $io);
        $server = $input->getArgument('server');

        try {
            $steamServer = $this->rconService->connectSteam($server);
            $players = $steamServer->getPlayers();
            if (count($players) > 0) {
                // Stop immediately if no players are connected
                $this->script->setStopImmediately(true);
            }
        } catch (RuntimeException $e) {
        }

        $this->rconService->runScript($server, $this->script);
        
        return Command::SUCCESS;
    }
}