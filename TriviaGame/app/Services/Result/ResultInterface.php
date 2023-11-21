<?php

namespace App\Services\Result;

interface ResultInterface
{
    /**
     * @param array $attributes
     * @return mixed
     */
    public function store(array $attributes): mixed;
}
