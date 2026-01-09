<?php

namespace App\Services\Util;

use App\Contracts\CodeRepositoryInterface;
use App\Exceptions\CodeGeneratorException;
use Illuminate\Support\Str;

/**
 * Service for generating unique codes
 *
 * it requires a repository that can check for existing codes
 * i.e. one that conforms to CodeRepositoryInterface
 */
class CodeGeneratorService
{
    public function __construct(
        protected CodeRepositoryInterface $repo,
        protected int $initialLength = 6,
        protected int $maxLength = 10,
        protected int $attemptsPerLength = 100
    ) {}

    /**
     * Generate a unique code
     * if a unique code cannot be found within the constraints,
     * an exception is thrown
     *
     * @return string The unique code
     *
     * @throws CodeGeneratorException
     */
    public function generate(): string
    {
        $length = $this->initialLength;

        while ($length <= $this->maxLength) {
            for ($i = 0; $i < $this->attemptsPerLength; $i++) {
                $code = Str::random($length);

                if (! $this->repo->findByCode($code)) {
                    return $code;
                }
            }

            $length++;
        }

        throw new CodeGeneratorException('Unable to generate a unique code');
    }
}
