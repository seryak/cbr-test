<?php

namespace Console\Commands;

use App\Core\ServiceContainer;
use App\DTO\DateValue;
use App\Queue\IAMQPClient;
use Carbon\Carbon;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Last180 extends Command
{
    protected function configure(): void
    {
        parent::configure();
        $this->setName('last180');
        $this->setDescription('Download currency rate for last 180 days');
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
        $currentDate = new DateValue(Carbon::today()->format('Y-m-d'));

        $queueClient = (new ServiceContainer())->get(IAMQPClient::class);

        for ($i = 0; $i < 180; $i++) {
            $message = ['date' => $currentDate->getValue()];
            $queueClient->send(json_encode($message, JSON_THROW_ON_ERROR), 'currency-parsing');
            $currentDate = new DateValue(Carbon::make($currentDate->getValue())->subDay()->format('Y-m-d'));
        }
        $queueClient->close();

        return 0;
    }

}