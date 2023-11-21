<?php

namespace App\Strategy;

use Illuminate\Console\OutputStyle;
use Symfony\Component\Console\Input\InputInterface;

interface GenerateQuestionStrategy
{
    /**
     * @param InputInterface $input
     * @param OutputStyle $output
     * @param string $player1
     */
    public function generate(InputInterface $input, OutputStyle $output, string $player1);
}
