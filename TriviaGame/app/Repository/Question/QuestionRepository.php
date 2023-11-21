<?php

namespace App\Repository\Question;

use App\Models\Question;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class QuestionRepository implements QuestionRepositoryInterface
{
    public function __construct(protected Question $question)
    {
    }

    /**
     * @return Collection|array
     */
    public function get(): Collection|array
    {
        return $this->question->query()->get();
    }

    /**
     * @param array $attributes
     * @return Builder|Model|mixed
     */
    public function store(array $attributes): mixed
    {
        return $this->question->query()->create($attributes);
    }
}
