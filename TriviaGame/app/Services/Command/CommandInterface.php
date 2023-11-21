<?php

namespace App\Services\Command;

use Illuminate\Console\OutputStyle;
use Symfony\Component\Console\Input\InputInterface;

interface CommandInterface
{
    /**
     * @param InputInterface $input
     * @param OutputStyle $output
     * @param string $player2
     * @param $questions
     * @param $helper
     * @return void
     */
    public function playQuiz(InputInterface $input, OutputStyle $output, string $player2, $questions, $helper): void;

    /**
     * @param InputInterface $input
     * @param OutputStyle $output
     * @param string $player2
     * @param $question
     * @param $helper
     * @return mixed
     */
    public function askQuestion(InputInterface $input, OutputStyle $output, string $player2, $question, $helper): mixed;

    /**
     * @param InputInterface $input
     * @param OutputStyle $output
     * @param $helper
     * @return mixed
     */
    public function askQuestionType(InputInterface $input, OutputStyle $output, $helper): mixed;

    /**
     * @param InputInterface $input
     * @param OutputStyle $output
     * @param string $player1
     * @param $helper
     * @return mixed
     */
    public function addQuestions(InputInterface $input, OutputStyle $output, string $player1, $helper): mixed;

    /**
     * @param OutputStyle $output
     * @param string $playerNumber
     * @return mixed
     */
    public function ask(OutputStyle $output, string $playerNumber): mixed;
}
