<?php

namespace App\Services;

use App\Contracts\LinkRepositoryInterface;
use App\Exceptions\SlugException;
use Illuminate\Support\Str;

class SlugService
{
    public function __construct(
        protected LinkRepositoryInterface $linkRepository
    ) {}

    /**
     * Generate a unique slug for a Link.
     *
     * @param  int  $initialLength  Starting slug length
     * @param  int  $maxLength  Maximum slug length
     * @param  int  $attemptsPerLength  How many times to try before increasing length
     * @return string The unique slug
     *
     * @throws SlugException
     */
    public function generate(
        int $initialLength = 6,
        int $maxLength = 10,
        int $attemptsPerLength = 100
    ): string {
        $length = $initialLength;

        while ($length <= $maxLength) {
            for ($i = 0; $i < $attemptsPerLength; $i++) {
                $slug = Str::random($length);

                if (! $this->linkRepository->findBySlug($slug)) {
                    return $slug;
                }
            }

            $length++;
        }

        throw new SlugException('Unable to generate a unique short code');
    }
}
