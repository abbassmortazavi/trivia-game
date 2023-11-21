<?php

namespace App\Console\Commands;

use App\Services\Command\CommandService;
use App\Services\Question\QuestionService;
use Exception;
use Illuminate\Console\Command;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class TriviaGameCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trivia:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * @return void
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws Exception
     */
    public function handle(): void
    {
        $player1 = app(CommandService::class)->ask($this->output, 'Player 1');
        $player2 = app(CommandService::class)->ask($this->output, 'Player 2');

        $continue = $this->ask('Do you want to add more new questions Or Start Existing Question in Our database (yes/no): ');
        $helper = $this->getHelper('question');
        if ($continue === "no") {
            $questions = app(QuestionService::class)->get();
            if (count($questions) === 0) {
                $this->output->write("Your Database Questions is Empty, Please select Yes and add new Questions!!");
                exit();
            }
        } else {
            $questions = app(CommandService::class)->addQuestions($this->input, $this->output, $player1, $helper);
        }
        app(CommandService::class)->playQuiz($this->input, $this->output, $player2, $questions, $helper);
    }
}
