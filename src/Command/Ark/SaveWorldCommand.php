<?php
namespace RconManager\Command\Ark;

use RconManager\Command\AbstractServerCommand;
use RconManager\ServerScripts\Ark\SaveWorld;
use RconManager\Service\RconService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

// the name of the command is what users type after "php bin/console"
#[AsCommand(name: 'rcon:ark:saveworld')]
class SaveWorldCommand extends AbstractServerCommand
{
    public function __construct(
        protected SaveWorld $script,
        RconService $rconService
    ) {
        parent::__construct($rconService);
    }

    protected function configure(): void
    {
        $this
            // the command description shown when running "php bin/console list"
            ->setDescription('Save world')
            // the command help shown when running the command with the "--help" option
            ->setHelp('Server will save world')
        ;
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $this->requestMissingInputOptions($input, $io);
        $server = $input->getArgument('server');

        $this->rconService->runScript($server, $this->script);
        
        return Command::SUCCESS;
    }
}