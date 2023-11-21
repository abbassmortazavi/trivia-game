<?php

namespace App\Services\Question;

use App\Enums\QuestionType;
use App\Repository\Question\QuestionRepository;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Console\Question\ChoiceQuestion;

class QuestionService implements QuestionInterface
{
    public function __construct(protected QuestionRepository $repository)
    {
    }

    /**
     * @param array $attributes
     * @return Builder|Model|mixed
     */
    public function store(array $attributes): mixed
    {
        return $this->repository->store($attributes);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|array
     */
    public function get(): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->repository->get();
    }

    /**
     * @throws Exception
     */
    public function checkType(string $type, $input, $output, $player2, $question, $helper)
    {
        return match ($type) {
            QuestionType::CHOICE->value => $this->_choiceAnswer($input, $output, $player2, $question, $helper),
            QuestionType::TRUEFALSE->value => $this->_trueFalseAnswer($input, $output, $player2, $question, $helper),
            default => throw new Exception('Not Found Question Type!'),
        };
    }

    /**
     * @param $input
     * @param $output
     * @param $player2
     * @param $question
     * @param $helper
     * @return mixed
     */
    private function _choiceAnswer($input, $output, $player2, $question, $helper): mixed
    {
        $questionText = $question['question'] . "\nOptions: " . implode(', ', $question->answer->answer['options']['choices']) . "\nwrite Your Answer: ";
        $question = new ChoiceQuestion($player2 . ', ' . $questionText, $question->answer->answer['options']['choices']);
        $question->setErrorMessage('Invalid option.');
        return $helper->ask($input, $output, $question);
    }

    /**
     * @param $input
     * @param $output
     * @param $player2
     * @param $question
     * @param $helper
     * @return mixed
     */
    public function _trueFalseAnswer($input, $output, $player2, $question, $helper): mixed
    {
        $questionText = $question['text'] . "\nIs the answer True or False? ";
        $question = new ChoiceQuestion($player2 . ', ' . $questionText, ["true", "false"]);
        $question->setErrorMessage('Invalid answer.');
        return $helper->ask($input, $output, $question);
    }
}
