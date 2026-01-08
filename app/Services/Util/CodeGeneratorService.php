<?php

namespace App\Services\Util;

use App\Contracts\CodeRepositoryInterface;
use App\Exceptions\CodeGeneratorException;
use Illuminate\Support\Str;

class CodeGeneratorService
{
    public function __construct(
        protected CodeRepositoryInterface $repo
    ) {}

    /**
     * Generate a unique code
     *
     * @param  int  $initialLength  Starting length for code generation
     * @param  int  $maxLength  Maximum length for code generation
     * @param  int  $attemptsPerLength  How many times to try before increasing length
     * @return string The unique code
     *
     * @throws CodeGeneratorException
     */
    public function generate(
        int $initialLength = 6,
        int $maxLength = 10,
        int $attemptsPerLength = 100
    ): string {
        $length = $initialLength;

        while ($length <= $maxLength) {
            for ($i = 0; $i < $attemptsPerLength; $i++) {
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
