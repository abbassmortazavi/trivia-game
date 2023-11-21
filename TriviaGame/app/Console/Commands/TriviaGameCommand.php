<?php

namespace App\Console\Commands;

use App\Enums\QuestionType;
use App\Services\Command\CommandService;
use App\Services\Question\QuestionService;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Console\OutputStyle;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

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
        $player1 = $this->askForPlayerName('Player 1');
        $player2 = $this->askForPlayerName('Player 2');

        $continue = $this->ask('Do you want to add more new questions Or Start Existing Question in Our database (yes/no): ');
        $helper = $this->getHelper('question');
        if ($continue === "no") {
            $questions = app(QuestionService::class)->get();
            if (count($questions) === 0) {
                $this->output->write("Your Database Questions is Empty, Please select Yes and add new Questions!!");
                exit();
            }
        } else {
            $questions = $this->addQuestions($this->input, $this->output, $player1);
        }
        app(CommandService::class)->playQuiz($this->input, $this->output, $player2, $questions, $helper);
    }

    /**
     * @param $playerNumber
     * @return mixed
     */
    private function askForPlayerName($playerNumber): mixed
    {
        return $this->ask("Enter the name for {$playerNumber}: ");
    }

    /**
     * @throws Exception
     */
    private function addQuestions(InputInterface $input, OutputStyle $output, string $player1): array
    {
        do {
            $questionType = $this->askQuestionType($input, $output);
            $strategy = resolve('App\Strategy\QuestionStrategy');
            $questions[] = $strategy->generateQuestion($questionType, $input, $output, $player1);
            $continue = $this->ask('Do you want to add more questions? (yes/no): ');
        } while (strtolower($continue) === 'yes');
        return $questions;
    }

    /**
     * @param InputInterface $input
     * @param OutputStyle $output
     * @return mixed
     */
    private function askQuestionType(InputInterface $input, OutputStyle $output): mixed
    {
        $helper = $this->getHelper('question');
        $question = new ChoiceQuestion('Select the question type:', [QuestionType::CHOICE->value, QuestionType::TRUEFALSE->value]);
        $question->setErrorMessage('Invalid question type.');
        return $helper->ask($input, $output, $question);
    }
}
