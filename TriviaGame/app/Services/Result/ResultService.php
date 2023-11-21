<?php

namespace App\Services\Result;

use App\Repository\Result\ResultRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ResultService implements ResultInterface
{
    /**
     * @param ResultRepository $repository
     */
    public function __construct(protected ResultRepository $repository)
    {
    }

    /**
     * @param array $attributes
     * @return Model|Builder
     */
    public function store(array $attributes): Model|Builder
    {
        return $this->repository->store($attributes);
    }
}
