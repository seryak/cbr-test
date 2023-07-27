<?php

namespace Console\Commands;

use App\Queue\CurrencyParserConsumer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Worker extends Command
{
    protected function configure(): void
    {
        parent::configure();
        $this->setName('worker');
        $this->setDescription('Run worker for parsing');
    }

    /**
     * Execute command.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int integer 0 on success, or an error code
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $consumer = new CurrencyParserConsumer();
        $consumer->listen();

        return 0;
    }

}