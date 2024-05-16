<?php
namespace RconManager\Command\Ark;

use RconManager\Command\AbstractServerCommand;
use RconManager\ServerCommand\Ark\ListpLayers;
use RconManager\Service\RconService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

// the name of the command is what users type after "php bin/console"
#[AsCommand(name: 'rcon:ark:list-players')]
class ListPlayersCommand extends AbstractServerCommand
{
    public function __construct(
        protected ListpLayers $command,
        RconService $rconService
    ) {
        parent::__construct($rconService);
    }

    protected function configure(): void
    {
        $this
            // the command description shown when running "php bin/console list"
            ->setDescription('List online players')
            // the command help shown when running the command with the "--help" option
            ->setHelp('List currently connected players')
        ;
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $this->requestMissingInputOptions($input, $io);
        $server = $input->getArgument('server');

        $players = trim($this->rconService->runCommand($server, $this->command));
        echo $players;
        echo PHP_EOL;
        
        return Command::SUCCESS;
    }
}