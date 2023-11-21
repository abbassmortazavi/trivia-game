<?php

namespace App\Repository\Result;

interface ResultRepositoryInterface
{
    /**
     * @param array $attributes
     * @return mixed
     */
    public function store(array $attributes): mixed;
}
