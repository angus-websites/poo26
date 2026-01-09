<?php

namespace App\Rules;

use App\Services\Util\UrlService;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

/**
 * Validation rule to check if a given value is a valid public URL.
 * this differs from a standard URL validation by ensuring the URL contains a valid host with at least one dot.
 */
class PublicUrl implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param Closure(string, ?string=): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!UrlService::validate($value)) {
            $fail('The :attribute is not a valid public URL.');
        }
    }
}
