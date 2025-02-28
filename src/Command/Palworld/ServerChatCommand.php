<?php
namespace RconManager\Command\Palworld;

use RconManager\Command\AbstractServerCommand;
use RconManager\ServerCommand\Palworld\ServerChat;
use RconManager\Service\RconService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

// the name of the command is what users type after "php bin/console"
#[AsCommand(name: 'rcon:palworld:server-chat')]
class ServerChatCommand extends AbstractServerCommand
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
            ->setDescription('Send Server Chat Message')
            // the command help shown when running the command with the "--help" option
            ->setHelp('Send Chat Message from the Server as Announcement')
        ;
        parent::configure();
        $this->addArgument('message', InputArgument::OPTIONAL, 'Message to send');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $this->requestMissingInputOptions($input, $io);
        $server = $input->getArgument('server');
        $message = $input->getArgument('message');

        $command = new ServerChat($message);
        $response = trim($this->rconService->runCommand($server, $command));
        
        $io->writeln($response);

        return Command::SUCCESS;
    }
}