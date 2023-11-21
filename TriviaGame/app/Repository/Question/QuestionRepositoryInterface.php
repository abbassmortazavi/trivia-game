<?php

namespace App\Repository\Question;

interface QuestionRepositoryInterface
{
    /**
     * @return mixed
     */
    public function get(): mixed;

    /**
     * @param array $attributes
     * @return mixed
     */
    public function store(array $attributes);
}
