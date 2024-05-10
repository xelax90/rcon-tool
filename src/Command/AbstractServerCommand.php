<?php
namespace RconManager\Command;

use RconManager\Service\RconService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;

abstract class AbstractServerCommand extends Command
{
    public function __construct(protected RconService $rconService)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('server', InputArgument::OPTIONAL, 'Server name')
        ;
    }

    protected function requestMissingInputOptions(InputInterface $input, SymfonyStyle $io)
    {
        if (! $input->getArgument('server')) {
            $answer = null;
            do {
                $question = new ChoiceQuestion('Please select a server', $this->rconService->getServers());
                $answer = $io->askQuestion($question);
            } while (empty($answer));
            $input->setArgument('server', $answer);
        }
    }
}