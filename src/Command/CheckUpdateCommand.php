<?php
namespace RconManager\Command;

use RconManager\ServerScripts\SaveWorld;
use RconManager\Service\Config;
use RconManager\Service\RconService;
use RconManager\Service\ScriptGenerator;
use RconManager\Service\UpdateChecker;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

// the name of the command is what users type after "php bin/console"
#[AsCommand(name: 'rcon:check-update')]
class CheckUpdateCommand extends AbstractServerCommand
{
    public function __construct(
        protected Config $config,
        protected UpdateChecker $updateChecker,
        RconService $rconService
    ) {
        parent::__construct($rconService);
    }

    protected function configure(): void
    {
        $this
            // the command description shown when running "php bin/console list"
            ->setDescription('Generate batch scripts for server')
        ;
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $this->requestMissingInputOptions($input, $io);
        $server = $input->getArgument('server');

        try {
            if ($this->updateChecker->serverNeedsUpdate($server)) {
                return Command::FAILURE;
            }
        } catch (\Throwable $e) {
            // TODO add notification?
            return Command::INVALID;
        }

        return Command::SUCCESS;
    }
}