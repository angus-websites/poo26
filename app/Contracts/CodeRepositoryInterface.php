<?php

namespace App\Contracts;

/**
 * Interface for repositories that handle entities identified by a code.
 */
interface CodeRepositoryInterface
{
    public function findByCode(string $code);
}
