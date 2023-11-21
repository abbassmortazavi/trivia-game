<?php

namespace App\Services\Command;

use App\Enums\QuestionType;
use App\Services\Question\QuestionService;
use App\Services\Result\ResultService;
use Exception;
use Illuminate\Console\OutputStyle;
use Symfony\Component\Console\Input\InputInterface;

class CommandService implements CommandInterface
{
    /**
     * @param InputInterface $input
     * @param OutputStyle $output
     * @param string $player2
     * @param $questions
     * @param $helper
     * @return void
     * @throws Exception
     */
    public function playQuiz(InputInterface $input, OutputStyle $output, string $player2, $questions, $helper): void
    {
        $totalQuestions = count($questions);
        $player2Score = 0;
        foreach ($questions as $question) {
            $player2Answer = $this->askQuestion($input, $output, $player2, $question, $helper);
            if ($question['type'] === QuestionType::CHOICE->value && $player2Answer === $question->answer->answer['options']['correct_answer']) {
                $player2Score++;
            }
            if ($question['type'] === QuestionType::TRUEFALSE->value) {
                $playerAnswer = !($player2Answer === "false");
                if ($playerAnswer === $question->answer->answer['options']['correct_answer']) {
                    $player2Score++;
                }
            }
        }
        $output->writeln("\nResults for $player2:");
        $output->writeln("Total Questions: $totalQuestions");
        $output->writeln("Correct Answers: $player2Score");
        $output->writeln("Wrong Answers: " . ($totalQuestions - $player2Score));
        $output->writeln("Score: $player2Score/$totalQuestions");

        $data['player_name'] = $player2;
        $data['score'] = $player2Score;
        $data['total_questions'] = $totalQuestions;
        $data['correct_answer'] = $player2Score;
        $data['wrong_answer'] = $totalQuestions - $player2Score;
        $this->_storeResult($data);
    }

    /**
     * @param InputInterface $input
     * @param OutputStyle $output
     * @param string $player2
     * @param $question
     * @param $helper
     * @return mixed
     * @throws Exception
     */
    public function askQuestion(InputInterface $input, OutputStyle $output, string $player2, $question, $helper): mixed
    {
        return app(QuestionService::class)->checkType($question['type'], $input, $output, $player2, $question, $helper);
    }

    /**
     * @param array $data
     * @return void
     */
    private function _storeResult(array $data): void
    {
        app(ResultService::class)->store($data);
    }
}
