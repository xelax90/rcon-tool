<?php
namespace RconManager\Command\VRising;

use RconManager\Command\AbstractServerCommand;
use RconManager\ServerCommand\VRising\Help;
use RconManager\Service\RconService;
use RconManager\Service\VRising\LocalServerService;
use SteamCondenser\Servers\SteamPlayer;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

// the name of the command is what users type after "php bin/console"
#[AsCommand(name: 'rcon:vrising:init-local-server')]
class InitLocalServerCommand extends AbstractServerCommand
{
    public function __construct(
        RconService $rconService,
        protected LocalServerService $localServerService
    ) {
        parent::__construct($rconService);
    }

    protected function configure(): void
    {
        $this
            // the command description shown when running "php bin/console list"
            ->setDescription('Initialize local server')
            // the command help shown when running the command with the "--help" option
            ->setHelp('Create initial server configuration for local server')
        ;
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $this->requestMissingInputOptions($input, $io);
        $server = $input->getArgument('server');

        $this->localServerService->initLocalServer($server);

        return Command::SUCCESS;
    }
}