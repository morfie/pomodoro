<?php

namespace Pomodoro;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

class PomodoroCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('pomodoro:start')
            ->addArgument(
                'time',
                InputArgument::REQUIRED
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $time = $input->getArgument('time') * 60;
        $progressBar = new ProgressBar($output, $time);
        $progressBar->setFormat('%message% %bar%');

        for ($i=1; $i<=$time; $i++) {
            $progressBar->setMessage(date('i:s', $time-$i));
            $progressBar->advance();
            sleep(1);
        }

        $progressBar->finish();
        $process = new Process('dm-tool lock');
        $process->run();
    }
}