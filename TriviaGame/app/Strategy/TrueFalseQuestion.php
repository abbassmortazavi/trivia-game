<?php

namespace App\Strategy;

use App\Enums\QuestionType;
use App\Services\Question\QuestionService;
use Illuminate\Console\OutputStyle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Question\Question;

class TrueFalseQuestion implements GenerateQuestionStrategy
{

    /**
     * @param InputInterface $input
     * @param OutputStyle $output
     * @param $player1
     * @return mixed
     */
    public function generate(InputInterface $input, OutputStyle $output, $player1): mixed
    {
        $questionText = $this->ask($input, $output, 'Enter the True/False question: ');
        $correctAnswer = $this->ask($input, $output, 'Is the answer True or False? ');

        $data['question_builder'] = $player1;
        $data['question'] = $questionText;
        $data['type'] = QuestionType::TRUEFALSE->value;
        $dataOptions['options'] = [
            'correct_answer' => $correctAnswer === "true",
        ];
        return $this->storeQuestion($data, $dataOptions);
    }

    /**
     * @param InputInterface $input
     * @param OutputStyle $output
     * @param $question
     * @return mixed
     */
    private function ask(InputInterface $input, OutputStyle $output, $question): mixed
    {
        $questionHelper = new QuestionHelper();
        return $questionHelper->ask($input, $output, new Question($question));
    }

    /**
     * @param array $attributes
     * @param $dataOptions
     * @return Builder|Model|mixed
     */
    private function storeQuestion(array $attributes, $dataOptions): mixed
    {
        $question = app(QuestionService::class)->store($attributes);
        $question->answer()->create([
            'answer' => $dataOptions
        ]);
        return $question;
    }
}
