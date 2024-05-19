<?php
namespace RconManager\Command\VRising;

use RconManager\Command\AbstractServerCommand;
use RconManager\ServerCommand\VRising\CancelShutdown;
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
#[AsCommand(name: 'rcon:vrising:cancel-shutdown')]
class CancelShutdownCommand extends AbstractServerCommand
{
    public function __construct(
        RconService $rconService
    ) {
        parent::__construct($rconService);
    }

    protected function configure(): void
    {
        $this
            // the command description shown when running "php bin/console list"
            ->setDescription('Cancel Server Shutdown')
            // the command help shown when running the command with the "--help" option
            ->setHelp('Stop shutdown scheduled by stop-server command.')
        ;
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $this->requestMissingInputOptions($input, $io);
        $server = $input->getArgument('server');

        $this->rconService->runCommand($server, new CancelShutdown('Shutdown is canceled'));
        
        return Command::SUCCESS;
    }
}