<?php
namespace RconManager\Command\VRising;

use RconManager\Command\AbstractServerCommand;
use RconManager\ServerCommand\VRising\Help;
use RconManager\Service\RconService;
use SteamCondenser\Servers\SteamPlayer;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

// the name of the command is what users type after "php bin/console"
#[AsCommand(name: 'rcon:vrising:list-players')]
class ListPlayersCommand extends AbstractServerCommand
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
            ->setDescription('List online players')
            // the command help shown when running the command with the "--help" option
            ->setHelp('List currently connected players. Server must have Steam API enabled.')
        ;
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $this->requestMissingInputOptions($input, $io);
        $server = $input->getArgument('server');

        $steamServer = $this->rconService->connectSteam($server);

        /** @var SteamPlayer[] */
        $players = $steamServer->getPlayers();
        $result = [];
        foreach ($players as $player) {
            $result[] = sprintf('%s (Connected since %d minutes)', $player->getName(), floor($player->getConnectTime() / 60));
        }
        $io->listing($result);
        return Command::SUCCESS;
    }
}