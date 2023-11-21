<?php

namespace App\Repository\Result;

use App\Models\Result;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ResultRepository implements ResultRepositoryInterface
{
    public function __construct(protected Result $result)
    {
    }

    /**
     * @param array $attributes
     * @return Builder|Model
     */
    public function store(array $attributes): Builder|Model
    {
        return $this->result->query()->create($attributes);
    }
}
