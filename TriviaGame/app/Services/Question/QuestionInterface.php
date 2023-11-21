<?php

namespace App\Services\Question;

interface QuestionInterface
{
    /**
     * @param array $attributes
     */
    public function store(array $attributes);

    /**
     * @return mixed
     */
    public function get(): mixed;

    public function checkType(string $type, $input, $output, $player2, $question, $helper);
}
